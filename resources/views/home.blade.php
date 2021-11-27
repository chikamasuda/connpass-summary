@extends('layouts.app')

@section('content')
<div class="row  pt-4 container mx-auto">
    <div class="col-md-7 p-0">
        <div class="card">
            <div class="card-header pt-3">
                <i class="fas fa-home mr-2"></i><strong style="font-size: 16px;">HOME</strong>
            </div>
            <div class="card-body">
                Connpass Summaryは技術勉強会まとめサイトです。Connpassの50人以上参加の人気イベントや人気急上昇イベント、PHPのイベントをピックアップしています。このサイトは、Connpass(https://connpass.com/)から情報を取得しています。
            </div>
        </div>
        <div class="card p-0">
            <div class="card-header pt-3  d-flex justify-content-between">
                <div><i class="fas fa-exclamation-triangle mr-2 text-danger"></i>
                    <strong style="font-size: 16px;">人気急上昇イベント(24時間単位）</strong>
                </div>
                <a href="" style="font-size: 14px;" class="text-dark font-weight-bold"></a>
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
    <div class="offset-md-1 col-md-4 p-0">
        <div class="card">
            <div class="mb-4 card-header pb-2 font-weight-bold d-flex justify-content-between pt-3 pb-3" style="font-size: 16px;">
                <div>人気ランキング</div>
                <a href="{{ route('popular') }}" style="font-size: 14px;" class="text-dark"><span>▶︎</span> 人気イベント一覧をみる</a>
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
</div>
@endsection