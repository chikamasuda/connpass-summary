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
            return back()->with('flash_alert', 'イベント検索に失敗しました');
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
            return back()->with('flash_alert', 'お気に入り登録に失敗しました。');
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
            return back()->with('flash_alert', 'お気に入り削除に失敗しました。');
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
            //ダウンロードされるデータが空の時はオブジェクトで値が返ってくるためアラートを出す
            if (is_object($csvData)) {
                return back()->with('flash_alert', 'CSVダウンロード対象のデータがありません');
            }
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'CSVダウンロードに失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
