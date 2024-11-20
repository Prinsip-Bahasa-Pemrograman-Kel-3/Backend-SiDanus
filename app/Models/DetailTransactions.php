<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransactions extends Model
{
    protected $table = 'detail_transactions';
    protected $fillable = [
        'total_items',
        'transaction_id',
        'product_id'
    ];
    
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}