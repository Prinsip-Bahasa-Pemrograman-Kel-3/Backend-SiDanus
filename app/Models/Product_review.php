<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Review extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
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

    public function students()
    {
        return $this->belongsTo(students::class);
    }

    public function transactions()
    {
        return $this->belongsTo(transactions::class);
    }
}
