<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function popularEvent()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(50);

        return view('home', compact('lists'));
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function phpEvent()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->paginate(50);

        return view('php_event', compact('lists'));
    }
}
