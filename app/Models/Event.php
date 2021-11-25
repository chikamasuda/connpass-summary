<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'date',
        'begin_time',
        'end_time',
        'title',
        'group',
        'url',
        'owner',
        'address',
        'accepted',
        'limit'
    ];

    public function alert()
    {
        return $this->hasMany(Alert::class);
    }
}
