<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'balance'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }


    public static function addBalance($account_id, $amount)
    {
        $balance = Balance::where('account_id', $account_id)->first();
        $balance->balance += $amount;
        $balance->save();
    }

    public static function reduceBalance($account_id, $amount)
    {
        $balance = Balance::where('account_id', $account_id)->first();
        $balance->balance -= $amount;
        $balance->save();
    }
}
