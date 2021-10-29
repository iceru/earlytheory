<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUvalues extends Model
{
    protected $table = 'skuvalues';

    public function skus()
    {
        return $this->belongsTo(SKUs::class, 'sku_id', 'id');
    }

    public function options()
    {
        return $this->belongsTo(Options::class, 'option_id', 'id');
    }
    
    public function optionvalues()
    {
        return $this->belongsTo(OptionValues::class, 'value_id', 'id');
    }
}
