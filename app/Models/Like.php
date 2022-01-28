<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Illuminate\Support\Carbon;

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

    /**
     * お気に入りイベント一覧のデータ
     *
     * @return void
     */
    public function LikeEventListData()
    {
        $lists = $this->join('events', 'likes.event_id', '=', 'events.id')
            ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
            ->where('ip', request()->ip());
            
        return $lists->paginate(20);
    }

    /**
     * お気に入り登録処理
     *
     * @param Request $request
     * @param object $event
     * @return void
     */
    public function insertLikeData($request, $event)
    {
        return $this->create([
            'event_id'    => $event->id,
            'ip'          => $request->ip(),
        ]);
    }

    /**
     * お気に入り登録削除
     *
     * @param Request $request
     * @param object $event
     * @return void
     */
    public function deleteLike($request, $event)
    {
        $like = $this->where('event_id', $event->id)->where('ip', $request->ip())->first();
        $like->delete();
    }
}