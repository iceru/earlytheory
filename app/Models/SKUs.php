<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUs extends Model
{
    protected $table = 'skus';

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function skuvalues()
    {
        return $this->hasMany(SKUvalues::class, 'sku_id', 'id');
    }

    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'skus_sales', 'sku_id', 'sales_id')->withPivot('question', 'qty');
    }
}
