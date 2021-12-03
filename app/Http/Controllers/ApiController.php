<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    /**
     * 人気イベントバッチ処理当月
     *
     * @return void
     */
    public function popularEventBatch()
    {
        $this->apiService->popularEventBatch();
    }

    /**
     * 人気イベントバッチ処理翌月
     *
     * @return void
     */
    public function popularEventBatchSecond()
    {
        $this->apiService->popularEventBatchSecond();
    }

    /**
     * PHPイベントの自動更新バッチ
     *
     * @return void
     */
    public function phpEventBatch()
    {
        $this->apiService->phpEventBatch();
    }

    /**
     * アラート処理を走らせるためのバッチ
     *
     * @return void
     */
    public function alertBatch()
    {
        $this->apiService->alertBatch();
    }

    /**
     * アラート処理を走らせるためのバッチ処理２回目
     *
     * @return void
     */
    public function alertSecondBatch()
    {
        $this->apiService->alertSecondBatch();
    }
}
