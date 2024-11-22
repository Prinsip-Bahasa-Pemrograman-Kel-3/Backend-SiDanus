<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'current_team_id',
        'remember_token',
        'is_active',
    ];

    protected $dates = [
        'email_verified_at',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}