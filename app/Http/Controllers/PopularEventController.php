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
    /**
     * 人気イベント一覧・検索結果一覧
     *
     * @param Event $event
     * @return void
     */
    public function index(Request $request, Event $event)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            SearchService::forgetOld();
            return redirect()->route('popular.index');
        }

        try {
            $keyword = $request->input('keyword');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $sort = $request->input('sort');
            if (empty($sort)) {
                $lists = Event::getPopularEventList();
            } else {
                $lists = SearchService::searchPopularEvent($keyword, $start_date, $end_date, $sort);
            }
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'イベント検索に失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return view('popular_event', compact('lists', 'event'));
    }

    /**
     * 人気イベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPopularEvent(Request $request)
    {
        try {
            $csvData = CsvDownloadService::getPopularEvent($request);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'CSVダウンロードに失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
