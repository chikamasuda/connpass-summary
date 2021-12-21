@extends('layouts.app')

@section('content')
<section class="row container justify-content-center mx-auto pb-3">
    <div class="col-md-7 p-0 mt-4">
        <div class="card mt-2">
            <div class="card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold">
                    Connpass Summaryとは
                </h2>
            </div>
            <div class="card-body row">
                <div class="col-md-6 mt-2">
                    <div><img src="images/image1.png" alt="" class="image-block"></div>
                    <p class="pt-2 m-0 text-left">
                        IT勉強会支援プラットフォームConnpassの情報を取得し、まとめたツールです。
                    </p>
                </div> 
                <div class="col-md-6 mt-2">
                    <div><img src="images/image2.png" alt="" class="image-block"></div>
                    <p class="pt-2 m-0 text-left">
                        Connpassの参加人数50人以上のイベントや人気急上昇イベントをまとめています。
                    </p>
                </div> 
            </div>
        </div>
        <div class="card p-0 mt-3">
            <div class="pb-2 card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold pb-1 pt-1"><i class="fas fa-exclamation-triangle mr-1"></i>
                    人気急上昇イベント(直近24時間）
                </h2>
            </div>
            <div class="card-body mt-1">
                @foreach($lists as $list)
                <ul class="list-unstyled border-bottom pb-3">
                    <li class="font-weight-bold home-title"><a href="{{ $list->event->url }}" target="_blank" class="text-body">{{ $list->event->title }}</a></li>
                    <li class="list-unstyled pt-2">
                        <ul class="d-flex list-unstyled">
                            <li class="list-unstyled mr-3"><i class="far fa-clock text-primary mr-2"></i>{{ Str::substr($list->event->date, 5, 2) }}/{{ Str::substr($list->event->date, 8, 2) }} {{ $list->event->begin_time }}〜{{ $list->end_time }}</li>
                            <li class="list-unstyled"><i class="fas fa-map-marker-alt text-danger mr-2"></i>{{$list->event->address }}</li>
                        </ul>
                    </li>
                    <li class="pt-1 list-unstyled"><i class="fas fa-user-friends mr-1 text-dark"></i>{{ $list->event->group }}</li>
                    <li class="list-unstyled">
                        <ul class="d-flex list-unstyled justify-content-between">
                            <li class="pt-1 list-unstyled"><i class="fas fa-user-alt mr-2 mt-1 text-dark"></i>{{ $list->event->owner }}</li>
                            <li class="font-weight-bold text-right pt-1"><i class="fas fa-users text-dark"></i>
                                ＋{{ $list->diff }}人
                        </ul>
                    </li>
                </ul>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
    <div class="offset-md-1 p-0 col-md-4 justify-content-center mt-4">
        <h2 class="home-title font-weight-bold title-border pb-2 mt-2">
            ランキング
        </h2>
        <h3 class="mt-3 mb-3 rank-title">人気イベントランキング</h3>
        @foreach($events as $i => $event)
        <ul class="d-flex list-unstyled border-bottom pb-3">
            <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
            <li class="ml-2 text-dark event-title"><a href="{{ $event->url }}" target="_blank" class="text-dark">{{ $event->title }}</a></li>
        </ul>
        @endforeach
        <div class="text-right mb-3 text-primary">
            <a href="{{ route('popular') }}" class="text-primary"><span>▶︎</span>人気イベント一覧をみる</a>
        </div>
        <h3 class="mt-3 mb-3 rank-title">PHPの人気イベントランキング</h3>
        @foreach($php_events as $i => $php_event)
        <ul class="d-flex list-unstyled border-bottom pb-3">
            <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
            <li class="ml-2 text-dark event-title"><a href="{{ $php_event->url }}" target="_blank" class="text-dark">{{ $php_event->title }}</a></li>
        </ul>
        @endforeach
        <div class="text-right mb-3 text-primary">
            <a href="{{ route('php') }}" class="text-primary"><span>▶︎</span>PHPイベント一覧をみる</a>
        </div>
    </div>
</section>
@endsection