<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'from_branch_id',
        'to_branch_id',
        'to_sales_id',
        'product_id',
        'quantity',
        'type',
        'notes'
    ];

    public function fromBranch() {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch() {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function toSales() {
        return $this->belongsTo(User::class, 'to_sales_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
