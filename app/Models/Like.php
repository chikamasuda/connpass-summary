<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;


class Like extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'ip',
    ];

    /**
     * eventsテーブルとのリレーション
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}