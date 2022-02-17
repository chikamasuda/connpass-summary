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
    public static function updatePopularEventData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.event_url_lists');

        foreach ($url_lists as $url) {
            //ConnpassAPIのデータ取得
            $api_data = self::getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $num = count($api_data['events']);
                for ($i = 0; $i < $num; $i++) {
                    if (isset($api_data['events'][$i]['series']['title'])) {
                        $data[] = [
                            "event_id" => $api_data['events'][$i]['event_id'],
                            "date" => substr($api_data['events'][$i]['started_at'], 0, 10),
                            "begin_time" => substr($api_data['events'][$i]['started_at'], 11, 5),
                            "end_time" => substr($api_data['events'][$i]['ended_at'], 11, 5),
                            "title" => $api_data['events'][$i]['title'],
                            "catch" => $api_data['events'][$i]['catch'],
                            "url" => $api_data['events'][$i]['event_url'],
                            "group" => $api_data['events'][$i]['series']['title'],
                            "owner" => $api_data['events'][$i]['owner_display_name'],
                            "address" => $api_data['events'][$i]['address'],
                            "accepted" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting'],
                            "limit" => $api_data['events'][$i]['limit'],
                            "catch" => $api_data['events'][$i]['catch'],
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
    public static function updatePhpEventData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.php_url_lists');

        foreach ($url_lists as $url) {
            //ConnpassAPIのデータ取得
            $api_data = self::getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $num = count($api_data['events']);
                for ($i = 0; $i < $num; $i++) {
                    if (isset($api_data['events'][$i]['series']['title'])) {
                        $data[] = [
                            "event_id" => $api_data['events'][$i]['event_id'],
                            "date" => substr($api_data['events'][$i]['started_at'], 0, 10),
                            "begin_time" => substr($api_data['events'][$i]['started_at'], 11, 5),
                            "end_time" => substr($api_data['events'][$i]['ended_at'], 11, 5),
                            "title" => $api_data['events'][$i]['title'],
                            "catch" => $api_data['events'][$i]['catch'],
                            "url" => $api_data['events'][$i]['event_url'],
                            "group" => $api_data['events'][$i]['series']['title'],
                            "owner" => $api_data['events'][$i]['owner_display_name'],
                            "address" => $api_data['events'][$i]['address'],
                            "accepted" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting'],
                            "limit" => $api_data['events'][$i]['limit'],
                            "catch" => $api_data['events'][$i]['catch'],
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
    public static function updateAlertData()
    {
        //コンパスのURLのリスト
        $url_lists = config('url.event_url_lists');

        foreach ($url_lists as $url) {
           //ConnpassAPIのデータ取得
           $api_data = self::getConnpassApiData($url);

            //イベント情報を配列に入れて保存
            DB::beginTransaction();
            try {
                $alerts = Alert::all();
                $events = Event::all();
                $num = count($api_data['events']);
                //イベント情報を配列に入れて保存
                for ($i = 0; $i < $num; $i++) {
                    $event = $events->where('event_id', $api_data['events'][$i]['event_id'])->first();
                    if (isset($event->id)) {
                        $alert = $alerts->where('event_id', $event->id)->first();
                    }

                    if (isset($alert->number) && isset($event->id)) {
                        $data[] = [
                            "event_id" => $event->id,
                            "number" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting'],
                            "diff" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting'] - $alert->number,
                        ];
                    }

                    if (empty($alert->number) && isset($event->id)) {
                        $data[] = [
                            "event_id" => $event->id,
                            "number" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting'],
                            "diff" => $api_data['events'][$i]['accepted'] + $api_data['events'][$i]['waiting']
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
    private static function getConnpassApiData($url)
    {
         try {
            $client = new Client();
            $response = $client->request("GET", $url);
            $json = $response->getBody();
            $api_data = json_decode($json, true);
            return $api_data;
        } catch (BadResponseException $e) {
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
            return false;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
