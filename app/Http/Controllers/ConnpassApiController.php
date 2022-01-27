<?php

namespace App\Http\Controllers;

use App\Services\ConnpassApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConnpassApiController extends Controller
{
    public $connpass_api_service;

    public function __construct(ConnpassApiService $connpass_api_service)
    {
        $this->connpass_api_service = $connpass_api_service;
    }

    /**
     * 人気イベントバッチ処理当月
     *
     * @return void
     */
    public function popularEventBatch()
    {
        $month = date('Ym');
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
        $this->connpass_api_service->getPopularEventData($url);
    }

    /**
     * 人気イベントバッチ処理翌月
     *
     * @return void
     */
    public function popularEventBatchSecond()
    {
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
        $this->connpass_api_service->getPopularEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
        $this->connpass_api_service->getPopularEventData($url);
    }

    /**
     * PHPイベントの自動更新バッチ
     *
     * @return void
     */
    public function phpEventBatch()
    {
        $month = date('Ym');
        $next_month = $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1';
        $this->connpass_api_service->getPhpEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101';
        $this->connpass_api_service->getPhpEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1';
        $this->connpass_api_service->getPhpEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101';
        $this->connpass_api_service->getPhpEventData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&keyword=PHP&start=1';
        $this->connpass_api_service->getPhpEventData($url);
    }

    /**
     * アラート処理を走らせるためのバッチ
     *
     * @return void
     */
    public function alertBatch()
    {
        $month = date('Ym');

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
        $this->connpass_api_service->getAlertData($url);
    }

    /**
     * アラート処理を走らせるためのバッチ処理２回目
     *
     * @return void
     */
    public function alertSecondBatch()
    {
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
        $this->connpass_api_service->getAlertData($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
        $this->connpass_api_service->getAlertData($url);
    }
}
