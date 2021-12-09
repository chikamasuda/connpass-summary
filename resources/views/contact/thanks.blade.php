@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-4">
            <div class="card mt-2">
                <div class="card-header bg-light title">送信完了</div>
                <div class="card-body">
                    <p>送信完了しました。確認メールを入力したメールアドレスに送信しました。<br>
                        数日以内に管理人からメールを返信いたしますのでお待ちください。</p>
                    <div class="form-group row mt-3">
                        <div class="col-md-5">
                            <a href="{{ route('home') }}" class="btn btn-info btn-block">ホーム画面に戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection