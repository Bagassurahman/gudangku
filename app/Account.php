<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'account_number'];

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
