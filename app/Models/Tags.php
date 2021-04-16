<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';

    public function article()
    {
        return $this->belongsToMany(Article::class)->withPivot('articles_id', 'tags_id');
    }
}
