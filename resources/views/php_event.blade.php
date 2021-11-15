@extends('layouts.app')

@section('content')
<section class="c-body">
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header"><strong>絞り込み検索</strong></div>
                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="form-group col-sm-3">
                                <label for="">キーワード</label>
                                <input type="text" class="form-control" placeholder="キーワード">
                            </div>
                            <div class="form-group col-sm-4 mr-4">
                                <label for="">日時</label>
                                <div class="d-flex form-group">
                                    <input type="date" class="form-control mr-2">
                                    <span class="mt-1">ー</span>
                                    <input type="date" class="form-control ml-2 mr-2 pb-2">
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">開催場所</label>
                                <input type="text" class="form-control" placeholder="開催場所">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-md pl-5 pr-5 btn-success">検索</button>
                        <button type="submit" class="btn btn-md pl-4 pr-4 btn-dark ml-2">リセット</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><strong>PHPイベント一覧</strong></div>
                    <div class="card-body mt-1">
                    <div class="text-center pb-3"> {{ $lists->links('pagination::bootstrap-4') }}</div>
                      @foreach($lists as $list)
                        <ul class="d-flex list-unstyled border-bottom pb-3 ">
                            <li style="width: 5%;" class="font-weight-bold">{{ Str::substr($list->date, 5, 2) }}/{{ Str::substr($list->date, 8, 2) }} </li>
                            <li style="width: 10%;">{{ $list->begin_time }}〜{{ $list->end_time }}</li>
                            <li style="width: 30%;" class="font-weight-bold"><a href="{{ $list->url }}" target="_blank" class="text-body">{{ $list->title }}</a></li>
                            <ul style="width: 25%;" class="ml-4 ist-unstyled">
                                <li class="list-unstyled"><i class="fas fa-user-friends mr-1 text-info"></i>{{ $list->group }}</li>
                                <li class="mt-1 list-unstyled"><i class="fas fa-user-alt mr-2 mt-1 text-success"></i>{{ $list->owner }}</li>
                            </ul>
                            <li style="width: 15%;" class="mr-2 ml-2"><i class="fas fa-map-marker-alt text-danger mr-2" ></i>{{$list->address }}</li>
                            <li style="width: 15%;" class="ml-3 font-weight-bold"><i class="fas fa-users text-warning mr-1"></i>
                            {{ $list->accepted }}@if($list->limit) / {{ $list->limit }}@endif人</li>
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