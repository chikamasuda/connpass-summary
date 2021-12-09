@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-4">
            <div class="card mt-2">
                <div class="card-header title">お問い合わせ内容確認</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <input type="hidden" name="name" value="{{ $contact['name'] }}">
                        <input type="hidden" name="email" value="{{ $contact['email'] }}">
                        <input type="hidden" name="title" value="{{ $contact['title'] }}">
                        <input type="hidden" name="body" value="{{ $contact['body'] }}">
                        <div class="row">
                            <label for="email" class="col-md-3 text-md-right">お名前:</label>
                            <div class="col-md-9">
                                {{ $contact['name'] }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-md-3 text-md-right">メールアドレス:</label>
                            <div class="col-md-9">
                                {{ $contact['email'] }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-md-3 text-md-right">タイトル:</label>
                                <div class="col-md-9">
                                    {{ $contact['title'] }}
                                </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-md-3 text-md-right">お問い合わせ内容:</label>
                                <div class="col-md-9">
                                    {{ $contact['body'] }}
                                </div>
                        </div>

                        <div class="form-group row justify-content-center mt-3">
                            <div class="col-md-5">
                                <a href="{{ route('contact.index') }}" class="btn btn-info btn-block">戻る</a> 
                            </div>

                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary btn-block">
                                    送信
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
