<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReasonTransactionsCancellations extends Model
{
    protected $table = 'reason_transactions_cancellations';
    protected $fillable = [
        'reason'
    ];

    public function TransactionsCancellations(): HasOne
    {
        return $this->hasOne(TransactionsCancellations::class);
    }
}
