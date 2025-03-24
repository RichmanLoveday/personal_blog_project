<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'articles';

    //? Create relationship
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'articles_tags', 'article_id', 'tag_id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}