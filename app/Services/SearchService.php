<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


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
        try {
            if (session()->has('_old_input')) {
                session()->forget('_old_input');
            }
        } catch (\Throwable $e) {
            return redirect()->route('like.index')->with('flash_alert', '検索結果のリセットに失敗しました');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
    }

    /**
     * 人気イベント検索
     * 
     * @param object $lists
     * @param string $keyword
     * @param string $start_date
     * @param string $end_date
     * @param string $sort
     * @return void
     */
    public function searchPopularEvent($keyword, $start_date, $end_date, $sort)
    {
        $lists = Event::where('date', '>=', date('Y-m-d'))
            ->where('accepted', '>=', event::POPULAR_EVENT_NUMBER);

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

        return $lists->paginate(20);
    }

    /**
     * PHPイベント検索
     * 
     * @param string $keyword
     * @param string $start_date
     * @param string $end_date
     * @param string $sort
     * @return void
     */
    public function searchPhpEvent($keyword, $start_date, $end_date, $sort)
    {
        $lists = Event::where('date', '>=', date('Y-m-d'))
            ->where('php_flag', 1);

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

        return $lists->paginate(20);
    }

    /**
     * お気に入りイベント検索
     * 
     * @param object $lists
     * @param string $keyword
     * @param string $start_date
     * @param string $end_date
     * @param string $sort
     * @return void
     */
    public function searchLikeEvent($keyword, $start_date, $end_date, $sort)
    {
        $lists = DB::table('likes')->join('events', 'likes.event_id', '=', 'events.id')
                ->where('date', '>=',  Carbon::today()->format('Y-m-d'))
                ->where('ip', request()->ip());

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
        if ($sort === 'like_asc') $lists->orderBy('like_id', 'asc');
        if ($sort === 'like_desc') $lists->orderBy('like_id', 'desc');
        if ($sort === 'popular') $lists->orderBy('accepted', 'desc');
        if ($sort === 'date_asc') $lists->orderBy('date', 'asc')->orderBy('begin_time', 'asc');
        if ($sort === 'date_desc') $lists->orderBy('date', 'desc')->orderBy('begin_time', 'asc');

        return $lists->paginate(20);
    }
}