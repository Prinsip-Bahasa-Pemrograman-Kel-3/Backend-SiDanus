<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantOperationalTimes extends Model
{
    use HasFactory;

    protected $table = 'merchant_operational_times';

    protected $fillable = [
        'day_id',
        'merchant_id',
    ];

    // Relasi ke model Days
    public function day()
    {
        return $this->belongsTo(Days::class, 'day_id');
    }

    // Relasi ke model Merchants
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
