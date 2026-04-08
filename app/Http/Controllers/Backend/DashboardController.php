<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Group;
use App\Models\Item;
use App\Models\Student;
use App\Models\StudentSubmission;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 1)->count();
        $inactiveStudents = Student::where('status', 0)->count();

        $totalGroups = Group::count();

        $totalItems = Item::count();
        $imageSocket = Item::select('image')->where('Itemid', 1)->first();


        $socketItems = Item::where('name', 'Socket')->sum('qty');
        $availableItems = Item::sum('qty');
        $borrowedItems = Borrow::where('status', 'BORROWED')->sum('qty');
        $totalOut = Borrow::where('item_id', 1)
            ->whereNull('return_date')
            ->where(function ($query) {
                $query->where('status', 'borrowed')
                    ->orWhere('due_date', '<', Carbon::now());
            })
            ->count();

        $pendingSubmissions = StudentSubmission::where('is_borrow_approved', false)->count();

        $overdueCount = Borrow::where('status', 'OVERDUE')->count();

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
            'socketItems',
            'availableItems',
            'borrowedItems',
            'totalOut',
            'pendingSubmissions',
            'overdueCount',
            'recentSubmissions',
            'recentBorrows',
            'imageSocket'
        ));
    }
}
