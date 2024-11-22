<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentTypes extends Model
{
    protected $table = 'payment_types';
    protected $fillable = [
        'name'
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transactions::class);
    }
}
