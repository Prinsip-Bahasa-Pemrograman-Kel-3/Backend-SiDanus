<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = [
        'name',
    ];

    // Relasi ke MerchantOperationalTimes
    public function merchantOperationalTimes()
    {
        return $this->hasMany(MerchantOperationalTimes::class, 'day_id');
    }
}
