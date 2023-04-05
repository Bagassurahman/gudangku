<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'date',
    ];

    public function cashJournalDetails()
    {
        return $this->hasMany(CashJournalDetail::class);
    }
}
