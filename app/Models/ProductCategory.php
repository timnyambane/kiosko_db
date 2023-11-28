<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "category",
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
}
