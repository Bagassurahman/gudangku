<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_data_id',
        'warehouse_id',
        'entry_amount',
        'exit_amount',
        'remaining_amount',
        'hpp'
    ];

    public function warehouse()
    {
        return $this->belongsTo(User::class, 'warehouse_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(MaterialData::class, 'material_data_id', 'id');
    }

    public function getHppAttribute()
    {
        return 'Rp. ' . number_format($this->attributes['hpp'], 0, ',', '.');
    }

    public function getEntryAmountAttribute()
    {
        return number_format($this->attributes['entry_amount'], 0, ',', '.');
    }

    public function getExitAmountAttribute()
    {
        return number_format($this->attributes['exit_amount'], 0, ',', '.');
    }
}
