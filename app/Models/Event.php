<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Event extends Model
{
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
     * コンパスのイベントURLデータ
     *
     * @return void
     */
    public function popularEventUrlData()
    {
        $month = date('Ym');
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));
        $url_lists = [];
        $url_lists = [
            '1'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1',
            '2'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101',
            '3'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201',
            '4'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301',
            '5'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401',
            '6'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501',
            '7'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601',
            '8'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701',
            '9'  =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801',
            '10' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901',
            '11' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001',
            '12' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101',
            '13' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201',
            '14' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1',
            '15' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101',
            '16' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201',
            '17' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301',
            '18' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401',
            '19' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501',
            '20' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601',
            '21' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701',
            '22' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801',
            '23' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901',
            '24' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001',
            '25' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101',
            '26' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1',
            '27' =>  'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101',
        ];

        return $url_lists;
    }

    /**
     * コンパスのPHPイベントURLデータ
     *
     * @return void
     */
    public function phpEventUrlData()
    {
        $month = date('Ym');
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));
        $url_lists = [];
        $url_lists = [
            '1'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1',
            '2'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101',
            '3'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1',
            '4'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101',
            '5'  => 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&keyword=PHP&start=1',

        ];

        return $url_lists;
    }

    /**
     * ホーム画面の人気イベントランキングのデータ
     *
     * @return void
     */
    public function rankingPopularEventData()
    {
        $lists = $this->where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', 50)
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
    public function rankingPhpEventData()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1)
            ->OrderBy('accepted', 'desc')
            ->limit(5)
            ->get();

        return $lists;
    }
}
