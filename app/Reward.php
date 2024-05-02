<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'point',
        'image',
        'description',
        'stock',
    ];

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value->store('assets/reward', 'public');
    }

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function requests()
    {
        return $this->hasMany(RequestReward::class);
    }
}
