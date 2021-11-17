<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;


class SearchService
{
  /**
   * 人気イベント検索
   *
   * @return void
   */
  public function searchPopularEvents($keyword, $start_date, $end_date, $address)
  {
    $lists = Event::where('date', '>=', date('Y-m-d'))
      ->where('date', '<', date('Ymd', strtotime('first day of next month')))
      ->where('accepted', '>=', 50)
      ->OrderBy('accepted', 'desc');

    // キーワード検索
    if (!empty($keyword)) {
      $lists->where('title', 'LIKE', "%{$keyword}%");
    }

    //日付検索
    if (!empty($start_date)) {
      $lists->where('date', '>=', $start_date);
    }

    if (!empty($end_date)) {
      $lists->where('date', '<=', $end_date);
    }

    // 場所検索
    if (!empty($address)) {
      $lists->where('address', 'LIKE', "%{$address}%");
    }


    return $lists->paginate(50);
  }
}
