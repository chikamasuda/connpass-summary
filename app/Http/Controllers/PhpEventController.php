<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Models\Event;


class PhpEventController extends Controller
{
    public $search_service;

    public function __construct(SearchService $search_service)
    {
        $this->search_service = $search_service;
    }
    
    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function index()
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
    public function search(Request $request)
    {
        // リセットボタンが押された場合はセッションを消して一覧へリダイレクト
        if ($request->has('reset')) {
            $this->search_service->forgetOld();
            return redirect()->route('php');
        }

        $keyword = $request->input('php_keyword');
        $start_date = $request->input('php_start_date');
        $end_date = $request->input('php_end_date');
        $sort = $request->input('php_sort');
        $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1);

        $lists = $this->search_service->eventSearch($lists, $keyword, $start_date, $end_date, $sort);

        session()->flashInput($request->input());

        return view('php_event', compact('lists'));
    }
}
