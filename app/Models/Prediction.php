<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sensor;

class Prediction extends Model
{
    protected $table = 'predictions';
    protected $fillable = ['sensor_id','features','prediction'];

    protected $casts = [
        'features' => 'array',
        'prediction' => 'float',
    ];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }
}
