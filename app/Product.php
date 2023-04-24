<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'general_price',
        'member_price',
        'online_price',
    ];

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }


    public function getGeneralPriceAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getMemberPriceAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getOnlinePriceAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}
