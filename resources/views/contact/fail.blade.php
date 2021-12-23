@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-4">
            <div class="card mt-2">
                <div class="card-header bg-light title">送信失敗</div>
                <div class="card-body">
                    <p>送信に失敗しました。</p>
                    <div class="form-group row mt-3">
                        <div class="col-md-5">
                            <a href="{{ route('contact.index') }}" class="btn btn-info btn-block">問い合わせ画面に戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection