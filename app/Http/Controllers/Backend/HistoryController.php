<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ItemHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
public function index(Request $request)
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
}
