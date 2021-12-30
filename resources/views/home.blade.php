@extends('layouts.app')

@section('content')
<div class="row justify-content-center mx-auto top-block shadow-sm">
    <div class="container">
        <div class="col-md-12 p-0 mt-4 mb-4">
            <div class="mt-2 bg-white mb-2 home-block">
                <div class="row pt-2 pl-3 pr-3">
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image1.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left">
                            コンセプトは「自分が好きそうなイベントを逃さないためのAPI駆動アプリ」です。
                        </p>
                    </div>
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image2.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left">
                            IT勉強会支援プラットフォームConnpassの情報をConnpassAPIで取得し、自動更新しています。
                        </p>
                    </div>
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image3.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left">
                            Connpassの人気急上昇イベントや参加人数50名以上の人気イベントなどをまとめています。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="" style="background: #fff;">
    <div class="row container justify-content-center pb-3 mx-auto">
        <div class="col-md-7 p-0 mt-4">
            <h2 class="title pb-2 title-border pt-2 mb-1">
                人気急上昇イベント(直近24時間)
            </h2>
            <div class="mb-4">
                @foreach($lists as $list)
                <ul class="list-unstyled border-bottom pb-3 pt-3 m-0">
                    <li class="card-title text-dark"><a href="{{ $list->event->url }}" target="_blank" class="text-body">{{ $list->event->title }}</a></li>
                    <li class="list-unstyled">{{ $list->event->catch }}</li>
                    <li class="list-unstyled mr-3 pt-2"><i class="far fa-clock mr-1 text-dark"></i>{{ Str::substr($list->event->date, 5, 2) }}/{{ Str::substr($list->event->date, 8, 2) }} {{ $list->event->begin_time }}〜{{ $list->event->end_time }}</li>
                    <li class="list-unstyled pt-1"><i class="fas fa-map-marker-alt text-danger mr-2"></i>{{$list->event->address }}</li>
                    <li class="pt-1 list-unstyled"><i class="fas fa-user-friends mr-1 text-dark"></i>{{ $list->event->group }}</li>
                    <li class="list-unstyled mt-1">
                        <ul class="list-unstyled">
                            <li class="text-right mt-1"><i class="fas fa-users text-dark"></i>
                                ＋{{ $list->diff }}人
                        </ul>
                    </li>
                </ul>
                @endforeach
            </div>
        </div>
        <div class="offset-md-1 p-0 col-md-4 justify-content-center mt-4 mb-4">
            <h2 class="title pb-2 title-border pt-2 mb-3">ランキング</h2>
            <div class="bg-white">
                <h3 class="rank-title pb-2">人気イベントランキング</h3>
                @foreach($events as $i => $event)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
                    <li class="ml-2 event-title"><a href="{{ $event->url }}" target="_blank" class="text-dark">{{ $event->title }}</a></li>
                </ul>
                @endforeach
                <div class="text-right text-primary mb-4">
                    <a href="{{ route('popular') }}" class="text-primary"><span>▶︎</span>人気イベント一覧をみる</a>
                </div>
                <h3 class="rank-title pb-2">PHP人気イベントランキング</h3>
                @foreach($php_events as $i => $php_event)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
                    <li class="ml-2 event-title"><a href="{{ $php_event->url }}" target="_blank" class="text-dark">{{ $php_event->title }}</a></li>
                </ul>
                @endforeach
                <div class="text-right text-primary">
                    <a href="{{ route('php') }}" class="text-primary"><span>▶︎</span>PHPイベント一覧をみる</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection