<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'distribution_number',
        'distribution_date',
        'outlet_id',
        'fee'
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function distributionDetails()
    {
        return $this->hasMany(DistributionDetail::class);
    }
}
