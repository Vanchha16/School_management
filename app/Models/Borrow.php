<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'student_id',
        'item_id',
        'qty',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
        'condition',
        'return_notes',
        'approved_by',
        'returned_by',
        'call_status',
        'call_note',
        'called_at',
        'called_by',
        'deleted_by',
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
        'called_at' => 'datetime',
        'deleted_at'  => 'datetime', 
    ];



    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'Itemid');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnedByUser()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
    public function calledByUser()
    {
        return $this->belongsTo(User::class, 'called_by');
    }
     public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
