@extends('layouts.app')

@section('content')
<section class="row  pt-4 container mx-auto">
    <div class="col-md-7 p-0 pt-4">
        <div class="card">
            <div class="mb-2 mt-2 pb-2 card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold pb-2"><i class="fas fa-home mr-2"></i>
                    HOME
                </h2>
            </div>
            <div class="card-body">
                Connpass Summaryは技術勉強会まとめサイトです。Connpassの50人以上参加の人気イベントや人気急上昇イベント、PHPのイベントをピックアップしています。このサイトは、Connpass(https://connpass.com/)から情報を取得しています。
            </div>
        </div>
        <div class="card p-0">
            <div class="mb-2 mt-2 pb-2 card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold pb-2"><i class="fas fa-exclamation-triangle mr-2 text-danger"></i>
                    人気急上昇イベント({{ \Carbon\Carbon::yesterday()->format("m/d" )}}）
                </h2>
            </div>
            <div class="card-body mt-2">
                @foreach($events as $list)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li style="width: 13%;" class="font-weight-bold">{{ Str::substr($list->event->date, 5, 2) }}/{{ Str::substr($list->event->date, 8, 2) }} </li>
                    <li style="width: 57%;" class="font-weight-bold ml-2 text-dark"><a href="{{ $list->event->url }}" target="_blank" class="text-dark">{{ $list->event->title }}</a></li>
                    <li style="width: 25%;" class="font-weight-bold text-right">{{ $list->diff }}人<i class="fas fa-level-up-alt ml-2"></i></li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
    <div class="offset-md-1 col-md-4 p-0 mt-4">
        <div class="card">
            <div class="mb-2 mt-2 pb-2 card-header font-weight-bold d-flex justify-content-between">
                <h2 class="home-title font-weight-bold pb-2"><i class="fas fa-fire text-warning mr-1"></i>
                    人気ランキング
                    <a href="{{ route('popular') }}" class="text-dark title-url ml-4"><span>▶︎</span> 人気イベント一覧をみる</a>
                </h2>
            </div>
            <div class="card-body">
                @foreach($lists as $i => $list)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li style="width: 24px;" class="ranking-number ml-2">{{ $i+1 }}</li>
                    <li style="width: 90%;" class="font-weight-bold ml-2 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{ $list->title }}</a></li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection