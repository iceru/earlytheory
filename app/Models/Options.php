<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'options';

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function optionvalues()
    {
        return $this->hasMany(OptionValues::class, 'option_id', 'id');
    }
}
