<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialData extends Model
{
    use HasFactory;

    public $table = 'material_data';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'category',
        'unit_id',
        'selling_price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getPriceAttribute()
    {
        return 'Rp. ' . number_format($this->selling_price, 0, ',', '.');
    }

    public function unit()
    {
        return $this->belongsTo(UnitData::class, 'unit_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'material_data_id', 'id');
    }
}
