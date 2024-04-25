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
        'point',
    ];

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
<<<<<<< HEAD
    }

    public function transactionHistories()
    {
        return $this->hasMany(TransactionHistory::class, 'product_id');
=======
>>>>>>> 183e60f (update from cpanel)
    }
}
