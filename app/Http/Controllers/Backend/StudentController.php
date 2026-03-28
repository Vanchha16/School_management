<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::orderBy('group_name')->get();

        $studentsQuery = Student::with('group');

        if ($request->filled('q')) {
            $q = trim($request->q);

            $studentsQuery->where(function ($query) use ($q) {
                $query->where('student_name', 'like', "%{$q}%")
                    ->orWhere('phone_number', 'like', "%{$q}%")
                    ->orWhereHas('group', function ($groupQuery) use ($q) {
                        $groupQuery->where('group_name', 'like', "%{$q}%");
                    });

                if (strtolower($q) === 'active') {
                    $query->orWhere('status', 1);
                }

                if (strtolower($q) === 'inactive') {
                    $query->orWhere('status', 0);
                }
            });
        }

        $students = $studentsQuery->orderByDesc('student_id')
            ->paginate(10)
            ->withQueryString();

        $statTotal = Student::count();
        $statActive = Student::where('status', 1)->count();
        $statInactive = Student::where('status', 0)->count();

        return view('backend.page.students.index', compact(
            'students',
            'groups',
            'statTotal',
            'statActive',
            'statInactive'
        ));
    }

    public function store(Request $request)
    {
        $messages = [
            'student_name.unique' => 'This student name already exists in this group.',
            'phone_number.unique' => 'This phone number already exists.',
        ];

        $data = $request->validate([
            'student_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('students')->where(function ($q) use ($request) {
                    return $q->where('group_id', $request->group_id);
                }),
            ],
            'gender' => ['required', 'in:Male,Female'],
            'phone_number' => ['nullable', 'string', 'max:50', 'unique:students,phone_number'],
            'group_id' => ['required', 'exists:groups,group_id'],
            'status' => ['required', 'in:0,1'],
        ], $messages);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added.');
    }

    public function show($studentid)
    {
        $student = Student::with('group')->where('student_id', $studentid)->firstOrFail();

        return view('backend.page.students.show', compact('student'));
    }

    public function update(Request $request, $student_id)
    {
        $student = Student::where('student_id', $student_id)->firstOrFail();

        $messages = [
            'student_name.unique' => 'This student name already exists in this group.',
        ];

        $data = $request->validate([
            'student_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('students')
                    ->where(fn ($q) => $q->where('group_id', $request->group_id))
                    ->ignore($student->student_id, 'student_id'),
            ],
            'gender' => ['required', 'in:Male,Female'],
            'phone_number' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('students', 'phone_number')->ignore($student->student_id, 'student_id'),
            ],
            'group_id' => ['required', 'exists:groups,group_id'],
            'status' => ['required', 'in:0,1'],
        ], $messages);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy($student_id)
    {
        Student::where('student_id', $student_id)->firstOrFail()->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted!');
    }
}
