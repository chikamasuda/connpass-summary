<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Models\Event;

class EventController extends Controller
{
    public $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function popularEvent()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->paginate(20);

        return view('popular_event', compact('lists'));
    }

   /**
    * 人気イベント検索
    *
    * @param Request $request
    * @return void
    */
    public function popularEventSearch(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            $this->searchService->forgetOld();
            return redirect()->route('popular');
        }

        $keyword = $request->input('keyword');
        $date = $request->input('date');
        $address = $request->input('address');

        $lists = $this->searchService->searchPopularEvents($keyword, $date, $address);

        session()->flashInput($request->input());

        return view('popular_event', compact('lists'));
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function phpEvent()
    {
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->paginate(20);

        return view('php_event', compact('lists'));
    }

    /**
     * PHPイベント検索
     *
     * @param Request $request
     * @return void
     */
    public function phpEventSearch(Request $request)
    {
         // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
         if ($request->has('reset')) {
            $this->searchService->forgetOld();
            return redirect()->route('php');
        }

        $keyword = $request->input('php_keyword');
        $date = $request->input('php_date');
        $address = $request->input('php_address');

        $lists = $this->searchService->searchPhpEvents($keyword, $date, $address);

        session()->flashInput($request->input());

        return view('php_event', compact('lists'));
    }
}
