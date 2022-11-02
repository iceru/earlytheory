<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'birthdate',
        'user_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'products_sales', 'sales_id', 'product_id')->withPivot('question', 'qty');
    }

    public function skus()
    {
        return $this->belongsToMany(SKUs::class, 'skus_sales', 'sales_id', 'sku_id')->withPivot('question', 'qty');
    }

    public function paymentMethods()
    {
        return $this->belongsTo(PaymentMethods::class, 'paymethod_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'address_id', 'id');
    }

    public function additional()
    {
        return $this->hasMany(AdditionalQuestion::class, 'sales_id', 'id');
    }
}
