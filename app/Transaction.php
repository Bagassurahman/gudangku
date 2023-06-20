<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'order_date',
        'outlet_id',
        'paid_amount',
        'total',
        'payment_method',
        'customer_type'
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'user_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
