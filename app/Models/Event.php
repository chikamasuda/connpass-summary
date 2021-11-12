<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'begin_time',
        'end_time',
        'title',
        'url',
        'owner',
        'address',
        'accepted',
        'limit'
    ];
}
