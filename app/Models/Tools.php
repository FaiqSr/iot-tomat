<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ToolOwner;

class Tools extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    /**
     * Tool has many owners (pivot records).
     */
    public function owners(): HasMany
    {
        return $this->hasMany(ToolOwner::class, 'tool_id');
    }
}
