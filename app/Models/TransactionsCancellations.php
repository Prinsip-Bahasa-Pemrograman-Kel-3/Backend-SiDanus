<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionsCancellations extends Model
{
    protected $table = 'transactions_cancellations';
    protected $fillable = [
        'transaction_id',
        'reason_id',
        'description',
        'reason_cancellation_id'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactions::class);
    }

    public function reason():BelongsTo
    {
        return $this->belongsTo(ReasonTransactionsCancellations::class);
    }
}
