<?php

namespace App\Http\Controllers;

use App\Services\ConnPassApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConnpassApiController extends Controller
{
    public $ConnpassApiService;

    public function __construct(ConnpassApiService $ConnpassApiService)
    {
        $this->ConnpassApiService = $ConnpassApiService;
    }

    /**
     * 人気イベントバッチ処理当月
     *
     * @return void
     */
    public function popularEventBatch()
    {
        //URLの末尾でfor文でループしようとすると情報が取得できないため以下のようにURLを列挙（以下同)
        try {
            DB::beginTransaction();
            $month = date('Ym');
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
            $this->ConnpassApiService->apiConnpass($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す(以下同)
            Log::error($e);
        }
    }

    /**
     * 人気イベントバッチ処理翌月
     *
     * @return void
     */
    public function popularEventBatchSecond()
    {
        try {
            DB::beginTransaction();
            $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
            $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
            $this->ConnpassApiService->apiConnpass($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
            $this->ConnpassApiService->apiConnpass($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * PHPイベントの自動更新バッチ
     *
     * @return void
     */
    public function phpEventBatch()
    {
        try {
            DB::beginTransaction();
            $month = date('Ym');
            $next_month = $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
            $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1';
            $this->ConnpassApiService->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101';
            $this->ConnpassApiService->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1';
            $this->ConnpassApiService->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101';
            $this->ConnpassApiService->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&keyword=PHP&start=1';
            $this->ConnpassApiService->apiConnpassPHP($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * アラート処理を走らせるためのバッチ
     *
     * @return void
     */
    public function alertBatch()
    {
        try {
            DB::beginTransaction();
            $month = date('Ym');
            
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=101';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=201';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=301';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=401';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=501';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=601';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=701';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=801';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=901';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1001';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1101';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1201';
            $this->ConnpassApiService->apiAlert($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * アラート処理を走らせるためのバッチ処理２回目
     *
     * @return void
     */
    public function alertSecondBatch()
    {
        try {
            DB::beginTransaction();
            $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
            $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));

            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=101';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=201';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=301';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=401';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=501';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=601';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=701';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=801';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=901';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1001';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&order=2&start=1101';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
            $this->ConnpassApiService->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
            $this->ConnpassApiService->apiAlert($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }
}
