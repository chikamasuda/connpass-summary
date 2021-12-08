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
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(10);

        $events = Alert::where('diff', '>=', 20)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'));
            })
            ->get();

        return view('home', compact('lists', 'events'));
    }
}
