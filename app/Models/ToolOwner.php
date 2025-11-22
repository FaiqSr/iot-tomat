<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Tools;

class ToolOwner extends Model
{
    protected $fillable = [
        'tool_id',
        'user_id',
    ];

    /**
     * Owner belongs to a tool.
     */
    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tools::class, 'tool_id');
    }

    /**
     * Owner belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
