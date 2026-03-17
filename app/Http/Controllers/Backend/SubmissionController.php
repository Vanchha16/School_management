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

    /*
    |------------------------------------------------------------------
    | LIST SUBMISSIONS
    |------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $q = $request->get('q');

        $submissions = StudentSubmission::with(['group','item'])
            ->when($q,function($query) use ($q){
                $query->where('student_name','like',"%{$q}%")
                      ->orWhere('phone_number','like',"%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.page.submissions.index',compact('submissions'));
    }



    /*
    |------------------------------------------------------------------
    | STORE SUBMISSION
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'phone_number' => 'required|string|max:30',
            'group_id' => 'required|exists:groups,group_id',
            'item_id' => 'required',
            'other_item' => ['nullable', 'string', 'max:255', 'required_if:item_id,other'],
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $existingStudent = Student::where('student_name',$request->student_name)->first();

        /*
        |--------------------------------
        | ITEM HANDLING
        |--------------------------------
        */

        if($request->item_id === 'other'){

            // create item automatically if not exists
            $item = Item::firstOrCreate(
                ['name' => $request->other_item],
                [
                    'qty' => 3,
                    'status' => 1
                ]
            );

        }else{

            $item = Item::where('Itemid',$request->item_id)->firstOrFail();

            if($item->qty < $request->qty){
                return back()->withErrors([
                    'qty'=>'Not enough stock available.'
                ])->withInput();
            }
        }


        /*
        |--------------------------------
        | CREATE SUBMISSION
        |--------------------------------
        */

        StudentSubmission::create([
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'group_id' => $request->group_id,
            'item_id' => $item->Itemid,
            'other_item' => null,
            'qty' => $request->qty,
            'status' => 'BORROWED',
            'note' => $request->notes,
            'student_id' => $existingStudent?->student_id,
            'is_student_existing' => $existingStudent ? true : false,
            'is_student_added' => $existingStudent ? true : false,
            'is_borrow_approved' => false,
        ]);

        return back()->with('success','Submitted successfully. Please wait for approval.');
    }



    /*
    |------------------------------------------------------------------
    | APPROVE BORROW
    |------------------------------------------------------------------
    */

    public function approveBorrow($id)
    {
        $submission = StudentSubmission::findOrFail($id);

        if(!$submission->student_id){
            return back()->withErrors([
                'error'=>'Please add the student first.'
            ]);
        }

        if($submission->is_borrow_approved){
            return back()->with('success','Borrow already approved.');
        }

        $item = Item::where('Itemid',$submission->item_id)->first();

        if(!$item){
            return back()->withErrors(['error'=>'Item not found']);
        }

        if($item->qty < $submission->qty){
            return back()->withErrors(['error'=>'Not enough stock available']);
        }


        /*
        |--------------------------------------------------
        | CREATE BORROW
        |--------------------------------------------------
        */

        $borrow = Borrow::create([
            'student_id' => $submission->student_id,
            'item_id' => $item->Itemid,
            'borrow_date' => now(),
            'qty' => $submission->qty,
            'status' => 'BORROWED',
            'notes' => $submission->note,
            'approved_by' => Auth::id()
        ]);


        /*
        |--------------------------------------------------
        | REDUCE STOCK
        |--------------------------------------------------
        */

        $item->decrement('qty',$submission->qty);


        /*
        |--------------------------------------------------
        | CREATE HISTORY
        |--------------------------------------------------
        */

        $student = Student::where('student_id',$submission->student_id)->first();

        ItemHistory::create([
            'borrow_id' => $borrow->id,
            'student_id' => $borrow->student_id,
            'item_id' => $borrow->item_id,
            'user_id' => Auth::id(),
            'approved_by' => Auth::id(),
            'returned_by' => null,
            'action' => 'Borrowed',
            'details' =>
                (Auth::user()->name ?? 'System')
                .' borrowed '.$borrow->qty
                .' x '.$item->name
                .' for '.($student->student_name ?? '-'),
            'action_at' => now()
        ]);


        $submission->update([
            'is_borrow_approved'=>true
        ]);

        return back()->with('success','Borrow approved successfully.');
    }



    /*
    |------------------------------------------------------------------
    | REMOVE SUBMISSION
    |------------------------------------------------------------------
    */

    public function remove($id)
    {
        StudentSubmission::findOrFail($id)->delete();
        return back()->with('success','Submission removed.');
    }



    /*
    |------------------------------------------------------------------
    | CANCEL ALL
    |------------------------------------------------------------------
    */

    public function cancelAll()
    {
        StudentSubmission::query()->delete();
        return back()->with('success','All submissions cancelled.');
    }

}

