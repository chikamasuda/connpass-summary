<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: iOS',
            ],
        ];
        $context = stream_context_create($options);
                $url = 'https://connpass.com/api/v1/event/?count=100&ym=202111&order=2&start=1101';
                $response = file_get_contents($url, true, $context);
                $arrays = json_decode($response, true);
                //dd($arrays);
                for($i= 0; $i < 100; $i++) {
                    $event_data['date'] = substr($arrays['events'][$i]['started_at'], 0, 10);
                    $event_data['begin_time'] = $arrays['events'][$i]['started_at'];
                    $event_data['end_time'] = $arrays['events'][$i]['ended_at'];
                    $event_data['title'] = $arrays['events'][$i]['title'];
                    $event_data['url'] = $arrays['events'][$i]['event_url'];
                    $event_data['owner'] = $arrays['events'][$i]['owner_display_name'];
                    $event_data['address'] = $arrays['events'][$i]['address'];
                    $event_data['accepted'] = $arrays['events'][$i]['accepted'];
                    $event_data['limit'] = $arrays['events'][$i]['limit'];
                    $events = Event::firstOrNew($event_data);
                    $events->save($event_data);
                }
       
            

        $lists = Event::where('date','>=', Carbon::today())->where('accepted','>=', 50)->OrderBy('accepted', 'desc')->paginate(50);
        
        return view('home', compact('lists'));
    }
}
