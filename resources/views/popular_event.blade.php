@extends('layouts.app')

@section('content')
<section class="row container mt-4 justify-content-between ml-4 mx-auto">
    <div class="mt-2 mb-5 col-md-4 p-0 search-card">
        <div class="pt-4 pr-4 pl-4 pb-4">
            <form action="{{ route('popular.search') }}" method="get">
                @csrf
                <div class="mb-0">
                    <div class="form-group">
                        <label for="">キーワード検索</label>
                        <input type="text" class="form-control text-black" name="keyword" value="{{ old('keyword', request('keyword')) }}">
                    </div>
                    <div class="form-group">
                        <label for="">日時検索</label>
                        <div class="d-flex form-group">
                            <input type="date" class="text-dark form-control" name="date" value="{{ old('date', request('date')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">開催場所検索</label>
                        <input type="text" class="form-control text-black" name="address" value="{{ old('address', request('address')) }}">
                    </div>
                </div>
                <div class="text-center mx-auto mt-2 d-flex justify-content-center">
                    <button type="submit" class="btn btn-default pr-5 pl-5">検索</button>
                    <!-- <button type="submit" class="btn btn-outline-dark  pr-3 pl-3" name="reset">リセット</button> -->
                </div>
            </form>
        </div>
    </div>
    <div class="mt-2 col-md-7 p-0 mb-4">
        <h2 class="title title-border pb-2">人気イベント一覧</h2>
        <div class="mt-1">
            @if (!$lists->isEmpty())
            <div class="mx-auto">
                <div class="pb-2"> {{ $lists->links('pagination::bootstrap-4') }}</div>
            </div>
            @foreach($lists as $list)
            <ul class="list-unstyled event-card pb-4 pt-4 pl-4 pr-4">
                <li class=""><a href="{{ $list->url }}" target="_blank" class="card-title">{{ $list->title }}</a></li>
                <li class="list-unstyled catch text-dark">{{ $list->catch }}</li>
                <li class="list-unstyled mr-3 pt-2 text-dark card-item"><i class="far fa-clock mr-1 text-dark"></i>{{ Str::substr($list->date, 0, 4) }}年{{ Str::substr($list->date, 5, 2) }}月{{ Str::substr($list->date, 8, 2) }}日 {{ $list->begin_time }}〜{{ $list->end_time }}</li>
                <li class="list-unstyled pt-1 text-dark card-item"><i class="fas fa-map-marker-alt text-dark mr-2"></i>{{$list->address }}</li>
                <li class="pt-1 list-unstyled text-dark card-item"><i class="fas fa-user-friends mr-1 text-dark"></i>{{ $list->group }}</li>
                <li class="list-unstyled mt-1">
                    <ul class="list-unstyled">
                        <li class="text-right">
                            <span class="number">{{ $list->accepted }}@if($list->limit) / {{ $list->limit }}@endif</span>人
                        </li>
                    </ul>
                </li>
            </ul>
            @endforeach
            <div class="text-center mt-4"> {{ $lists->links('pagination::bootstrap-4') }}</div>
            @else
            <p>検索結果は0件です。</p>
            @endif
        </div>
    </div>
</section>
@endsection