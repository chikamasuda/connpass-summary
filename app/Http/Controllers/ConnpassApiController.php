<?php

namespace App\Http\Controllers;

use App\Services\ConnpassApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;

class ConnpassApiController extends Controller
{
    private $connpass_api_service;

    public function __construct(ConnpassApiService $connpass_api_service)
    {
        $this->connpass_api_service = $connpass_api_service;
    }

    /**
     * 人気イベントバッチ処理
     *
     * @return void
     */
    public function popularEventBatch()
    {
        $url_lists = config('url.event_url_lists');

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
        $url_lists = config('url.php_url_lists');

        foreach($url_lists as $url) {
            $this->connpass_api_service->getPhpEventData($url);
        }
    }

    /**
     * 人気急上昇イベントバッチ処理
     *
     * @return void
     */
    public function alertBatch()
    {
        $url_lists = config('url.event_url_lists');

        foreach($url_lists as $url) {
            $this->connpass_api_service->getAlertData($url);
        }
    }
}
