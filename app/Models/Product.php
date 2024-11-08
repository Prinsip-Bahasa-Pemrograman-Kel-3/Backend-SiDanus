<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    public function category()
    {
        return $this->belongsTo(Product_Category::class);
    }

    public function images()
    {
        return $this->hasMany(Product_Image::class);
    }

    public function reviews()
    {
        return $this->hasMany(Product_Review::class);
    }

    // public function merchants()
    // {
    //     return $this->belongsTo(Merchants::class);
    // }

    // public function detail_transactions()
    // {
    //     return $this->hasMany(Detail_Transaction::class);
    // }
}
