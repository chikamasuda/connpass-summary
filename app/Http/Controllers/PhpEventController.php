<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SearchService;
use App\Services\CsvDownloadService;
use App\Models\Event;
use Illuminate\Support\Facades\Response;

class PhpEventController extends Controller
{
    private $search_service, $csv_download_service; 

    public function __construct(SearchService $search_service, CsvDownloadService $csv_download_service)
    {
        $this->search_service = $search_service;
        $this->csv_download_service = $csv_download_service;
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function index()
    {
        $lists = Event::where('date', '>=', date('Y-m-d'))
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->orderBy('begin_time', 'asc')
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
            return redirect()->route('php.index');
        }

        $keyword = $request->input('php_keyword');
        $start_date = $request->input('php_start_date');
        $end_date = $request->input('php_end_date');
        $sort = $request->input('php_sort');
        $lists = Event::where('date', '>=', date('Y-m-d'))
            ->where('php_flag', 1);

        $lists = $this->search_service->eventSearch($lists, $keyword, $start_date, $end_date, $sort);

        session()->flashInput($request->input());

        return view('php_event', compact('lists'));
    }

    /**
     * PHPイベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPhpEvent(Request $request)
    {
        $csvData = $this->csv_download_service->getPhpEvent($request);

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
