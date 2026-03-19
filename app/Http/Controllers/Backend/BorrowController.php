<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Group;
use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        Borrow::query()
            ->where('status', 'BORROWED')
            ->whereNull('return_date')
            ->where('borrow_date', '<', now()->subDays(3))
            ->update(['status' => 'OVERDUE']);

        $students = Student::orderBy('student_name')->get();
        $items = Item::orderBy('name')->get();
        $groups = Group::orderBy('group_name')->get();

        $query = Borrow::with([
            'student.group',
            'item',
            'approvedByUser',
            'returnedByUser',
        ]);

        $filter = $request->filter;
$search = $request->search;

if ($filter == 'student_name' && $request->filled('search')) {
    $query->whereHas('student', function ($q) use ($search) {
        $q->where('student_name', 'like', "%{$search}%");
    });
}

if ($filter == 'item_name' && $request->filled('item_id')) {
    $query->where('item_id', $request->item_id);
}

if ($filter == 'group_name' && $request->filled('search')) {
    $query->whereHas('student.group', function ($q) use ($search) {
        $q->where('group_name', 'like', "%{$search}%");
    });
}

if ($filter == 'status' && $request->filled('status')) {
    $query->where('status', $request->status);
}
        $activeBorrows = Borrow::with([
            'student',
            'item',
            'approvedByUser',
            'returnedByUser',
        ])
            ->whereIn('status', ['BORROWED', 'OVERDUE', 'RETURNED'])
            ->orderByDesc('borrow_date')
            ->get();

        $borrows = $query->orderByDesc('id')->paginate(5)->withQueryString();

        $stats = [
            'total_records'    => Borrow::count(),
            'active_records'   => Borrow::where('status', 'BORROWED')->count(),
            'overdue_records'  => Borrow::where('status', 'OVERDUE')->count(),
            'returned_records' => Borrow::where('status', 'RETURNED')->count(),
            'total_qty'        => Borrow::sum('qty'),
            'borrowed_qty'     => Borrow::where('status', 'BORROWED')->sum('qty'),
            'returned_qty'     => Borrow::where('status', 'RETURNED')->sum('qty'),
        ];

        return view('backend.page.borrows.index', compact(
            'students',
            'items',
            'groups',
            'activeBorrows',
            'borrows',
            'stats'
        ));
    }

    public function storeBorrow(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,student_id'],
            'item_id'    => ['required', 'exists:items,Itemid'],
            'qty'        => ['required', 'integer', 'min:1'],
            'due_date'   => ['nullable', 'date', 'after_or_equal:today'],
            'notes'      => ['nullable', 'string', 'max:1000'],
        ]);

        $item = Item::where('Itemid', $data['item_id'])->firstOrFail();

        if (($item->qty ?? 0) < $data['qty']) {
            return back()
                ->withErrors(['qty' => "Not enough stock. Available: {$item->qty}"])
                ->withInput();
        }

        $borrow = Borrow::create([
            'student_id'  => $data['student_id'],
            'item_id'     => $data['item_id'],
            'qty'         => $data['qty'],
            'borrow_date' => now('Asia/Jakarta'),
            'due_date'    => $data['due_date'] ?? null,
            'status'      => 'BORROWED',
            'notes'       => $data['notes'] ?? null,
            'approved_by' => Auth::id(),
        ]);

        $item->decrement('qty', $data['qty']);

        $student = Student::where('student_id', $data['student_id'])->first();

        ItemHistory::create([
            'borrow_id'   => $borrow->id,
            'student_id'  => $borrow->student_id,
            'item_id'     => $borrow->item_id,
            'user_id'     => Auth::id(),
            'approved_by' => $borrow->approved_by,
            'returned_by' => null,
            'action'      => 'Borrowed',
            'details'     => (Auth::user()?->name ?? 'System') . ' borrowed ' . $borrow->qty . ' x ' . ($item->name ?? '-') . ' for ' . ($student->student_name ?? '-') . '.',
            'action_at'   => $borrow->borrow_date,
        ]);

        return redirect()->route('borrows.index')->with('success', 'Borrow saved.');
    }

    public function storeReturn(Request $request)
    {
        $data = $request->validate([
            'borrow_id' => [
                'required',
                'exists:borrows,id',
                Rule::exists('borrows', 'id')->where(function ($q) {
                    $q->whereIn('status', ['BORROWED', 'OVERDUE']);
                }),
            ],
            'return_date'  => ['required', 'date_format:Y-m-d\TH:i'],
            'condition'    => ['required', 'string', 'max:50'],
            'return_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $borrow = Borrow::with(['student', 'item', 'approvedByUser'])
            ->where('id', $data['borrow_id'])
            ->whereIn('status', ['BORROWED', 'OVERDUE'])
            ->firstOrFail();

        Item::where('Itemid', $borrow->item_id)->increment('qty', $borrow->qty);

        $returnDate = Carbon::createFromFormat('Y-m-d\TH:i', $data['return_date'], 'Asia/Jakarta');

        $borrow->update([
            'return_date'  => $returnDate,
            'condition'    => $data['condition'],
            'return_notes' => $data['return_notes'] ?? null,
            'status'       => 'RETURNED',
            'returned_by'  => Auth::id(),
        ]);

        ItemHistory::create([
            'borrow_id'   => $borrow->id,
            'student_id'  => $borrow->student_id,
            'item_id'     => $borrow->item_id,
            'user_id'     => Auth::id(),
            'approved_by' => $borrow->approved_by,
            'returned_by' => $borrow->returned_by,
            'action'      => 'Returned',
            'details'     => (Auth::user()?->name ?? 'System') . ' returned ' . $borrow->qty . ' x ' . ($borrow->item->name ?? '-') . ' from ' . ($borrow->student->student_name ?? '-') . '.',
            'action_at'   => $returnDate,
        ]);

        return redirect()->route('borrows.index')->with('success', 'Return saved.');
    }

    public function undoReturn(Request $request, Borrow $borrow)
    {
        if ($borrow->status !== 'RETURNED') {
            return back()->withErrors([
                'status' => 'Only RETURNED records can be undone.',
            ]);
        }

        $borrow->load(['student', 'item']);

        $item = Item::where('Itemid', $borrow->item_id)->firstOrFail();

        if (($item->qty ?? 0) < ($borrow->qty ?? 1)) {
            return back()->withErrors([
                'qty' => "Cannot undo return. Item stock is too low now (Available: {$item->qty}).",
            ]);
        }

        $oldReturnedBy = $borrow->returned_by;

        $item->decrement('qty', $borrow->qty ?? 1);

        $borrow->update([
            'status'       => 'BORROWED',
            'return_date'  => null,
            'condition'    => null,
            'return_notes' => null,
            'returned_by'  => null,
        ]);

        ItemHistory::create([
            'borrow_id'   => $borrow->id,
            'student_id'  => $borrow->student_id,
            'item_id'     => $borrow->item_id,
            'user_id'     => Auth::id(),
            'approved_by' => $borrow->approved_by,
            'returned_by' => $oldReturnedBy,
            'action'      => 'Undo return',
            'details'     => (Auth::user()?->name ?? 'System') . ' undid the return for ' . $borrow->qty . ' x ' . ($borrow->item->name ?? '-') . ' from ' . ($borrow->student->student_name ?? '-') . '.',
            'action_at'   => now('Asia/Jakarta'),
        ]);

        return redirect()->route('borrows.index')->with('success', 'Return undone. Status is BORROWED again.');
    }

    public function destroy(Borrow $borrow)
    {
        if ($borrow->status === 'BORROWED') {
            Item::where('Itemid', $borrow->item_id)->increment('qty', $borrow->qty ?? 1);
        }

        $borrow->delete();

        return redirect()->route('borrows.index')->with('success', 'Borrow record deleted.');
    }

    public function lateReturns(Request $request)
    {
        $q = $request->q;

        $lateReturns = Borrow::with(['student', 'item'])
            ->whereNotNull('return_date')
            ->whereRaw('TIMESTAMPDIFF(HOUR, borrow_date, return_date) > 72')
            ->when($q, function ($query) use ($q) {
                $query->whereHas('student', function ($s) use ($q) {
                    $s->where('student_name', 'like', "%$q%");
                })->orWhereHas('item', function ($i) use ($q) {
                    $i->where('name', 'like', "%$q%");
                });
            })
            ->orderByDesc('return_date')
            ->paginate(10);

        return view('backend.page.borrows.late_returns', compact('lateReturns'));
    }

    public function overdueBorrows(Request $request)
    {
        $q = $request->get('q');

        $query = Borrow::query()
            ->whereNull('return_date')
            ->where('borrow_date', '<', now()->subDays(3))
            ->whereIn('status', ['BORROWED', 'OVERDUE'])
            ->with(['student', 'item']);

        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->whereHas('student', function ($s) use ($q) {
                    $s->where('student_name', 'like', "%{$q}%")
                        ->orWhere('phone_number', 'like', "%{$q}%");
                })->orWhereHas('item', function ($i) use ($q) {
                    $i->where('name', 'like', "%{$q}%");
                });
            });
        }

        $overdues = $query
            ->orderBy('borrow_date', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('backend.page.borrows.overdue', compact('overdues'));
    }


    public function itemHistory(Request $request)
    {
        $query = ItemHistory::with([
            'user',
            'approvedByUser',
            'returnedByUser',
            'borrow.student',
            'borrow.item'
        ]);

        if ($request->filled('student')) {
            $query->whereHas('borrow.student', function ($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->student . '%');
            });
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        $histories = $query
            ->latest('action_at')
            ->paginate(5);

        return view('backend.page.borrows.history', compact('histories'));
    }
    public function update(Request $request)
    {
        $borrow = Borrow::findOrFail($request->borrow_id);

        // Prevent editing returned borrow
        if ($borrow->status === 'RETURNED') {
            return back()->withErrors([
                'error' => 'Cannot edit a returned borrow record.'
            ]);
        }

        $oldItemId = $borrow->item_id;
        $oldQty = $borrow->qty;

        $newItemId = $request->item_id;
        $newQty = $request->qty;

        // Restore old stock
        $oldItem = Item::find($oldItemId);
        if ($oldItem) {
            $oldItem->increment('qty', $oldQty);
        }

        // Check new stock
        $newItem = Item::findOrFail($newItemId);

        if ($newItem->qty < $newQty) {

            // rollback old stock restore
            $oldItem->decrement('qty', $oldQty);

            return back()->withErrors([
                'error' => 'Not enough stock for selected item.'
            ]);
        }

        // reduce new stock
        $newItem->decrement('qty', $newQty);

        $borrow->update([
            'student_id' => $request->student_id,
            'item_id' => $newItemId,
            'qty' => $newQty
        ]);

        return back()->with('success', 'Borrow updated successfully.');
    }
}
