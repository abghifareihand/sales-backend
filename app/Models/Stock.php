<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'branch_id',
        'quantity',
        'sales_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function sales(){
        return $this->belongsTo(User::class, 'sales_id');
    }
}
