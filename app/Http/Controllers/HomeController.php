<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;
use App\Models\Alert;

class HomeController extends Controller
{
    public function index()
    {
        //人気イベントランキングの表示
        $popular_events = Event::where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->limit(5)
            ->get();

        //PHPイベントランキングの表示
        $php_events = Event::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1)
            ->OrderBy('accepted', 'desc')
            ->limit(5)
            ->get();

        //人気急上昇イベントのリスト
        $alerts = Alert::where('diff', '>=', 20)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'))
                    ->where('date', '<=', date('Y-m-d', strtotime('last day of next month')));
            })
            ->paginate(5);

        return view('home', compact('alerts', 'popular_events', 'php_events'));
    }
}
