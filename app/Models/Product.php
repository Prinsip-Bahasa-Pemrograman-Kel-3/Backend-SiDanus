<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;



    class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'stock',
        'minimum_order',
        'description',
        'product_category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function merchants(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transactions::class, 'detail_transactions', 'product_id', 'transaction_id')
            ->withPivot('active', 'total_items');
    }
}
