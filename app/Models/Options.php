<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'options';

    /**
     * Get the products that owns the Options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    /**
     * Get all of the optionvalues for the Options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionvalues(): HasMany
    {
        return $this->hasMany(OptionValues::class, 'option_id', 'id');
    }
}
