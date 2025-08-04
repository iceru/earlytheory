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
        return $this->belongsToMany(Sales::class, 'skus_sales', 'sku_id', 'sales_id')->withPivot('question', 'qty', 'relationship_status');
    }

    public function getMappedRelationshipStatusAttribute(string $status): string
    {
        switch ($status) {
            case 'crush':
                return 'Sekedar Crush';
            case 'pdkt':
                return 'Sedang PDKT';
            case 'pacaran':
                return 'Pacaran';
            case 'menikah':
                return 'Menikah';
            case 'mantan':
                return 'Mantan';
            default:
                return 'Tidak Diketahui';
        }
    }
}
