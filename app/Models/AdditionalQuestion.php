<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['sales_id'];

   
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'sales_no');
    }
}
