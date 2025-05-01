<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertPlacement extends Model
{
    protected $guarded = [];
    protected $table = 'advert_placements';

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'id');
    }

    public function scopeTopOrFooter($query)
    {
        return $query->where('position', 'top_banner')
            ->orWhere('position', 'footer_banner');
    }
}