<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;


class CsvDownloadService
{
    /**
     * 人気イベント一覧
     *
     * @return void
     */
    public function getPopularEvent()
    {
        //CSVの1行目にタイトを入れる
        $csvHeader = ['順位', '参加希望人数', '定員人数', '日付', '開始時間', '終了時間', 'タイトル', 'グループ', '管理者名', '場所'];
        $timestamp = Carbon::now()->format('ymdhis');
        //ダウンロードファイル名
        $name = "人気イベント一覧_" . $timestamp . ".csv";

        $events = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->get();

        foreach ($events as $index => $d) {
            //この配列がダウンロードされるデータになる
            $arrayData['rank']       = $index + 1;
            $arrayData['accepted']   = $d->accepted;
            $arrayData['limit']      = $d->limit;
            $arrayData['date']       = $d->date;
            $arrayData['begin_time'] = $d->begin_time;
            $arrayData['end_time']   = $d->end_time;
            $arrayData['title']      = $d->title;
            $arrayData['group']      = $d->group;
            $arrayData['owner']      = $d->owner;
            $arrayData['address']    = $d->address;

            //上記をまとめてデータ化。
            $data[] = array_values($arrayData);
        }

        return $this->baseCSV($data, $csvHeader, $name);
    }

    /**
     * PHPイベント一覧
     *
     * @return void
     */
    public function getPhpEvent()
    {
        //CSVの1行目にタイトを入れる
        $csvHeader = ['No.', '参加希望人数', '定員人数', '日付', '開始時間', '終了時間', 'タイトル', 'グループ', '管理者名', '場所'];
        $timestamp = Carbon::now()->format('ymdhis');
        //ダウンロードファイル名
        $name = "PHPイベント一覧_" . $timestamp . ".csv";

        $events = Event::where('date', '>', Carbon::yesterday())
            ->where('date', '<', date('Ymd', strtotime('first day of next month')))
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->get();

        foreach ($events as $index => $d) {
            //この配列がダウンロードされるデータになる
            $arrayData['rank']       = $index + 1;
            $arrayData['accepted']   = $d->accepted;
            $arrayData['limit']      = $d->limit;
            $arrayData['date']       = $d->date;
            $arrayData['begin_time'] = $d->begin_time;
            $arrayData['end_time']   = $d->end_time;
            $arrayData['title']      = $d->title;
            $arrayData['group']      = $d->group;
            $arrayData['owner']      = $d->owner;
            $arrayData['address']    = $d->address;

            //上記をまとめてデータ化。
            $data[] = array_values($arrayData);
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
}
