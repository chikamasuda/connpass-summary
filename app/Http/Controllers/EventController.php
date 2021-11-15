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

    /**
     * connpassAPIの情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function apiConnpass($url)
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: iOS',
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, true, $context);
        $arrays = json_decode($response, true);
        dd($arrays);
        $num = count($arrays['events']);

        for ($i = 0; $i < $num; $i++) {
            $event_data['event_id'] = $arrays['events'][$i]['event_id'];
            $event_data['date'] = substr($arrays['events'][$i]['started_at'], 0, 10);
            $event_data['begin_time'] = substr($arrays['events'][$i]['started_at'], 11, 5);
            $event_data['end_time'] = substr($arrays['events'][$i]['ended_at'], 11, 5);
            $event_data['title'] = $arrays['events'][$i]['title'];
            $event_data['url'] = $arrays['events'][$i]['event_url'];
            if (isset($arrays['events'][$i]['series']['title'])) {
                $event_data['group'] = $arrays['events'][$i]['series']['title'];
            }
            $event_data['owner'] = $arrays['events'][$i]['owner_display_name'];
            $event_data['address'] = $arrays['events'][$i]['address'];
            $event_data['accepted'] = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];
            $event_data['limit'] = $arrays['events'][$i]['limit'];
            $events = Event::firstOrNew([
                'event_id' => $arrays['events'][$i]['event_id'],
            ]);
            $events->site_id = 1;
            $events->updated_at = $arrays['events'][$i]['updated_at'];
            $events->created_at = $arrays['events'][$i]['started_at'];
            $events->fill($event_data);
            $events->save();
        }
    }

     /**
     * connpassAPIの検索結果PHPの情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    private function apiConnpassPHP($url)
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: iOS',
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, true, $context);
        $arrays = json_decode($response, true);
        $num = count($arrays['events']);

        for ($i = 0; $i < $num; $i++) {
            $event_data['event_id'] = $arrays['events'][$i]['event_id'];
            $event_data['date'] = substr($arrays['events'][$i]['started_at'], 0, 10);
            $event_data['begin_time'] = substr($arrays['events'][$i]['started_at'], 11, 5);
            $event_data['end_time'] = substr($arrays['events'][$i]['ended_at'], 11, 5);
            $event_data['title'] = $arrays['events'][$i]['title'];
            $event_data['url'] = $arrays['events'][$i]['event_url'];
            if (isset($arrays['events'][$i]['series']['title'])) {
                $event_data['group'] = $arrays['events'][$i]['series']['title'];
            }
            $event_data['owner'] = $arrays['events'][$i]['owner_display_name'];
            $event_data['address'] = $arrays['events'][$i]['address'];
            $event_data['accepted'] = $arrays['events'][$i]['accepted'];
            $events = Event::firstOrNew([
                'event_id' => $arrays['events'][$i]['event_id'],
            ]);
            $events->php_flag = 1;
            $events->site_id = 1;
            $events->timestamps = false;
            $events->fill($event_data);
            $events->save();
        }
    }
}
