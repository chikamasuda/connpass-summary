<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\SearchService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use App\Services\CsvDownloadService;
use App\Services\LikeService;
use Illuminate\Support\Facades\Response;

class LikeController extends Controller
{
    private $search_service, $like, $csv_download_service;

    public function __construct(SearchService $search_service, Like $like, CsvDownloadService $csv_download_service)
    {
        $this->search_service = $search_service;
        $this->like = $like;
        $this->csv_download_service = $csv_download_service;
    }

    /**
     * お気に入り一覧画面表示
     *
     * @return void
     */
    public function index(Event $event)
    {
        $lists = $this->like->LikeEventListData();

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
            $this->like->insertLikeData($request, $event);
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
            $this->like->deleteLike($request, $event);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('flash_alert', 'お気に入り削除に失敗しました。');
            Log::error($e);
        }
    }

    /**
     * お気に入りイベント検索
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            $this->search_service->forgetOld();
            return redirect()->route('like.index');
        }

        try {
            $keyword = $request->input('like_keyword');
            $start_date = $request->input('like_start_date');
            $end_date = $request->input('like_end_date');
            $sort = $request->input('like_sort');
            $lists = $this->search_service->likeEventSearch($keyword, $start_date, $end_date, $sort);
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'イベント検索に失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }

        return view('like_event', compact('lists'));
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
            $csvData = $this->csv_download_service->getLikeEventData($request);
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
