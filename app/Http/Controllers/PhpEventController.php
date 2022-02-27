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
    /**
     * PHPイベント一覧・検索結果表示
     *
     * @return void
     */
    public function index(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            SearchService::forgetOld();
            return redirect()->route('php.index');
        }

        try {
            $keyword = $request->input('php_keyword');
            $start_date = $request->input('php_start_date');
            $end_date = $request->input('php_end_date');
            $sort = $request->input('php_sort');
            if(empty($sort)) {
                $lists = Event::getPhpEventList();
            } else {
                $lists = SearchService::searchPhpEvent($keyword, $start_date, $end_date, $sort);
            }
            
        } catch (\Throwable $e) {
            return back()->with('flash_alert', config('message.flash_alert.event_search'));
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
            $csvData = CsvDownloadService::getPhpEvent($request);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', config('message.flash_alert.csv_download'));
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}