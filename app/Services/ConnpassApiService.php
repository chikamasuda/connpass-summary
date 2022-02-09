<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Alert;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\BadResponseException;

class ConnpassAPIService
{
    /**
     * イベント情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getPopularEventData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.event_url_lists');

        foreach ($url_lists as $url) {
            //ConnpassAPIのデータ取得
            $arrays = $this->getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $num = count($arrays['events']);
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
    }

    /**
     * PHPイベントの情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getPhpEventData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.php_url_lists');

        foreach ($url_lists as $url) {
            //ConnpassAPIのデータ取得
            $arrays = $this->getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $num = count($arrays['events']);
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
    }

    /**
     * 人気急上昇イベント表示のための情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    public function getAlertData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.event_url_lists');

        foreach ($url_lists as $url) {
           //ConnpassAPIのデータ取得
           $arrays = $this->getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $alerts = Alert::all();
                $events = Event::all();
                $num = count($arrays['events']);
                //イベント情報を配列に入れて保存
                for ($i = 0; $i < $num; $i++) {
                    $event = $events->where('event_id', $arrays['events'][$i]['event_id'])->first();
                    if (isset($event->id)) {
                        $alert = $alerts->where('event_id', $event->id)->first();
                    }

                    if (isset($alert->number) && isset($event->id)) {
                        $data[] = [
                            "event_id" => $event->id,
                            "number" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'],
                            "diff" => $arrays['events'][$i]['accepted'] + $arrays['events'][$i]['waiting'] - $alert->number,
                        ];
                    }

                    if (empty($alert->number) && isset($event->id)) {
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

    /**
     * ConnpassAPIのデータ取得
     *
     * @param string $url
     * @return void
     */
    private function getConnpassApiData($url)
    {
         try {
            $method = "GET";
            $client = new Client();
            $response = $client->request($method, $url);
            $arrays = $response->getBody();
            $arrays = json_decode($arrays, true);
        } catch (BadResponseException $e) {
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
        }

        return $arrays;
    }
}
