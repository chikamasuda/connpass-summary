@extends('layouts.app')

@section('content')
<section class="c-body">
    <main class="c-main">
        <div class="container">
            <div class="fade-in">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('php.search') }}" method="get">
                            <div class="row mb-0">
                                <div class="form-group col-sm-4">
                                    <label for="">キーワード</label>
                                    <input type="text" class="form-control text-black" name="keyword" value="{{ old('keyword', request('keyword')) }}">
                                </div>
                                <div class="form-group col-sm-4 mr-4 mb-0">
                                    <label for="">日時</label>
                                    <div class="d-flex form-group">
                                        <input type="date" class="form-control mr-2 text-black" name="start_date" value="{{ old('start_date', request('start_date')) }}">
                                        <span class="mt-1">ー</span>
                                        <input type="date" class="form-control ml-2 mr-2 pb-2 text-black" name="end_date" value="{{ old('end_date', request('end_date')) }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="">開催場所</label>
                                    <input type="text" class="form-control text-black" name="address" value="{{ old('address', request('address')) }}">
                                </div>
                            </div>
                            <div class="text-center mx-auto mt-1 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary pl-5 pr-5 mr-3">検索</button>
                                <button type="submit" class="btn btn-dark pl-5 pr-5" name="reset">リセット</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><strong>PHPイベント一覧</strong></div>
                    <div class="card-body mt-1" style="width: 1100px; overflow: scroll;">
                        <a class="btn btn-primary mb-1" href="{{ route('csv.php') }}"> <i class="fas fa-download mr-2"></i>CSVダウンロード</a></td>
                        <div class="text-center pb-3"> {{ $lists->links('pagination::bootstrap-4') }}</div>
                        @foreach($lists as $list)
                        <ul class="d-flex list-unstyled border-bottom pb-3 ">
                            <li style="width: 5%;" class="font-weight-bold">{{ Str::substr($list->date, 5, 2) }}/{{ Str::substr($list->date, 8, 2) }} </li>
                            <li style="width: 12%;">{{ $list->begin_time }}〜{{ $list->end_time }}</li>
                            <li style="width: 28%;" class="font-weight-bold  ml-1"><a href="{{ $list->url }}" target="_blank" class="text-body">{{ $list->title }}</a></li>
                            <ul style="width: 25%;" class="ml-4 ist-unstyled ml-1">
                                <li class="list-unstyled"><i class="fas fa-user-friends mr-1 text-info"></i>{{ $list->group }}</li>
                                <li class="mt-1 list-unstyled"><i class="fas fa-user-alt mr-2 mt-1 text-success"></i>{{ $list->owner }}</li>
                            </ul>
                            <li style="width: 20%;" class="mr-2 ml-2"><i class="fas fa-map-marker-alt text-danger mr-2"></i>{{$list->address }}</li>
                            <li style="width: 10%;" class="ml-3 font-weight-bold"><i class="fas fa-users text-warning mr-1"></i>
                                {{ $list->accepted }}@if($list->limit) / {{ $list->limit }}@endif人
                            </li>
                        </ul>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>
@endsection