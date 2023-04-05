<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'general_price',
        'member_price',
        'online_price',
        'stock'
    ];

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
