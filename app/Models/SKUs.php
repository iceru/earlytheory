<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUs extends Model
{
    protected $table = 'skus';

    /**
     * Get the products that owns the SKUs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
