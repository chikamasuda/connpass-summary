<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\SearchService;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use App\Services\CsvDownloadService;
use Illuminate\Support\Facades\Response;

class LikeController extends Controller
{
    /**
     * お気に入り一覧画面表示・検索結果表示
     *
     * @return void
     */
    public function index(Request $request, Event $event)
    {
         // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
         if ($request->has('reset')) {
            SearchService::forgetOld();
            return redirect()->route('like.index');
        }

        try {
            $keyword = $request->input('like_keyword');
            $start_date = $request->input('like_start_date');
            $end_date = $request->input('like_end_date');
            $sort = $request->input('like_sort');
            if(empty($sort)) {
                $lists = Like::getLikeEventListData();
            } else {
                $lists = SearchService::searchLikeEvent($keyword, $start_date, $end_date, $sort);
            }
        } catch (\Throwable $e) {
            return back()->with('flash_alert', config('message.flash_alert.event_search'));
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
        return view('like_event', compact('lists'));
    }

    /**
     * お気に入りに追加
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    public function like(Event $event, Request $request)
    {
        DB::beginTransaction();
        try {
            Like::insertLikeData($request, $event);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('flash_alert', config('message.flash_alert.save_like'));
            Log::error($e);
        }
    }

    /**
     * お気に入りを削除
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    public function unlike(Event $event, Request $request)
    {
        DB::beginTransaction();
        try {
            Like::deleteLike($request, $event);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('flash_alert', config('message.flash_alert.delete_like'));
            Log::error($e);
        }
    }

    /**
     * お気に入り一覧CSVダウンロード
     *
     * @param Request $request
     * @return void
     */
    public function downloadLikeEvent(Request $request)
    {
        try {
            $csvData = CsvDownloadService::getLikeEvent($request);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', config('message.flash_alert.csv_download'));
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
