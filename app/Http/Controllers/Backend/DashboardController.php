<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Group;
use App\Models\Item;
use App\Models\Borrow;
use App\Models\StudentSubmission;
use App\Models\Submission;
class DashboardController extends Controller
{
    
public function index()
{
    $totalStudents = Student::count();
    $activeStudents = Student::where('status', 1)->count();
    $inactiveStudents = Student::where('status', 0)->count();
    
    $totalGroups = Group::count();

    $totalItems = Item::count();
    $availableItems = Item::sum('qty');
    $borrowedItems = Borrow::where('status', 'BORROWED')->sum('qty');

    $pendingSubmissions = StudentSubmission::where('is_borrow_approved', false)->count();
    
    $recentSubmissions = StudentSubmission::with(['group', 'item'])
        ->latest()
        ->take(5)
        ->get();

    $recentBorrows = Borrow::with(['student', 'item'])
        ->latest('borrow_date')
        ->take(5)
        ->get();

    return view('backend.dashboard.index', compact(
        'totalStudents',
        'activeStudents',
        'inactiveStudents',
        'totalGroups',
        'totalItems',
        'availableItems',
        'borrowedItems',
        'pendingSubmissions',
        'recentSubmissions',
        'recentBorrows'
    ));
}
}
