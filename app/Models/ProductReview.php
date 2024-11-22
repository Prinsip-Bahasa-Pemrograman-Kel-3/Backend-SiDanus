<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $fillable = [
        'product_id',
        'user_id',
        'review',
        'rate'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactions::class);
    }
}
