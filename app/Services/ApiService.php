<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use App\Repositories\ApiRepository;
use Illuminate\Support\Facades\App;

class ApiService
{
    public $apiRepository;

    public function __construct(ApiRepository $apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    /**
     * 人気イベントバッチ処理当月
     *
     * @return void
     */
    public function popularEventBatch()
    {
        $month = date('Ym');

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=11';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1301';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1401';
        $this->apiRepository->apiConnpass($url);
    }

    /**
     * 人気イベントバッチ処理翌月
     *
     * @return void
     */
    public function popularEventBatchSecond()
    {
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1201';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1301';
        $this->apiRepository->apiConnpass($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1401';
        $this->apiRepository->apiConnpass($url);
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

        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1';
        $this->apiRepository->apiConnpassPHP($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101';
        $this->apiRepository->apiConnpassPHP($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1';
        $this->apiRepository->apiConnpassPHP($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101';
        $this->apiRepository->apiConnpassPHP($url);
    }

    /**
     * アラート処理を走らせるためのバッチ
     *
     * @return void
     */
    public function AlertBatch()
    {
        $month = date('Ym');
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=11';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1301';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1401';
        $this->apiRepository->apiAlert($url);
    }

    /**
     * アラート処理を走らせるためのバッチ処理２回目
     *
     * @return void
     */
    public function alertSecondBatch()
    {
        $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1201';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1301';
        $this->apiRepository->apiAlert($url);
        $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1401';
        $this->apiRepository->apiAlert($url);
    }
}
