<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'birthdate'
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'products_sales', 'sales_id', 'product_id')->withPivot('question', 'qty');
    }

    public function paymentMethods()
    {
        return $this->belongsTo(PaymentMethods::class, 'paymethod_id', 'id');
    }
}
