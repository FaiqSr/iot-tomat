<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class UserAddress extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'country',
        'province',
        'city',
        'postal_code',
    ];

    /**
     * Address belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
