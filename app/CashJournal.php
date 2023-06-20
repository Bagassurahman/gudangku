<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'date',
    ];

    public function detail()
    {
        return $this->hasMany(CashJournalDetail::class);
    }
}
