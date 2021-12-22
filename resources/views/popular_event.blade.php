@extends('layouts.app')

@section('content')
<section class="row container mt-4 justify-content-between ml-4 mx-auto">
    <div class="card mt-2 mb-5 col-md-4 p-0" style="height: 380px;">
        <div class="card-header"><strong>絞り込み検索</strong></div>
        <div class="card-body">
            <form action="{{ route('popular.search') }}" method="get">
                @csrf
                <div class="mb-0">
                    <div class="form-group">
                        <label for="">キーワード</label>
                        <input type="text" class="form-control text-black" name="keyword" value="{{ old('keyword', request('keyword')) }}">
                    </div>
                    <div class="form-group">
                        <label for="">日時</label>
                        <div class="d-flex form-group">
                            <input type="date" class="text-dark form-control" name="date" value="{{ old('date', request('date')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">開催場所</label>
                        <input type="text" class="form-control text-black" name="address" value="{{ old('address', request('address')) }}">
                    </div>
                </div>
                <div class="text-center mx-auto mt-1 d-flex justify-content-center">
                    <button type="submit" class="btn submit text-white pr-5 pl-5">検索</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-2 col-md-7 p-0 mb-4">
        <h2 class="title title-border pb-2">人気イベント一覧</h2>
        <div class="mt-1">
            @if (!$lists->isEmpty())
            <div class="text-right pb-2"> {{ $lists->links('pagination::bootstrap-4') }}</div>
            @foreach($lists as $list)
            <ul class="list-unstyled event-card pb-4 pt-4 pl-4 pr-4">
                <li style="font-size: 18px;" class="font-weight-bold"><a href="{{ $list->url }}" target="_blank" class="text-body">{{ $list->title }}</a></li>
                <li class="list-unstyled pt-2">
                    <ul class="d-flex list-unstyled">
                        <li class="list-unstyled mr-3"><i class="far fa-clock text-primary mr-2"></i>{{ Str::substr($list->date, 5, 2) }}/{{ Str::substr($list->date, 8, 2) }} {{ $list->begin_time }}〜{{ $list->end_time }}</li>
                        <li class="list-unstyled"><i class="fas fa-map-marker-alt text-danger mr-2"></i>{{$list->address }}</li>
                    </ul>
                </li>
                <li class="pt-2 list-unstyled"><i class="fas fa-user-friends mr-1 text-dark"></i>{{ $list->group }}</li>
                <li class="pt-2 list-unstyled"><i class="fas fa-user-alt mr-2 mt-1 text-dark"></i>{{ $list->owner }}</li>
                <li class="font-weight-bold text-right"><i class="fas fa-users text-dark mr-1"></i>
                    {{ $list->accepted }}@if($list->limit) / {{ $list->limit }}@endif人
                </li>
            </ul>
            @endforeach
            <div class="text-center mt-2"> {{ $lists->links('pagination::bootstrap-4') }}</div>
            @else
            <p>検索結果は0件です。</p>
            @endif
        </div>
    </div>
</section>
@endsection