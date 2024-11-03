<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'review',
        'rate'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
