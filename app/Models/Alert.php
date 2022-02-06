<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Alert extends Model
{
    //人気急上昇イベントの基準人数
    const ALERT_EVENT_NUMBER = 20;

    use HasFactory;

    protected $primaryKey = 'alert_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'date',
        'number',
        'diff'
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
     * 人気急上昇イベントのデータ
     *
     * @return void
     */
    public static function getAlertListData()
    {
        $alerts = self::where('diff', '>=', self::ALERT_EVENT_NUMBER)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'));
            });

        return $alerts->paginate(5);
    }
}
