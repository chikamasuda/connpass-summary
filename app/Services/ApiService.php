<?php

namespace App\Services;

use App\Repositories\ApiRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();
            $month = date('Ym');
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
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
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す
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
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
            $this->apiRepository->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
            $this->apiRepository->apiAlert($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す
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

            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=1';
            $this->apiRepository->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&keyword=PHP&start=101';
            $this->apiRepository->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=1';
            $this->apiRepository->apiConnpassPHP($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $next_month . '&keyword=PHP&start=101';
            $this->apiRepository->apiConnpassPHP($url);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            // 全てのエラー・例外をキャッチしてログに残す
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
        // try {
        //     DB::beginTransaction();
            $month = date('Ym');
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month . '&order=2&start=1';
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
        //     DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollback();
        //     // 全てのエラー・例外をキャッチしてログに残す
        //     Log::error($e);
        // }
    }

    /**
     * アラート処理を走らせるためのバッチ処理２回目
     *
     * @return void
     */
    public function alertSecondBatch()
    {
        // try {
        //     DB::beginTransaction();
            $next_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
            $month_after_next =  date('Ym', strtotime(date('Y-m-1') . '+2 month'));
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
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=1';
            $this->apiRepository->apiAlert($url);
            $url = 'https://connpass.com/api/v1/event/?count=100&ym=' . $month_after_next . '&order=2&start=101';
            $this->apiRepository->apiAlert($url);
        //     DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollback();
        //     // 全てのエラー・例外をキャッチしてログに残す
        //     Log::error($e);
        // }
    }
}
