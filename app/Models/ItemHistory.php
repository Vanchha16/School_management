<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    protected $fillable = [
    'borrow_id',
    'student_id',
    'item_id',
    'user_id',
    'approved_by',
    'returned_by',
    'action',
    'details',
    'action_at',
];

    protected $casts = [
        'action_at' => 'datetime',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'Itemid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnedByUser()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
