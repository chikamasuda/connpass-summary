<?php

namespace App\Http\Controllers;

use App\Services\ConnpassApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;

class ConnpassApiController extends Controller
{
    private $connpass_api_service, $event;

    public function __construct(ConnpassApiService $connpass_api_service, Event $event)
    {
        $this->connpass_api_service = $connpass_api_service;
        $this->event = $event;
    }

    /**
     * 人気イベントバッチ処理
     *
     * @return void
     */
    public function popularEventBatch()
    {
        $url_lists = $this->event->popularEventUrlData();

        foreach($url_lists as $url) {
            $this->connpass_api_service->getPopularEventData($url);
        }
    }

    /**
     * PHPイベントバッチ処理
     *
     * @return void
     */
    public function phpEventBatch()
    {
        $url_lists = $this->event->phpEventUrlData();

        foreach($url_lists as $url) {
            $this->connpass_api_service->getPhpEventData($url);
        }
    }

    /**
     * アラート処理を走らせるためのバッチ
     *
     * @return void
     */
    public function alertBatch()
    {
        $url_lists = $this->event->popularEventUrlData();

        foreach($url_lists as $url) {
            $this->connpass_api_service->getAlertData($url);
        }
    }
}
