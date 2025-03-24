<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advert extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'adverts';


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
