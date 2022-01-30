<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Alert;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class ConnpassAPIService
{
    /**
     * イベント情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getPopularEventData($url)
    {
        DB::beginTransaction();
        try {
            $method = "GET";
            $client = new Client();
            $response = $client->request($method, $url);
            $arrays = $response->getBody();
            $arrays = json_decode($arrays, true);
            $num = count($arrays['events']);
            $data = [];
            //イベント情報を配列に入れて保存
            for ($i = 0; $i < $num; $i++) {
                if (isset($arrays['events'][$i]['series']['title'])) {
                    $data[] = [
                        "event_id" => $arrays['events'][$i]['event_id'],
                        "date" => substr($arrays['events'][$i]['started_at'], 0, 10),
                        "begin_time" => substr($arrays['events'][$i]['started_at'], 11, 5),
                        "end_time" => substr($arrays['events'][$i]['ended_at'], 11, 5),
                        "title" => $arrays['events'][$i]['title'],
                        "catch" => $arrays['events'][$i]['catch'],
                        "url" => $arrays['events'][$i]['event_url'],
                        "group" => $arrays['events'][$i]['series']['title'],
                        "owner" => $arrays['events'][$i]['owner_display_name'],
                        "address" => $arrays['events'][$i]['address'],
                        "accepted" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                        "limit" => $arrays['events'][$i]['limit'],
                        "catch" => $arrays['events'][$i]['catch'],
                        "site_id" => 1,
                    ];
                }
            }
            Event::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す（以下同）
            Log::error($e);
        }
    }

    /**
     * PHPイベントの情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getPhpEventData($url)
    {
        DB::beginTransaction();
        try {
            $method = "GET";
            $client = new Client();
            $response = $client->request($method, $url);
            $arrays = $response->getBody();
            $arrays = json_decode($arrays, true);
            $num = count($arrays['events']);
            $data = [];
            //イベント情報を配列に入れて保存
            for ($i = 0; $i < $num; $i++) {
                if (isset($arrays['events'][$i]['series']['title'])) {
                    $data[] = [
                        "event_id" => $arrays['events'][$i]['event_id'],
                        "date" => substr($arrays['events'][$i]['started_at'], 0, 10),
                        "begin_time" => substr($arrays['events'][$i]['started_at'], 11, 5),
                        "end_time" => substr($arrays['events'][$i]['ended_at'], 11, 5),
                        "title" => $arrays['events'][$i]['title'],
                        "catch" => $arrays['events'][$i]['catch'],
                        "url" => $arrays['events'][$i]['event_url'],
                        "group" => $arrays['events'][$i]['series']['title'],
                        "owner" => $arrays['events'][$i]['owner_display_name'],
                        "address" => $arrays['events'][$i]['address'],
                        "accepted" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                        "limit" => $arrays['events'][$i]['limit'],
                        "catch" => $arrays['events'][$i]['catch'],
                        "site_id" => 1,
                        "php_flag" => 1,
                    ];
                }
            }
            Event::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * 人気急上昇イベント表示のための情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getAlertData($url)
    {
        DB::beginTransaction();
        try {
            $method = "GET";
            $client = new Client();
            $response = $client->request($method, $url);
            $arrays = $response->getBody();
            $arrays = json_decode($arrays, true);
            $num = count($arrays['events']);
            $data = [];
            $alerts = Alert::all();
            $events = Event::all();
            //イベント情報を配列に入れて保存
            for ($i = 0; $i < $num; $i++) {
                $event = $events->where('event_id', $arrays['events'][$i]['event_id'])->first();
                if(isset($event->id)) {
                    $alert = $alerts->where('event_id', $event->id)->first();
                }
                
                if(isset($alert->number) && isset($event->id)) {
                    $data[] = [
                        "event_id" => $event->id,
                        "number" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                        "diff" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'] - $alert->number,
                    ];  
                } 

                if(empty($alert->number) && isset($event->id)) {
                    $data[] = [
                        "event_id" => $event->id,
                        "number" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                        "diff" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting']
                    ];
                }
            }
            Alert::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }
}
