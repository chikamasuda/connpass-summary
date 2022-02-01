<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Services\CsvDownloadService;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class PhpEventController extends Controller
{
    private $search_service, $csv_download_service, $event;

    public function __construct(SearchService $search_service, CsvDownloadService $csv_download_service, Event $event)
    {
        $this->search_service = $search_service;
        $this->csv_download_service = $csv_download_service;
        $this->event = $event;
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function index()
    {
        $lists = $this->event->getPhpEventList();

        return view('php_event', compact('lists'));
    }

    /**
     * PHPイベント検索
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            $this->search_service->forgetOld();
            return redirect()->route('php.index');
        }

        try {
            $keyword = $request->input('php_keyword');
            $start_date = $request->input('php_start_date');
            $end_date = $request->input('php_end_date');
            $sort = $request->input('php_sort');
            $lists = $this->search_service->searchPhpEvent($keyword, $start_date, $end_date, $sort);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'イベント検索に失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return view('php_event', compact('lists'));
    }

    /**
     * PHPイベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPhpEvent(Request $request)
    {
        try {
            $csvData = $this->csv_download_service->getPhpEvent($request);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'CSVダウンロードに失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}