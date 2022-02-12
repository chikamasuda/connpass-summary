<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Event extends Model
{
    //人気イベントの基準人数
    const POPULAR_ACCEPTED_MIN_COUNT = 50;

    use HasFactory;

    public $timestamps = false;

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
     * ホーム画面の人気イベントランキングのデータ
     *
     * @return void
     */
    public static function getRankingPopularEventData()
    {
        $lists = self::where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', self::POPULAR_ACCEPTED_MIN_COUNT)
            ->OrderBy('accepted', 'desc')
            ->limit(5)
            ->get();

        return $lists;
    }

    /**
     * ホーム画面のPHPイベントランキングのデータ
     *
     * @return void
     */
    public static function getRankingPhpEventData()
    {
        $lists = self::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1)
            ->OrderBy('accepted', 'desc')
            ->limit(5)
            ->get();

        return $lists;
    }
    
    /**
     * PHPイベントの内容一覧リストのデータ
     *
     * @return void
     */
    public static function getPhpEventList()
    {
        $lists = self::where('date', '>=', date('Y-m-d'))
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->orderBy('begin_time', 'asc')
            ->paginate(20);

        return $lists;
    }

    /**
     * 人気イベントの内容一覧リストのデータ
     *
     * @return void
     */
    public static function getPopularEventList()
    {
        $lists = self::where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', self::POPULAR_ACCEPTED_MIN_COUNT)
            ->OrderBy('accepted', 'desc')
            ->paginate(20);

        return $lists;
    }
}