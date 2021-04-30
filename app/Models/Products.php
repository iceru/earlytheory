<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'products_sales', 'product_id', 'sales_id')->withPivot('question', 'qty');
    }
}
