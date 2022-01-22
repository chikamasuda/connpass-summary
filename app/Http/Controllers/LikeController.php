<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * お気に入りに追加
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    public function like(Event $event, Request $request)
    {
        $like = new Like();
        $like->event_id = $event->id;
        $like->ip = $request->ip();
        $like->save();
    }

    /**
     * お気に入りを削除
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    public function unlike(Event $event,Request $request)
    {
        $like = Like::where('event_id', $event->id)->where('ip', $request->ip())->first();
        $like->delete();
    }
}
