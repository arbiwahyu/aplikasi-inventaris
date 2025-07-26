<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    //
    protected $fillable = [
        'item_id',
        'user_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
