<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_number',
        'deposit_date',
        'warehouse_id',
        'outlet_id',
        'account_number',
        'amount',
        'omset',
        'online',
        'shoppe_pay',
        'cash_journal',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }
}
