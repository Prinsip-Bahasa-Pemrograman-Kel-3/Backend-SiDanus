<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'date',
        'status',
        'total_amount',
        'merchant_id',
        'shipment_type_id',
        'payment_type_id'
    ];

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'detail_transactions', 'transaction_id', 'product_id')
            ->withPivot('active','total_items');
    }
    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentTypes::class);
    }

    public function shipmentType(): BelongsTo
    {
        return $this->belongsTo(ShipmentTypes::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transactionCancellation(): HasOne
    {
        return $this->hasOne(TransactionsCancellations::class, 'transaction_id');
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}
