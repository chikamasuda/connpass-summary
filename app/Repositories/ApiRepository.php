<?php
namespace App\Repositories;

use App\Models\Event;

class ApiRepository 
{
   /**
    * 人気イベントバッチ処理
    *
    * @return void
    */
    public function popularEventBatch()
    {
       $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: iOS',
            ],
        ];
        $context = stream_context_create($options);
        $month = date('Ym');
        $next_month = $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=1&start=1';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=1&start=101';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=1&start=201';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . 'order=3&start=1';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=3&start=101';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=3&start=201';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=1&start=1';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=1&start=101';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=1&start=201';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . 'order=3&start=1';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=3&start=101';
        $this->apiConnpass($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=1&start=201';
        $this->apiConnpass($url, $context);
    }

    /**
     * PHPイベントの自動更新バッチ
     *
     * @return void
     */
    public function phpEventBatch()
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: iOS',
            ],
        ];
        $context = stream_context_create($options);
        $month = date('Ym');
        $next_month = $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1';
        $this->apiConnpassPHP($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101';
        $this->apiConnpassPHP($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1';
        $this->apiConnpassPHP($url, $context);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101';
        $this->apiConnpassPHP($url, $context);
    }

    /**
     * connpassAPIの情報取得・保存
     *
     * @param string $url
     * @param string $context
     * @return void
     */
    private function apiConnpass($url, $context)
    {
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
    private function apiConnpassPHP($url, $context)
    {
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