<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'material_id',
        'qty',

    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function material()
    {
        return $this->belongsTo(MaterialData::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
