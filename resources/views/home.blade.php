@extends('layouts.app')

@section('content')
<main class="row  mt-4 container mx-auto">
    <section class="col-md-7 p-0 mt-2">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between bg-light">
                <h2 class="home-title font-weight-bold pb-1 pt-1"><i class="fas fa-home mr-2"></i>
                    HOME
                </h2>
            </div>
            <div class="card-body">
                Connpass Summaryは技術勉強会まとめサイトです。Connpassの50人以上参加の人気イベントや人気急上昇イベント、PHPのイベントをピックアップしています。このサイトは、Connpass(https://connpass.com/)から情報を取得しています。
            </div>
        </div>
        <div class="card p-0">
            <div class="mb-2 pb-2 card-header font-weight-bold d-flex justify-content-between bg-light">
                <h2 class="home-title font-weight-bold pb-1 pt-1"><i class="fas fa-exclamation-triangle mr-2"></i>
                    人気急上昇イベント(直近24時間）
                </h2>
            </div>
            <div class="card-body mt-1">
                @foreach($events as $list)
                <ul class="list-unstyled border-bottom pb-3">
                    <li class="font-weight-bold home-title"><a href="{{ $list->event->url }}" target="_blank" class="text-body">{{ $list->event->title }}</a></li>
                    <li class="list-unstyled pt-2">
                        <ul class="d-flex list-unstyled">
                            <li class="list-unstyled mr-3"><i class="far fa-clock text-success mr-2"></i>{{ Str::substr($list->event->date, 5, 2) }}/{{ Str::substr($list->event->date, 8, 2) }} {{ $list->event->begin_time }}〜{{ $list->event->end_time }}</li>
                            <li class="list-unstyled"><i class="fas fa-map-marker-alt text-danger mr-2"></i>{{$list->event->address }}</li>
                        </ul>
                    </li>
                    <li class="pt-2 list-unstyled"><i class="fas fa-user-friends mr-1 text-dark"></i>{{ $list->event->group }}</li>
                    <li class="pt-2 list-unstyled"><i class="fas fa-user-alt mr-2 mt-1 text-primary"></i>{{ $list->event->owner }}</li>
                    <li class="font-weight-bold text-right pt-1"><i class="fas fa-users text-warning"></i>
                        ＋{{ $list->diff }}人
                    </li>
                </ul>
                </ul>
                @endforeach
            </div>
        </div>
    </section>
    <aside class="offset-md-1 col-md-4 p-0 mt-2">
        <h2 class="home-title font-weight-bold pb-1 pt-1 title-border pb-2 mb-4">
            人気イベントランキング
        </h2>
        @foreach($lists as $i => $list)
        <ul class="d-flex list-unstyled border-bottom pb-3">
            <li style="width: 24px;" class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
            <li style="width: 90%;" class="font-weight-bold ml-2 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{ $list->title }}</a></li>
        </ul>
        @endforeach
        <div class="text-right mb-3">
            <a href="{{ route('popular') }}"><span>▶︎</span> 人気イベント一覧をみる</a>
        </div>
    </aside>
</main>
@endsection