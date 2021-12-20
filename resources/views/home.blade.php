@extends('layouts.app')

@section('content')
<section class="row container justify-content-center mx-auto pb-3">
    <div class="col-md-7 p-0 mt-4">
        <div class="card mt-2">
            <div class="card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold">
                    HOME
                </h2>
            </div>
            <div class="card-body row">
                <div class="col-md-6 mt-2 text-center">
                    <div class=""><img src="images/image1.png" alt="" width="290px" height="160px"></div>
                    <p class="pt-2 m-0">
                        Connpass(https://connpass.com/)から情報を取得しています。
                    </p>
                </div> 
                <div class="col-md-6 mt-2 text-center">
                    <img src="images/image2.png" alt="" width="290px" height="160px">
                    <p class="pt-2 m-0">
                        50人以上参加のイベントや人気急上昇イベントをピックアップしています。
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
                @foreach($events as $list)
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
        <h2 class="home-title font-weight-bold title-border pb-2 mb-4 mt-2">
            人気イベントランキング
        </h2>
        @foreach($lists as $i => $list)
        <ul class="d-flex list-unstyled border-bottom pb-3">
            <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
            <li style="width: 90%;" class="font-weight-bold ml-2 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{ $list->title }}</a></li>
        </ul>
        @endforeach
        <div class="text-right mb-3 text-primary">
            <a href="{{ route('popular') }}" class="text-primary"><span>▶︎</span> 人気イベント一覧をみる</a>
        </div>
    </div>
</section>
@endsection