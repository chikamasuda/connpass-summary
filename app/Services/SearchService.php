<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;


class SearchService
{
  /**
   * session(oldの値)があれば消去する
   *「検索結果をリセット」用のセッション削除（検索結果を全て削除）
   *
   * @return void
   */
  public function forgetOld()
  {
    if (session()->has('_old_input')) {
      session()->forget('_old_input');
    }
  }

  /**
   * 人気イベント検索
   *
   * @return void
   */
  public function searchPopularEvents($keyword, $date, $address)
  {
    $lists = Event::where('date', '>=', date('Y-m-d'))
      ->where('date', '<', date('Ymd', strtotime('first day of next month')))
      ->where('accepted', '>=', 50)
      ->OrderBy('accepted', 'desc');

    // キーワード検索
    if (!empty($keyword)) {
      // 全角スペースを半角に変換
      $spaceConversion = mb_convert_kana($keyword, 's');
      //キーワードを半角スペースごとに区切る
      $array_keyword = explode(' ', $spaceConversion);

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
    if (!empty($date)) {
      $lists->where('date', $date);
    }

    // 場所検索
    if (!empty($address)) {
      $lists->where('address', 'LIKE', "%{$address}%");
    }

    return $lists->paginate(50);
  }

  /**
   * PHPイベント検索
   *
   * @return void
   */
  public function searchPhpEvents($keyword, $date, $address)
  {
    $lists = Event::where('date', '>', Carbon::yesterday())
      ->where('date', '<', date('Ymd', strtotime('first day of next month')))
      ->where('php_flag', 1)
      ->orderBy('date', 'asc');

    // キーワード検索
    if (!empty($keyword)) {
      // 全角スペースを半角に変換
      $spaceConversion = mb_convert_kana($keyword, 's');
      //キーワードを半角スペースごとに区切る
      $array_keyword = explode(' ', $spaceConversion);

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
    if (!empty($date)) {
      $lists->where('date',  $date);
    }

    // 場所検索
    if (!empty($address)) {
      $lists->where('address', 'LIKE', "%{$address}%");
    }

    return $lists->paginate(50);
  }
}
