<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    public function tags()
    {
        return $this->belongsToMany(Tags::class)->withPivot('articles_id', 'tags_id');
    }
}
