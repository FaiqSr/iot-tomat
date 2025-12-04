<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorOwner extends Model
{
    protected $table = 'sensor_owners';

    protected $fillable = [
        'sensor_id',
        'user_id',
    ];
}
