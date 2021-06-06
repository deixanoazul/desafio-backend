<?php

namespace App\Models;

use App\Traits\HasUUID;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model {
    use HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'amount',
        'type',
        'user_id',
    ];

    /**
     * Get the owner of this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
