<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Event extends Model
{
    use HasFactory;

    protected $dates = [
        'date'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'date',
        'begin_time',
        'end_time',
        'title',
        'catch',
        'group',
        'url',
        'owner',
        'address',
        'accepted',
        'limit'
    ];

    /**
     * alertsテーブルとのリレーション
     *
     * @return void
     */
    public function alert()
    {
        return $this->hasOne(Alert::class);
    }

    /**
     * likesテーブルとのリレーション
     *
     * @return void
     */
    public function like()
    {
        return $this->hasMany(Like::class);
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
