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
   * お気に入り登録順並び替え
   *
   * @param object $lists
   * @param string $sort
   * @return void
   */
  public function likeSort($lists, $sort)
  {
    if ($sort === 'like_asc') $lists->orderBy('like_id');
    if ($sort === 'like_desc') $lists->orderByDesc('like_id');

    return $lists;
  }

  /**
   * イベント検索
   * 
   * @param object $lists
   * @param string $keyword
   * @param string $start_date
   * @param string $end_date
   * @param string $sort
   * @return void
   */
  public function eventSearch($lists, $keyword, $start_date, $end_date, $sort)
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
    if ($sort === 'popular') $lists->OrderBy('accepted', 'desc');
    if ($sort === 'date_asc') $lists->OrderBy('date', 'asc')->OrderBy('accepted', 'desc');
    if ($sort === 'date_desc') $lists->OrderBy('date', 'desc')->OrderBy('accepted', 'desc');

    return $lists->paginate();
  }
}
