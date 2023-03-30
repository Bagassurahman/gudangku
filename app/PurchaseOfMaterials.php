<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOfMaterials extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'po_date',
        'supplier_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseOfMaterialsDetails()
    {
        return $this->hasMany(PurchaseOfMaterialsDetail::class, 'purchase_of_materials_id');
    }
}
