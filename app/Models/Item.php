<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'Itemid';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'name_kh',
        'available',
        'image',
        'qty',
        'borrow',
        'status',
        'description',
    ];

    protected $appends = ['display_name'];

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'item_id', 'Itemid');
    }

    public function getDisplayNameAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'kh' && !empty($this->name_kh)) {
            return $this->name_kh;
        }

        return $this->name ?? $this->name_kh ?? '';
    }
}
