<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Alert;
use Carbon\Carbon;
use GuzzleHttp\Client;

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
        $method = "GET";
        $client = new Client();
        $response = $client->request($method, $url);
        $arrays = $response->getBody();
        $arrays = json_decode($arrays, true);
        $num = count($arrays['events']);
        //dd($arrays);
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
        $method = "GET";
        $client = new Client();
        $response = $client->request($method, $url);
        $arrays = $response->getBody();
        $arrays = json_decode($arrays, true);
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
        $method = "GET";
        $client = new Client();
        $response = $client->request($method, $url);
        $arrays = $response->getBody();
        $arrays = json_decode($arrays, true);
        $num = count($arrays['events']);

        for ($i = 0; $i < $num; $i++) {
            $event_id = $arrays['events'][$i]['event_id'];
            $id = Event::where('event_id', $event_id)->value('id');
            //Alertsテーブルにデータ保存
            $alerts = Alert::firstOrNew([
                'event_id' =>  $id,
            ]);
            $alert_data['number'] = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];
            $event_accepted = Alert::where('event_id', $id)->value('number');
            if (empty($event_accepted))  $alert_data['diff'] = $alerts->number;
            $alert_data['diff'] = $alert_data['number'] - $event_accepted;
            $alerts->fill($alert_data);
            //dd($alerts);
            $alerts->save();
        }
    }
}
