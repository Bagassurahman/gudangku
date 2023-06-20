<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riche extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'date',
        'total',
        'debit',
        'sub_total'
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'user_id');
    }
}
