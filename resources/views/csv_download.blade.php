@extends('layouts.app')

@section('content')
<section class="c-body">
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header"><strong>CSVダウンロード</strong></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">項目</th>
                                        <th scope="col">ダウンロード</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>人気イベント一覧</td>
                                        <td class=""> <a class="btn btn-success btn-block col-md-5" href="{{ route('csv.popular') }}"> <i class="fas fa-download mr-2"></i>ダウンロード</a></td>
                                    </tr>
                                    <tr>
                                        <td>PHPイベント一覧</td>
                                        <td> <a class="btn btn-success btn-block col-md-5" href="{{ route('csv.php') }}"> <i class="fas fa-download mr-2"></i>ダウンロード</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>
@endsection