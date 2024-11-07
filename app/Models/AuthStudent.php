<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthStudent extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'nim',
        'avatar',
        'major_id',
        'organization_id',
        'user_id',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
