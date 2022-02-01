@extends('layouts.app')

@section('content')
<section class="row container mt-4 justify-content-between ml-4 mx-auto">
    <div class="mt-2 mb-5 col-md-4 p-0">
        <h2 class="title title-border pb-2">イベントを絞り込む</h2>
        <div class="search-card">
            <form action="{{ route('like.search') }}" method="get">
                @csrf
                <div>
                    <div class="form-group">
                        <label for="">キーワード</label>
                        <input type="text" class="form-control text-black" name="like_keyword" value="{{ old('like_keyword', request('like_keyword')) }}" placeholder="キーワードを入力">
                    </div>
                    <div class="form-group">
                        <label for="">開催日</label>
                        <div class="form-group">
                            <input class="form-control" type="text" id="datepicker" name="like_start_date" value="{{ old('like_start_date', request('like_start_date')) }}" placeholder="From" class="pb-3">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="datepicker-2" name="like_end_date" value="{{ old('like_end_date', request('like_end_date')) }}" placeholder="To" class="pb-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>表示順</label>
                        <select class="form-control" name="like_sort">
                            <option value="like_asc" class="bg-white" @if(request('like_sort')==='like_asc' ) selected @endif>
                                お気に入り登録昇順
                            </option>
                            <option value="like_desc" class="bg-white" @if(request('like_sort')==='like_desc' ) selected @endif>
                                お気に入り登録降順
                            </option>
                            <option value="date_asc" class="bg-white" @if(request('like_sort')==='date_asc' ) selected @endif>
                                開催日昇順
                            </option>
                            <option value="date_desc" class="bg-white" @if(request('like_sort')==='date_desc' ) selected @endif>
                                開催日降順
                            </option>
                            <option value="popular" class="bg-white" @if(request('like_sort')==='popular' ) selected @endif>
                                人気イベント順
                            </option>
                        </select>
                    </div>
                    <div class="text-center mx-auto mt-4">
                        <button type="submit" class="btn site-btn text-white btn-block">絞り込む</button>
                        <button type="submit" class="btn btn-block mt-3 btn-default" name="reset">リセット</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-2 col-md-7 p-0 mb-4">
        <h2 class="title title-border pb-2">お気に入り一覧</h2>
        @include('layouts.alert')
        <div class="mt-1">
            @if (!$lists->isEmpty())
            <form action="{{ route('like.csv') }}" method="get">
                <input type="hidden" name="like_keyword" value="{{ old('like_keyword', request('like_keyword')) }}">
                <input type="hidden" name="like_start_date" value="{{ old('like_start_date', request('like_start_date')) }}">
                <input type="hidden" name="like_end_date" value="{{ old('like_end_date', request('like_end_date')) }}">
                <input type="hidden" name="like_sort" value="{{ old('like_sort', request('like_sort')) }}">
                <button type="submit" id="download-button" class="btn btn-default pr-3 pl-3 mb-3" href="">CSVダウンロード</button>
            </form>
            @foreach($lists as $i => $list)

            <!-- modal -->
            <div id="modal-delete-{{ $list->id }}" class="modal" tabindex="-1" role="dialog">
                <div id="modal-dialog" class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ $list->title }}をお気に入りから削除します。よろしいですか？
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                            <delete-like 
                             endpoint="{{ route('events.like', ['event' => $list->id]) }}"
                             index = "{{ $i }}"
                             data-toggle="modal" 
                             data-target="#modal-delete-{{ $list->id }}"
                            >
                            </delete-like>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->

            <ul id="event-card-{{ $i }}" class="list-unstyled event-card">
                <li class="pt-4 pl-4 pr-4">
                    <a href="{{ $list->url }}" target="_blank" class="card-title">
                        {{ $list->title }}
                    </a>
                </li>
                <li class="list-unstyled catch pl-4 pr-4">
                    {{ $list->catch }}
                </li>
                <li class="list-unstyled mt-2 pl-4 pr-2">
                    <ul class="list-unstyled d-flex">
                        <li class="list-unstyled mr-3 pt-2 card-item">
                            <i class="fa fa-fw fa-calendar-alt mr-2 text-dark"></i>
                            {{ (int)Str::substr($list->date, 5, 2) }}月{{ Str::substr($list->date, 8, 2) }}日
                            {{ Str::substr($list->begin_time, 0, 5) }}〜{{ Str::substr($list->end_time, 0, 5) }}
                        </li>
                        <li class="card-item pt-2">
                            <i class="fas fa-user mr-2 text-dark"></i>
                            {{ $list->accepted }}@if($list->limit) / {{ $list->limit }}@endif人
                        </li>
                    </ul>
                </li>
                <li class="list-unstyled pt-1 card-item pl-4 pr-4">
                    <i class="fa fa-fw fa-map-marker-alt text-dark mr-2"></i>
                    {{ $list->address }}
                </li>
                <li class="pt-1 list-unstyled card-item border-bottom pl-4 pr-4 pb-3">
                    <i class="fa fa-fw fa-users mr-2 text-dark"></i>
                    {{ $list->group }}
                </li>
                <li class="list-unstyled mt-2 pb-2">
                    <ul class="list-unstyled d-flex justify-content-between">
                        <li class="pl-4 pr-4">
                            <a class="m-0 p-0 btn shadow-none trash" data-toggle="modal" data-target="#modal-delete-{{ $list->id }}">
                                <i class="fas fa-trash-alt mr-2"></i>削除する
                            </a>
                        </li>
                        <li class="pl-4 pr-4">
                            <img class="connpass-logo" src="/images/connpass_logo.png" alt="">
                        </li>
                    </ul>
                </li>
            </ul>
            @endforeach

            <div class="text-center mt-4"> {{ $lists->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
            @else
            <p>お気に入りイベントは0件です。</p>
            @endif
        </div>
    </div>
</section>
@endsection