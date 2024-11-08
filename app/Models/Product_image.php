<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product_Image extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image);
    }
}
