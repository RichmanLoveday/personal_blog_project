<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleTag extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'articles_tags';

    public function posts(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}