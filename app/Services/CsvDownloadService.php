<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;


class CsvDownloadService
{
  public $search_service;
  

  public function __construct(SearchService $search_service)
  {
    $this->search_service = $search_service;
  }

  /**
   * 人気イベント一覧
   *
   * @return void
   */
  public function getPopularEvent(Request $request)
  {
    //CSVの1行目にタイトを入れる
    $csvHeader = ['順位', '参加希望人数', '定員人数', '日付', '開始時間', '終了時間', 'タイトル', 'URL', 'グループ', '管理者名', '場所'];
    $timestamp = Carbon::now()->format('ymdhis');
    //ダウンロードファイル名
    $name = "人気イベント一覧_" . $timestamp . ".csv";

    $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('accepted', '>=', 50)
            ->OrderBy('accepted', 'desc')
            ->get();

    // データがない場合はリダイレクト
    if (!$lists) {
      return back()->with('flash_alert', '対象データがありませんでした');
     }

    foreach ($lists as $index => $d) {
      //この配列がダウンロードされるデータになる
      $arrayData['rank']       = $index + 1;
      $arrayData['accepted']   = $d->accepted;
      $arrayData['limit']      = $d->limit;
      $arrayData['date']       = $d->date->format('Y年m月d日');
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
    $csvHeader = ['No.', '参加希望人数', '定員人数', '日付', '開始時間', '終了時間', 'タイトル', 'URL', 'グループ', '管理者名', '場所'];
    $timestamp = Carbon::now()->format('ymdhis');
    //ダウンロードファイル名
    $name = "PHPイベント一覧_" . $timestamp . ".csv";
    $lists = Event::where('date', '>', Carbon::yesterday())
            ->where('php_flag', 1)
            ->orderBy('date', 'asc')
            ->get();

    foreach ($lists as $index => $d) {
      //この配列がダウンロードされるデータになる
      $arrayData['rank']       = $index + 1;
      $arrayData['accepted']   = $d->accepted;
      $arrayData['limit']      = $d->limit;
      $arrayData['date']       = $d->date->format('Y年m月d日');
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
