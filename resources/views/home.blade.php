@extends('layouts.app')

@section('content')
<div class="c-body">
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
                        <button type="submit" class="btn btn-md pl-4 pr-4 btn-outline-success">検索</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><strong>イベント一覧(connpass)</strong></div>
                    <div class="card-body">
                        <table class="table table-responsive-sm mt-3">
                            <tbody class="">
                                <tr>
                                    <td>2021/11/10(水)</td>
                                    <td>18:00 〜 21:00</td>
                                    <td><img src="{{ asset('images/1acb601f3864df2718c288b1607bb0f8.png') }}" alt=""></td>
                                    <td>【平日夜】メイドさんがいる定時後のIT自習室</td>
                                    <td><i class="fas fa-user-alt mr-1"></i>
                                        メイドカフェでノマド会＼(^o^)／</td>
                                    <td><i class="cil-location-pin mr-1"></i>東京都</td>
                                    <td>4/8人</td>
                                </tr>
                                <tr>
                                    <td>2021/11/10(水)</td>
                                    <td>19:00 〜 21:00</td>
                                    <td><img src="{{ asset('images/2e9c0865a14f446ac314d0de2d1ae8f6.png') }}" alt=""></td>
                                    <td>PHPerのための「PHP カンファレンス 2021を振り返る」PHP TechCafe</td>
                                    <td><i class="fas fa-user-alt mr-1"></i>
                                        ラクス</td>
                                    <td><i class="cil-location-pin mr-1"></i>オンライン</td>
                                    <td>78/100人</td>
                                </tr>
                                <tr>
                                    <td>2021/11/11(木)</td>
                                    <td>18:00 〜 21:00</td>
                                    <td><img src="{{ asset('images/ce5f37e0f6e714babe4013de1ffb5027.png') }}" alt=""></td>
                                    <td>もくもく勉強会in那覇市-codebridge</td>
                                    <td><i class="fas fa-user-alt mr-1"></i>
                                        もくもく勉強会-エイブリッジ</td>
                                    <td><i class="cil-location-pin mr-1"></i>沖縄県</td>
                                    <td>0/5人</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection