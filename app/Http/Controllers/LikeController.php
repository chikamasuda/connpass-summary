<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\SearchService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Like;

class LikeController extends Controller
{
    public $search_service;
    public $event;

    public function __construct(SearchService $search_service, Event $event)
    {
        $this->search_service = $search_service;
        $this->event = $event;
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
            return redirect()->route('like');
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
}