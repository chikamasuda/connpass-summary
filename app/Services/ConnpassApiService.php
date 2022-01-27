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
     * connpassAPIの情報取得・保存
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

            for ($i = 0; $i < $num; $i++) {
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

            Event::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す(以下同)
            Log::error($e);
        }
    }

    /**
     * connpassAPIの検索結果PHPの情報取得・保存
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

            for ($i = 0; $i < $num; $i++) {
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
            
            Event::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す(以下同)
            Log::error($e);
        }
    }

     /**
     * connpassAPIのアラート表示のための情報取得・保存
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
            $alerts = Alert::where('diff', '>=', 20)
            ->OrderBy('diff', 'desc')
            ->whereHas('event', function ($query) {
                $query->where('date', '>=',  Carbon::today()->format('Y-m-d'))
                    ->where('date', '<=', date('Y-m-d', strtotime('last day of next month')));
            })
            ->get();

            for ($i = 0; $i < $num; $i++) {
                $data[] = [
                    "event_id" => $arrays['events'][$i]['event_id'],
                    "number" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                ];
            }

            Alert::upsert($data, ['event_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す(以下同)
            Log::error($e);
        }
    }
}
