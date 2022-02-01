<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Models\Event;
use App\Services\CsvDownloadService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;


class PopularEventController extends Controller
{
    private $search_service, $csv_download_service, $event;

    public function __construct(SearchService $search_service, CsvDownloadService $csv_download_service, Event $event)
    {
        $this->search_service = $search_service;
        $this->csv_download_service = $csv_download_service;
        $this->event = $event;
    }

    /**
     * 人気イベント一覧
     *
     * @param Event $event
     * @return void
     */
    public function index(Event $event)
    {
        $lists = $this->event->getPopularEventList();

        return view('popular_event', compact('lists', 'event'));
    }

    /**
     * 人気イベント検索
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            $this->search_service->forgetOld();
            return redirect()->route('popular.index');
        }

        try {
            $keyword = $request->input('keyword');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $sort = $request->input('sort');
            $lists = $this->search_service->searchPopularEvent($keyword, $start_date, $end_date, $sort);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'イベント検索に失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return view('popular_event', compact('lists'));
    }

    /**
     * 人気イベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPopularEvent(Request $request)
    {
        try {
            $csvData = $this->csv_download_service->getPopularEvent($request);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'CSVダウンロードに失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
