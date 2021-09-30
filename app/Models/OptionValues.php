<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValues extends Model
{
    protected $table = 'optionvalues';

    /**
     * Get the options that owns the OptionValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function options(): BelongsTo
    {
        return $this->belongsTo(Options::class, 'option_id', 'id');
    }
}
