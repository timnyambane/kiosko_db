<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'units',
        'stock',
        'b_price',
        's_price',
        'code'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
