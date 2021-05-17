<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
