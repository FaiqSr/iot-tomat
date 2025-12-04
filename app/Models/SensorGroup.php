<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SensorGroup extends Model
{
    protected $table = 'sensor_groups';

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * Sensors that belong to this group.
     */
    public function sensors() : BelongsToMany
    {
        return $this->belongsToMany(Sensor::class, 'sensor_group_sensor', 'sensor_group_id', 'sensor_id')->withTimestamps();
    }
}
