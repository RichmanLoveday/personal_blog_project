<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'articles_tags', 'tag_id', 'article_id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Boot the model and its event listeners.
     *
     * This method is called to initialize the model and register event listeners
     * for the `created`, `updated`, and `deleted` events. When any of these events
     * occur, the cache for 'active_tags' is cleared to ensure the cache remains
     * consistent with the database.
     */

    protected static function Boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('active_tags');
        });


        static::updated(function () {
            Cache::forget('active_tags');
        });


        static::deleted(function () {
            Cache::forget('active_tags');
        });
    }
}