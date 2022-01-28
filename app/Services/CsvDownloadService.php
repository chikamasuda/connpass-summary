<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CsvDownloadService
{
    public $search_service;
    public $event;

    public function __construct(SearchService $search_service, Event $event)
    {
        $this->search_service = $search_service;
        $this->event = $event;
    }

    /**
     * 人気イベント一覧
     *
     * @param Request $request
     * @return void
     */
    public function getPopularEvent(Request $request)
    {
        //CSVの1行目にタイトルを入れる
        $csvHeader = ['No.', '参加希望人数', '定員人数', '開催日', '開始時間', '終了時間', 'タイトル', 'URL', 'グループ', '管理者名', '場所'];
        $timestamp = Carbon::now()->format('ymdhis');
        //ダウンロードファイル名
        $name = "人気イベント一覧_" . $timestamp . ".csv";
        $keyword = $request->input('keyword');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $sort = $request->input('sort');

        if ($sort === null) {
            $lists = Event::where('date', '>=', date('Y-m-d'))
                ->where('accepted', '>=', 50)
                ->orderByDesc('accepted')->get();
        } else {
            $lists = Event::where('date', '>=', date('Y-m-d'))
                ->where('accepted', '>=', 50);
            $lists = $this->eventSearchData($lists, $keyword, $start_date, $end_date, $sort)->get();
        }

        //ダウンロードデータを配列に入れて変数$dataに代入
        $data = $this->arrayData($lists);

        return $this->baseCSV($data, $csvHeader, $name);
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function getPhpEvent(Request $request)
    {
        //CSVの1行目にタイトを入れる
        $csvHeader = ['No.', '参加希望人数', '定員人数', '開催日', '開始時間', '終了時間', 'タイトル', 'URL', 'グループ', '管理者名', '場所'];
        $timestamp = Carbon::now()->format('ymdhis');
        //ダウンロードファイル名
        $name = "PHPイベント一覧_" . $timestamp . ".csv";

        $keyword = $request->input('php_keyword');
        $start_date = $request->input('php_start_date');
        $end_date = $request->input('php_end_date');
        $sort = $request->input('php_sort');

        if ($sort === null) {
            $lists = Event::where('date', '>=', date('Y-m-d'))
                ->where('php_flag', 1)
                ->orderBy('date', 'asc')
                ->orderBy('begin_time', 'asc')
                ->get();
        } else {
            $lists = Event::where('date', '>=', date('Y-m-d'))
                ->where('php_flag', 1);
            $lists = $this->eventSearchData($lists, $keyword, $start_date, $end_date, $sort)->get();
        }

        //ダウンロードデータを配列に入れて変数$dataに代入
        $data = $this->arrayData($lists);

        return $this->baseCSV($data, $csvHeader, $name);
    }

    /**
     * お気に入りイベントのダウンロード
     *
     * @param Request $request
     * @return void
     */
    public function getLikeEventData(Request $request)
    {
        //CSVの1行目にタイトルを入れる
        $csvHeader = ['No.', '参加希望人数', '定員人数', '開催日', '開始時間', '終了時間', 'タイトル', 'URL', 'グループ', '管理者名', '場所'];
        $timestamp = Carbon::now()->format('ymdhis');
        //ダウンロードファイル名
        $name = "お気に入りイベント一覧_" . $timestamp . ".csv";

        $keyword = $request->input('like_keyword');
        $start_date = $request->input('like_start_date');
        $end_date = $request->input('like_end_date');
        $sort = $request->input('like_sort');

        if ($sort === null) {
            $lists = Event::with('like')
                ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
                ->whereHas('like', function ($query) {
                    $query->where('ip', request()->ip());
                })
                ->get();
        } else {
            $lists = $this->event
                ->join('likes', 'likes.event_id', '=', 'events.id')
                ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
                ->where('ip', request()->ip());
            $lists = $this->likeEventSearchData($lists, $keyword, $start_date, $end_date, $sort)->get();
        }

        //ダウンロードデータを配列に入れて変数$dataに代入
        $data = $this->arrayData($lists);

        //ダウンロードデータが空の時、一つ前の遷移先に戻ってアラート表示を出す。
        if (empty($data)) {
            return back();
        }

        return $this->baseCSV($data, $csvHeader, $name);
    }

    /**
     * CSV作成の共通項目を別ファンクションにした
     * @param $data
     * @param $csvHeader
     * @param $name
     * @return array
     */
    private function baseCSV($data, $csvHeader, $name)
    {
        array_unshift($data, $csvHeader);
        $stream = fopen('php://temp', 'r+b');
        foreach ($data as $d) {
            fputcsv($stream, $d);
        }
        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $name,
        ];

        return ['csv' => $csv, 'headers' => $headers];
    }

    /**
     * 人気イベント・PHPイベントの検索結果データ
     *
     * @param object $lists
     * @param string $keyword
     * @param string $start_date
     * @param string $end_date
     * @param string $sort
     * @return void
     */
    private function eventSearchData($lists, $keyword, $start_date, $end_date, $sort)
    {
        // キーワード検索
        if (!empty($keyword)) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($keyword, 's');
            //キーワードを半角スペースごとに区切る
            $array_keyword = explode(' ', $spaceConversion);
            //キーワード絞り込み
            $lists->where(function ($query) use ($array_keyword) {
                foreach ($array_keyword as $keyword_item) {
                    $query->orWhere('title', 'like', "%{$keyword_item}%")
                        ->orWhere('group', 'like', "%{$keyword_item}%")
                        ->orWhere('owner', 'like', "%{$keyword_item}%")
                        ->orWhere('address', 'like', "%{$keyword_item}%");
                }
            });
        }

        //日付検索
        if (!empty($start_date)) $lists->where('date', '>=', $start_date);
        if (!empty($end_date)) $lists->where('date', '<=', $end_date);

        //並び替え
        if ($sort === 'popular') $lists->orderBy('accepted', 'desc');
        if ($sort === 'date_asc') $lists->orderBy('date', 'asc')->orderBy('begin_time', 'asc');
        if ($sort === 'date_desc') $lists->orderBy('date', 'desc')->orderBy('begin_time', 'asc');

        return $lists;
    }

    /**
     * お気に入りイベント検索結果データ
     *
     * @param object $lists
     * @param string $keyword
     * @param string $start_date
     * @param string $end_date
     * @param string $sort
     * @return void
     */
    private function likeEventSearchData($lists, $keyword, $start_date, $end_date, $sort)
    {
        // キーワード検索
        if (!empty($keyword)) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($keyword, 's');
            //キーワードを半角スペースごとに区切る
            $array_keyword = explode(' ', $spaceConversion);
            //キーワード絞り込み
            $lists->where(function ($query) use ($array_keyword) {
                foreach ($array_keyword as $keyword_item) {
                    $query->orWhere('title', 'like', "%{$keyword_item}%")
                        ->orWhere('group', 'like', "%{$keyword_item}%")
                        ->orWhere('owner', 'like', "%{$keyword_item}%")
                        ->orWhere('address', 'like', "%{$keyword_item}%");
                }
            });
        }

        //日付検索
        if (!empty($start_date)) $lists->where('date', '>=', $start_date);
        if (!empty($end_date)) $lists->where('date', '<=', $end_date);

        //並び替え
        if ($sort === 'like_asc') $lists->orderBy('like_id');
        if ($sort === 'like_desc') $lists->orderByDesc('like_id');
        if ($sort === 'popular') $lists->orderBy('accepted', 'desc');
        if ($sort === 'date_asc') $lists->orderBy('date', 'asc')->orderBy('begin_time', 'asc');
        if ($sort === 'date_desc') $lists->orderBy('date', 'desc')->orderBy('begin_time', 'asc');

        return $lists;
    }

    /**
     * ダウンロードされる配列データ
     *
     * @param object $lists
     * @return void
     */
    private function arrayData($lists)
    {
        foreach ($lists as $index => $d) {
            //この配列がダウンロードされるデータになる
            $arrayData['rank']       = $index + 1;
            $arrayData['accepted']   = $d->accepted;
            $arrayData['limit']      = $d->limit;
            $arrayData['date']       = $d->date->format('m月d日');
            $arrayData['begin_time'] = substr($d->begin_time, 0, 5);
            $arrayData['end_time']   = substr($d->end_time, 0, 5);
            $arrayData['title']      = $d->title;
            $arrayData['url']        = $d->url;
            $arrayData['group']      = $d->group;
            $arrayData['owner']      = $d->owner;
            $arrayData['address']    = $d->address;
            //上記をまとめてデータ化。
            $data[] = array_values($arrayData);
        }
        return $data;
    }
}
