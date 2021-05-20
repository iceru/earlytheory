<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'articles';

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'articles_tags', 'article_id', 'tag_id');
    }
}
