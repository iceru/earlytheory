<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUvalues extends Model
{
    protected $table = 'skuvalues';
    
    /**
     * Get the skus that owns the SKUvalues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skus(): BelongsTo
    {
        return $this->belongsTo(SKUs::class, 'sku_id', 'id');
    }

    /**
     * Get the options that owns the SKUvalues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function options(): BelongsTo
    {
        return $this->belongsTo(Options::class, 'option_id', 'id');
    }

    /**
     * Get the optionvalues that owns the SKUvalues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function optionvalues(): BelongsTo
    {
        return $this->belongsTo(OptionValues::class, 'value_id', 'id');
    }
}
