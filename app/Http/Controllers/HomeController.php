<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(10);

        $events = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(5);

        return view('home', compact('lists', 'events'));
    }
}
