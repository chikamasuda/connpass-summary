<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Alert;

class HomeController extends Controller
{
    private $event, $alert;

    public function __construct(Event $event, Alert $alert)
    {
        $this->event = $event;
        $this->alert = $alert;
    }

    /**
     * ホーム画面のイベント一覧
     *
     * @return void
     */
    public function index()
    {
        //人気イベントランキングの表示
        $popular_events = $this->event->getRankingPopularEventData();

        //PHPイベントランキングの表示
        $php_events = $this->event->getRankingPhpEventData();

        //人気急上昇イベントのリスト
        $alerts = $this->alert->getAlertListData();

        return view('home', compact('alerts', 'popular_events', 'php_events'));
    }
}
