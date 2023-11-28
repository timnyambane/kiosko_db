<?php

namespace App\Models;

use App\Models\Party;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'business_address',
        'owner_name',
        'business_phone',
        'business_category',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function parties()
    {
        return $this->hasMany(Party::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function prod_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
