<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'reward_id',
        'outlet_id',
        'point',
        'status',
        'note',
        'approved_at',
        'rejected_at',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function getApprovedAtAttribute($value)
    {
        return $value ? date('d F Y H:i', strtotime($value)) : null;
    }

    public function getRejectedAtAttribute($value)
    {
        return $value ? date('d F Y H:i', strtotime($value)) : null;
    }

    public function getCompletedAtAttribute($value)
    {
        return $value ? date('d F Y H:i', strtotime($value)) : null;
    }
}
