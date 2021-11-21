@extends('layouts.app')

@section('content')
<div class="row  pt-4 container mx-auto">
<div class="col-md-7">
    <div class="card">
        <div class="card-header pt-3">
        <i class="fas fa-home mr-2"></i><strong style="font-size: 16px;">HOME</strong>
        </div>
        <div class="card-body">
           Connpass Summaryは技術勉強会まとめサイトです。このサイトは、Connpass(https://connpass.com/)から情報を取得しています。
        </div>
    </div>
    <div class="card p-0">
        <div class="card-header mb-4 pt-3">
            <i class="fas fa-exclamation-triangle mr-2 text-danger"></i><strong style="font-size: 16px;">人気急上昇イベント</strong>
        </div>
        <div class="card-body">
            @foreach($events as $list)
            <ul class="d-flex list-unstyled border-bottom pb-4 pt-1">
                <li style="width: 15%;" class="font-weight-bold">{{ Str::substr($list->date, 5, 2) }}/{{ Str::substr($list->date, 8, 2) }} </li>
                <li style="width: 70%;" class="font-weight-bold ml-2 mr-4 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{ $list->title }}</a></li>
                <li style="width: 15%;" class="ml-2 font-weight-bold"><i class="fas fa-level-up-alt text-warning mr-2"></i>{{ $list->accepted }}人</a></li>
            </ul>
            @endforeach
        </div>
    </div>
</div>
<div class="offset-md-1 col-md-4 p-0">
        <div class="mb-4 border-title pb-2 pr-5 font-weight-bold" style="font-size: 16px; border-bottom: 3px solid #333; margin-bottom: 20px;">
            人気ランキング
        </div>
        @foreach($lists as $i => $list)
        <ul class="d-flex list-unstyled border-bottom pb-3">
            <li style="width: 5%;">{{ $i+1 }}</li>
            <li style="width: 95%;" class="font-weight-bold ml-2 mr-4 text-dark"><a href="{{ $list->url }}" target="_blank" class="text-dark">{{  Str::substr($list->title, 0, 30) }}</a></li>
        </ul>
        @endforeach
    </div>
    </div>
@endsection