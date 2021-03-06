@extends('layouts.app')

@section('content')
<div class="top-block shadow-sm">
    <div class="container row mx-auto">
        <div class="col-md-12 p-0 mt-3 mb-3">
            <div class="mt-2 bg-white mb-2 home-block">
                <div class="row pt-2 pl-3 pr-3">
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image1.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left top-text">
                            コンセプトは「自分が好きそうなイベントを逃さないためのAPI駆動ツール」です。
                        </p>
                    </div>
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image2.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left top-text">
                            IT勉強会支援プラットフォームConnpassの情報をConnpassAPIで取得し、自動更新しています。
                        </p>
                    </div>
                    <div class="col-md-4 pt-2 mb-3">
                        <div><img src="images/image3.png" alt="" class="image-block"></div>
                        <p class="pt-2 m-0 text-left top-text">
                            人気急上昇イベントや参加人数50名以上の人気イベント、PHPイベントの情報をピックアップしています。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="" style="background: #fff;">
    <div class="row container pb-4 mx-auto">
        <div class="col-md-7 p-0 mt-4">
            <h2 class="title pb-2 title-border pt-2 mb-1">
                人気急上昇イベント(直近24時間)
            </h2>
            <div class="mt-3">
                @if (!$alerts->isEmpty())
                @foreach($alerts as $alert)
                <ul class="list-unstyled event-card">
                    <li class="pt-4 pl-4 pr-4"><a href="{{ $alert->event->url }}" target="_blank" class="card-title">{{ $alert->event->title }}</a></li>
                    <li class="list-unstyled catch pl-4 pr-4">{{ $alert->event->catch }}</li>
                    <li class="list-unstyled mt-2 pl-4 pr-2">
                        <ul class="list-unstyled d-flex">
                            <li class="list-unstyled mr-3 pt-2 card-item">
                                <i class="fa fa-fw fa-calendar-alt mr-2 text-dark"></i>
                                {{ Str::substr($alert->event->date, 5, 2) }}月{{ Str::substr($alert->event->date, 8, 2) }}日 
                                {{ Str::substr($alert->event->begin_time, 0, 5) }}〜{{ Str::substr($alert->event->end_time, 0, 5) }}
                            </li>
                            <li class="card-item pt-2">
                                <i class="fa fa-w fa-user mr-1 text-dark"></i>
                                ＋{{ $alert->diff }}人
                            </li>
                        </ul>
                    </li>
                    <li class="list-unstyled pt-1 card-item pl-4 pr-4">
                        <i class="fa fa-fw fa-map-marker-alt text-dark mr-2"></i>
                        {{ $alert->event->address }}
                    </li>
                    <li class="pt-1 list-unstyled card-item border-bottom pl-4 pr-4 pb-3">
                        <i class="fa fa-fw fa-users mr-2 text-dark"></i>
                        {{ $alert->event->group }}
                    </li>
                    <li class="list-unstyled mt-2 pb-2">
                        <ul class="list-unstyled d-flex justify-content-between">
                            <li class="pl-4 pr-4">
                                <event-like :initial-is-liked-by='@json(\App\Models\Like::isLikedBy($alert->event->id))' endpoint="{{ route('events.like', ['event' => $alert->event->id]) }}">
                                </event-like>
                            </li>
                            <li class="pl-4 pr-4">
                                <img class="connpass-logo" src="images/connpass_logo.png" alt="">
                            </li>
                        </ul>
                    </li>
                </ul>
                @endforeach
                <div class="text-center mt-4"> {{ $alerts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                @else
                <p>該当イベントはありません。</p>
                @endif
            </div>
        </div>
        <aside class="offset-md-1 p-0 col-md-4 justify-content-center mt-4 mb-4">
            <h2 class="title pb-2 title-border pt-2 mb-3">ランキング</h2>
            <div class="bg-white">
                <h3 class="rank-title pb-2">人気イベントランキング</h3>
                @foreach($popular_events as $i => $popular_event)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
                    <li class="ml-2 event-title">
                        <a href="{{ $popular_event->url }}" target="_blank" class="ranking-text">
                            {{ $popular_event->title }}
                        </a>
                    </li>
                </ul>
                @endforeach
                <div class="text-right mb-4">
                    <a href="{{ route('popular.index') }}" class="ranking-text">
                        <i class="fa fa-caret-right mr-1"></i>
                        人気イベント一覧をみる
                    </a>
                </div>
                <h3 class="rank-title pb-2">PHP人気イベントランキング</h3>
                @foreach($php_events as $i => $php_event)
                <ul class="d-flex list-unstyled border-bottom pb-3">
                    <li class="number-{{ $i+1 }} mr-1">{{ $i+1 }}</li>
                    <li class="ml-2 event-title">
                        <a href="{{ $php_event->url }}" target="_blank" class="ranking-text">
                            {{ $php_event->title }}
                        </a>
                    </li>
                </ul>
                @endforeach
                <div class="text-right">
                    <a href="{{ route('php.index') }}" class="ranking-text">
                        <i class="fa fa-caret-right mr-1"></i>
                        PHPイベント一覧をみる
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection