<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_id',
        'material_id',
        'quantity',
        'total'
    ];

    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
