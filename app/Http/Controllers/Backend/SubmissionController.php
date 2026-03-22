<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\Student;
use App\Models\StudentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $submissions = StudentSubmission::query()
            ->with('group')
            ->when($q, function ($query) use ($q) {
                $query->where('student_name', 'like', "%{$q}%")
                    ->orWhere('phone_number', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $submissions->getCollection()->transform(function ($sub) {
            $existing = null;
            $reason = null;

            if (!empty($sub->phone_number)) {
                $existing = Student::where('phone_number', $sub->phone_number)->first();
                if ($existing) {
                    $reason = 'phone';
                }
            }

            if (!$existing) {
                $existing = Student::where('student_name', $sub->student_name)->first();
                if ($existing) {
                    $reason = 'name';
                }
            }

            $sub->existing_student = $existing;
            $sub->existing_reason = $reason;

            return $sub;
        });

        return view('backend.page.submissions.index', compact('submissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female'],
            'phone_number' => ['required', 'string', 'max:30'],
            'group_id' => ['required', 'exists:groups,group_id'],
            'item_id' => ['required', 'exists:items,Itemid'],
            'qty' => ['required', 'integer', 'min:1'],
            // 'status' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $existingStudentByName = Student::where('student_name', $request->student_name)->first();
        $existingStudentByPhone = Student::where('phone_number', $request->phone_number)->first();

        if ($existingStudentByPhone) {
            if (!$existingStudentByName || $existingStudentByPhone->student_id !== $existingStudentByName->student_id) {
                return back()
                    ->withErrors(['phone_number' => __('app.This phone number is already used by another student.')])
                    ->withInput();
            }
        }

        $item = Item::where('Itemid', $request->item_id)->firstOrFail();

        if ($item->qty < $request->qty) {
            return back()
                ->withErrors(['qty' => __('app.Not enough stock available.')])
                ->withInput();
        }

        $duplicateSubmission = StudentSubmission::where('student_name', $request->student_name)
            ->where('phone_number', $request->phone_number)
            ->where('group_id', $request->group_id)
            ->where('item_id', $request->item_id)
            ->where('qty', $request->qty)
            ->where('is_borrow_approved', false)
            ->first();

        if ($duplicateSubmission) {
            return back()
                ->withErrors(['student_name' => 'This form was already submitted and is still pending approval.'])
                ->withInput();
        }

        StudentSubmission::create([
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'group_id' => $request->group_id,
            'item_id' => $request->item_id,
            'qty' => $request->qty,
            'status' => 'BORROWED',
            'note' => $request->notes,
            'student_id' => $existingStudentByName?->student_id,
            'is_student_existing' => $existingStudentByName ? true : false,
            'is_student_added' => $existingStudentByName ? true : false,
            'is_borrow_approved' => false,
        ]);

        return back()->with('success', 'Submitted successfully. Please wait for approval.');
    }

    public function approve(StudentSubmission $submission)
    {
        $existing = null;
        $reason = null;

        $phoneExists = Student::where('phone_number', $submission->phone_number)->exists();

        if ($phoneExists) {
            return back()->withErrors([
                'error' => 'This phone number is already used in student database.',
            ]);
        }

        if (!$existing) {
            $existing = Student::where('student_name', $submission->student_name)->first();
            if ($existing) {
                $reason = 'name';
            }
        }

        if ($existing) {
            if ($reason === 'phone') {
                return back()->withErrors([
                    'student' => "Phone already used by {$existing->student_name} (ID: {$existing->student_id}).",
                ]);
            }

            return back()->withErrors([
                'student' => "Student name already exists: {$existing->student_name} (ID: {$existing->student_id}).",
            ]);
        }

        $student = Student::create([
            'student_name' => $submission->student_name,
            'phone_number' => $submission->phone_number,
            'group_id' => $submission->group_id,
            'gender' => $submission->gender,
            'status' => 1,
        ]);

        $submission->delete();

        return redirect()->route('students.index')->with('success', 'Student added to database.');
    }

    public function destroy(StudentSubmission $submission)
    {
        $submission->delete();

        return back()->with('success', 'Submission canceled.');
    }

    public function goManage(StudentSubmission $submission)
    {
        $student = null;

        if (!empty($submission->phone_number)) {
            $student = Student::where('phone_number', $submission->phone_number)->first();
        }

        if (!$student) {
            $student = Student::where('student_name', $submission->student_name)->first();
        }

        if (!$student) {
            return back()->withErrors(['student' => 'Student not found in database.']);
        }

        $submission->delete();

        return redirect()->to(
            url(
                'admin/borrows?openBorrow=1'
                . '&student_id=' . $student->student_id
                . '&student_name=' . urlencode($student->student_name)
            )
        )->with('success', 'Submission cleared. You can borrow item now.');
    }

    public function addStudent($id)
    {
        $submission = StudentSubmission::findOrFail($id);

        if ($submission->student_id) {
            return back()->with('success', 'Student already exists.');
        }

        $phoneExists = Student::where('phone_number', $submission->phone_number)->first();

        if ($phoneExists) {
            return back()->withErrors([
                'error' => 'This phone number is already used in student database.',
            ]);
        }

        $student = Student::create([
            'student_name' => $submission->student_name,
            'gender' => $submission->gender,
            'phone_number' => $submission->phone_number,
            'group_id' => $submission->group_id,
            'status' => 1,
        ]);

        $submission->update([
            'student_id' => $student->student_id,
            'is_student_added' => true,
        ]);

        return back()->with('success', 'Student added successfully. Now you can approve borrow.');
    }

    public function approveBorrow($id)
    {
        $submission = StudentSubmission::findOrFail($id);

        if (!$submission->student_id) {
            return back()->withErrors(['error' => 'Please add the student first.']);
        }

        if ($submission->is_borrow_approved) {
            return back()->with('success', 'Borrow already approved.');
        }

        $item = Item::where('Itemid', $submission->item_id)->firstOrFail();

        if ($item->qty < $submission->qty) {
            return back()->withErrors(['error' => 'Not enough stock to approve this borrow.']);
        }

        $borrow = Borrow::create([
            'student_id' => $submission->student_id,
            'item_id' => $submission->item_id,
            'borrow_date' => now('Asia/Jakarta'),
            'qty' => $submission->qty,
            'status' => 'BORROWED',
            'notes' => $submission->note,
            'approved_by' => Auth::id(),
        ]);

        $item->decrement('qty', $submission->qty);

        $student = Student::where('student_id', $submission->student_id)->first();

        ItemHistory::create([
            'borrow_id' => $borrow->id,
            'student_id' => $borrow->student_id,
            'item_id' => $borrow->item_id,
            'user_id' => Auth::id(),
            'approved_by' => $borrow->approved_by,
            'returned_by' => null,
            'action' => 'Borrowed',
            'details' => (Auth::user()?->name ?? 'System') . ' borrowed ' . $borrow->qty . ' x ' . ($item->name ?? '-') . ' for ' . ($student->student_name ?? '-') . '.',
            'action_at' => $borrow->borrow_date,
        ]);

        $submission->update([
            'is_borrow_approved' => true,
        ]);

        return back()->with('success', 'Borrow approved successfully.');
    }

    public function remove($id)
    {
        $submission = StudentSubmission::findOrFail($id);
        $submission->delete();

        return back()->with('success', 'Submission removed successfully.');
    }

    public function cancelAll()
    {
        StudentSubmission::query()->delete();

        return back()->with('success', 'All submissions cancelled successfully.');
    }
}