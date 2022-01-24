<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Models\Event;


class PopularEventController extends Controller
{
    public $search_service;

    public function __construct(SearchService $search_service)
    {
        $this->search_service = $search_service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Event $event)
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(20);
        
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
            return redirect()->route('popular');
        }

        $keyword = $request->input('keyword');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $sort = $request->input('sort');
        $lists = Event::where('date', '>=', date('Y-m-d'))
            ->where('accepted', '>=', 50);

        $lists = $this->search_service->eventSearch($lists, $keyword, $start_date, $end_date, $sort);

        session()->flashInput($request->input());

        return view('popular_event', compact('lists'));
    }

}
