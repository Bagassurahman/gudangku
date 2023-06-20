<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashJournalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_journal_id', // Add cash_journal_id to the fillable array
        'cost_id',
        'notes',
        'debit',
    ];

    public function cost()
    {
        return $this->belongsTo(Cost::class, 'cost_id', 'id');
    }
}
