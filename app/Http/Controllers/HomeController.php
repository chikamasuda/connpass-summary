<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;
use App\Models\Alert;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        //人気イベントランキングの表示
        $events = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(5);
        
        $php_events = Event::where('date', '>', Carbon::yesterday())
        ->where('date', '<', date('Ymd', strtotime('first day of next month')))
        ->where('php_flag', 1)
        ->OrderBy('accepted', 'desc')
        ->paginate(5);

        //人気急上昇イベントのリスト
        $lists = Alert::where('diff', '>=', 20)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'));
            })
            ->get();

        return view('home', compact('lists', 'events', 'php_events'));
    }
}
