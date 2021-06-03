<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'user_id',
    ];

    use HasFactory;

    /**
     *  Relationship of transactions table to users table.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
