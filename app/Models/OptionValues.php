<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValues extends Model
{
    protected $table = 'optionvalues';

    public function options()
    {
        return $this->belongsTo(Options::class, 'option_id', 'id');
    }
}
