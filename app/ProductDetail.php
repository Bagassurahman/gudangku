<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'material_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
