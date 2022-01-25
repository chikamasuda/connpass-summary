<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;


class Like extends Model
{
    use HasFactory;

    protected $primaryKey = 'like_id';

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

    /**
     * いいねされてるか判定するメソッド
     *
     * @return boolean
     */
    public function isLikedBy($event_id)
    {
        return (bool)Like::where('ip', request()->ip())->where('event_id', $event_id)->first();
    }
}