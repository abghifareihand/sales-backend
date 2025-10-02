<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
        protected $fillable = [
        'created_by',
        'id_outlet',
        'name_outlet',
        'address_outlet',
        'name',
        'phone',
        'latitude',
        'longitude'
    ];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
