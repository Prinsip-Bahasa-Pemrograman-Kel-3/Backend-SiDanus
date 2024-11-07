<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantSubmission extends Model
{
    use HasFactory;

    protected $table = 'merchant_submission';

    protected $fillable = [
        'name',
        'merchant_id',
    ];

    /**
     * Relationship with the Merchant model.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
