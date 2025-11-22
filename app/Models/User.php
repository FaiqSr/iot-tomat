<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User has one address record.
     */
    public function address() : HasOne
    {
        return $this->hasOne(UserAddress::class);
    }

    /**
     * Tools owned by the user via tool_owners pivot table.
     */
    public function tools() : BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Tools::class, 'tool_owners', 'user_id', 'tool_id');
    }

    /**
     * Sensors owned by the user via sensor_owners pivot table.
     */
    public function sensors() : BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sensor::class, 'sensor_owners', 'user_id', 'sensor_id');
    }
}
