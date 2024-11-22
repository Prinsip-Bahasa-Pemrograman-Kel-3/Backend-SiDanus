<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'nim',
        'avatar',
        // 'major_id',
        // 'organization_id',
        'user_id',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    // public function organization()
    // {
    //     return $this->belongsTo(Organization::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->hasMany(Merchant::class);
    }

    // public function productReview()
    // {
    //     return $this->hasMany(productReview::class);
    // }
}
