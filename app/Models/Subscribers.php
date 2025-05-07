<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscribers extends Model
{
    use Notifiable;

    protected $fillable = [
        'email',
        'region',
        'city',
        'ip',
        'country',
        'token',
    ];

    protected $table = 'subscribers';
}