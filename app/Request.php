<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'warehouse_id',
        'code',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(RequestDetail::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'user_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(User::class);
    }
}
