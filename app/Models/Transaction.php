<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'sales_id',
        'branch_id',
        'outlet_id',
        'total',
        'profit',
        'latitude',
        'longitude'
    ];

    public function sales() {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function items() {
        return $this->hasMany(TransactionItem::class);
    }

    // Hitung total profit otomatis
    public function getProfitAttribute($value){
        if($value) return $value;
        return $this->items->sum(function($item){
            return ($item->price - $item->cost_price) * $item->quantity;
        });
    }

    public function edits()
    {
        return $this->hasMany(TransactionEdit::class);
    }
}
