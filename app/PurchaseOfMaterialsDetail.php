<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOfMaterialsDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_of_materials_id',
        'material_id',
        'qty',
        'price',
        'total',
    ];

    public function purchaseOfMaterials()
    {
        return $this->belongsTo(PurchaseOfMaterials::class, 'purchase_of_materials_id');
    }

    public function material()
    {
        return $this->belongsTo(MaterialData::class, 'material_id');
    }
}
