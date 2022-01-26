<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\SearchService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Like;
use App\Services\CsvDownloadService;
use Illuminate\Support\Facades\Response;

class LikeController extends Controller
{
    public $search_service;
    public $event;
    public $csv_download_service;

    public function __construct(SearchService $search_service, Event $event, CsvDownloadService $csv_download_service)
    {
        $this->search_service = $search_service;
        $this->event = $event;
        $this->csv_download_service = $csv_download_service;
    }

    /**
     * お気に入り一覧画面表示
     *
     * @return void
     */
    public function index(Event $event)
    {
        $lists = Event::with('like')
            ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
            ->whereHas('like', function ($query) {
                $query->where('ip', request()->ip());
            })
            ->paginate(20);

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
        $like = new Like();
        $like->event_id = $event->id;
        $like->ip = $request->ip();
        $like->save();

        return [
            'id' => $event->id,
        ];
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
        $like = Like::where('event_id', $event->id)->where('ip', $request->ip())->first();
        $like->delete();

        $lists = Event::with('like')
            ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
            ->whereHas('like', function ($query) {
                $query->where('ip', request()->ip());
            })
            ->get();
        
        $count = count($lists);

        return [
            'id' => $event->id,
            'count' => $count,
        ];
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

        $keyword = $request->input('like_keyword');
        $start_date = $request->input('like_start_date');
        $end_date = $request->input('like_end_date');
        $sort = $request->input('like_sort');

        $lists = $this->event
            ->join('likes', 'likes.event_id', '=', 'events.id')
            ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
            ->where('ip', request()->ip());

        $lists = $this->search_service->likeSort($lists, $sort);
        $lists = $this->search_service->eventSearch($lists, $keyword, $start_date, $end_date, $sort);

        session()->flashInput($request->input());

        return view('like_event', compact('lists'));
    }

    /**
     * お気に入り一覧ダウンロード
     *
     * @param Request $request
     * @return void
     */
    public function downloadLikeEvent(Request $request)
    {
        $csvData = $this->csv_download_service->getLikeEvent($request);

        //ダウンロードされるデータが空の時はオブジェクトで値が返ってくるためアラートを出す
        if(is_object($csvData)) {
            return back()->with('flash_alert', 'CSVダウンロード対象のデータがありません');
        }

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
