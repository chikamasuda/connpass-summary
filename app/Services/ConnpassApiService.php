<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Alert;
use GuzzleHttp\Client;

class ConnpassAPIService
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

        for ($i = 0; $i < $num; $i++) {
            $events = Event::firstOrNew([
                'event_id' => $arrays['events'][$i]['event_id'],
            ]);
            $events->date = substr($arrays['events'][$i]['started_at'], 0, 10);
            $events->begin_time = substr($arrays['events'][$i]['started_at'], 11, 5);
            $events->end_time = substr($arrays['events'][$i]['ended_at'], 11, 5);
            $events->title = $arrays['events'][$i]['title'];
            $events->catch = $arrays['events'][$i]['catch'];
            $events->url = $arrays['events'][$i]['event_url'];
            if (isset($arrays['events'][$i]['series']['title'])) {
                $events->group = $arrays['events'][$i]['series']['title'];
            }
            $events->owner = $arrays['events'][$i]['owner_display_name'];
            $events->address = $arrays['events'][$i]['address'];
            $events->accepted = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];;
            $events->limit = $arrays['events'][$i]['limit'];
            $events->catch = $arrays['events'][$i]['catch'];
            $events->site_id = 1;
            $events->timestamps = false;
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
        //dd($arrays);
        $num = count($arrays['events']);

        for ($i = 0; $i < $num; $i++) {
            $events = Event::firstOrNew([
                'event_id' => $arrays['events'][$i]['event_id'],
            ]);
            $events->date = substr($arrays['events'][$i]['started_at'], 0, 10);
            $events->begin_time = substr($arrays['events'][$i]['started_at'], 11, 5);
            $events->end_time = substr($arrays['events'][$i]['ended_at'], 11, 5);
            $events->title = $arrays['events'][$i]['title'];
            $events->catch = $arrays['events'][$i]['catch'];
            $events->url = $arrays['events'][$i]['event_url'];
            if (isset($arrays['events'][$i]['series']['title'])) {
                $events->group = $arrays['events'][$i]['series']['title'];
            }
            $events->owner = $arrays['events'][$i]['owner_display_name'];
            $events->address = $arrays['events'][$i]['address'];
            $events->accepted = $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'];;
            $events->limit = $arrays['events'][$i]['limit'];
            $events->php_flag = 1;
            $events->site_id = 1;
            $events->timestamps = false;
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
        //dd($arrays);
        for ($i = 0; $i < $num; $i++) {
            if (isset($arrays['events'][$i]['event_id'])) {
                $event_id = $arrays['events'][$i]['event_id'];
            }
            $id = Event::where('event_id', $event_id)->value('id');
            //dd($id);
            //Alertsテーブルにデータ保存
            if (isset($id)) {
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
}