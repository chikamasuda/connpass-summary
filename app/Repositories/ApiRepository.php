<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Alert;
use Carbon\Carbon;

class ApiRepository
{
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
            $events->timestamps = false;
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
    public function apiConnpassPHP($url)
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
            $event_data['accepted'] = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];;
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

    /**
     * connpassAPIのアラート表示のための情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function apiAlert($url)
    {
        $options = [
            'http' => [
                'method' => 'GET',  
                'header' => 'User-Agent: iOS'
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, true, $context);
        $arrays = json_decode($response, true);
        //dd($arrays);
        $num = count($arrays['events']);

        for ($i = 0; $i < $num; $i++) {
            $event_id = $arrays['events'][$i]['event_id'];
            $id = Event::where('event_id', $event_id)->value('id');
            if(!empty($id)) {
            //Alertsテーブルにデータ保存
            $alerts = new Alert();
            $alerts->date = date('Y-m-d');
            $alerts->event_id = $id;
            $alerts->number = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];
            $event_accepted = Alert::where('date', Carbon::yesterday()->format('Y-m-d'))
                ->where('event_id', $id)
                ->value('number');
            if (empty($event_accepted))  $alerts->diff = $alerts->number;
            $alerts->diff = $alerts->number - $event_accepted;
            $alerts->timestamps = false;
            $alerts->save();
            } 
        }
    }
}