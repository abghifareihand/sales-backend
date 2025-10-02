<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address'
    ];

        // User yang berada di cabang ini
    public function users() {
        return $this->hasMany(User::class);
    }

    // Stok cabang
    public function stocks() {
        return $this->hasMany(Stock::class);
    }

    // Transaksi yang terjadi di cabang
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    // Distribusi dari cabang
    public function distributionsFrom() {
        return $this->hasMany(Distribution::class, 'from_branch_id');
    }

    // Distribusi ke cabang
    public function distributionsTo() {
        return $this->hasMany(Distribution::class, 'to_branch_id');
    }


}
