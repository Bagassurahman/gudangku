<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'point',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
