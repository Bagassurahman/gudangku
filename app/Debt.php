<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'warehouse_id',
        'date',
        'amount',
        'status',
    ];

    public function warehouse()
    {
        return $this->belongsTo(User::class, 'warehouse_id', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'user_id');
    }
}
