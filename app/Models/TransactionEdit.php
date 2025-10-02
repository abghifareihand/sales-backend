<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionEdit extends Model
{
    protected $fillable = [
        'transaction_id',
        'old_total',
        'old_profit',
        'edit_total',
        'edit_profit',
        'edit_reason',
        'status',
        'submitted_by',
        'approved_by'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
