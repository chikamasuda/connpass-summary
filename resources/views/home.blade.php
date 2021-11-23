@extends('layouts.app')

@section('content')
<div class="row  pt-4 container mx-auto">
    <div class="col-md-7 p-0">
        <div class="card">
            <div class="card-header pt-3">
                <i class="fas fa-home mr-2"></i><strong style="font-size: 16px;">HOME</strong>
            </div>
            <div class="card-body">
                Connpass Summaryは技術勉強会まとめサイトです。このサイトは、Connpass(https://connpass.com/)から情報を取得しています。
            </div>
        </div>
        <div class="card p-0">
            <div class="card-header pt-3  d-flex justify-content-between">
                <div><i class="fas fa-exclamation-triangle mr-2 text-danger"></i>
                    <strong style="font-size: 16px;">人気急上昇({{ \Carbon\Carbon::now()->format("m/d" )}}：前日比）</strong>
                </div>
                <a href="" style="font-size: 14px;" class="text-dark font-weight-bold"></a>
            </div>
            <div class="card-body">
                @foreach($events as $list)
                <ul class="d-flex list-unstyled">
                    <li style="width: 15%;" class="font-weight-bold">{{ Str::substr($list->date, 5, 2) }}/{{ Str::substr($list->date, 8, 2) }} </li>
                    <li style="width: 60%;" class="font-weight-bold ml-2 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{ Str::substr($list->title, 0, 37) }}</a></li>
                    <li style="width: 25%;" class="font-weight-bold text-right">{{ $list->accepted }}人<i class="fas fa-level-up-alt ml-2"></i></li>
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