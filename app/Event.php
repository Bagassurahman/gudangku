<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'slug',
        'description',
        'date',
        'time',
        'location',
        'image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFormattedDateAttribute()
    {
        return date('F d, Y', strtotime($this->date));
    }

    public function getFormattedTimeAttribute()
    {
        return date('h:i A', strtotime($this->time));
    }

    public function getFormattedDateTimeAttribute()
    {
        return date('F d, Y h:i A', strtotime($this->date . ' ' . $this->time));
    }

    public function getFormattedLocationAttribute()
    {
        return ucwords($this->location);
    }

    public function getFormattedDescriptionAttribute()
    {
        return ucfirst($this->description);
    }

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
