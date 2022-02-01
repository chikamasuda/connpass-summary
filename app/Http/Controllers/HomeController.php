<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Alert;

class HomeController extends Controller
{
    /**
     * ホーム画面のイベント一覧
     *
     * @return void
     */
    public function index()
    {
        //人気イベントランキングの表示
        $popular_events = Event::getRankingPopularEventData();

        //PHPイベントランキングの表示
        $php_events = Event::getRankingPhpEventData();

        //人気急上昇イベントのリスト
        $alerts = Alert::getAlertListData();

        return view('home', compact('alerts', 'popular_events', 'php_events'));
    }
}
