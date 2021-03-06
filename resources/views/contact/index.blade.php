@extends('layouts.app')

@section('content')
<section class="row container mx-auto mt-4 contact-container">
    <div class="card col-md-7 p-0 mt-2 mx-auto contact-card mb-5">
        <h2 class="card-header title bg-light">お問い合わせ</h2>
        <div class="card-body">
            <p>リクエスト、バグなどありましたら、お問い合わせください。</p>
            <form method="POST" action="{{ route('contact.confirm') }}">
                @csrf
                <div class="form-group">
                    <label>お名前</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control">
                    @if ($errors->has('name'))
                    <p class="error-message text-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label>メールアドレス</label>
                    <input name="email" value="{{ old('email') }}" type="text" class="form-control">
                    @if ($errors->has('email'))
                    <p class="error-message text-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label>タイトル</label>
                    <input name="title" value="{{ old('title') }}" type="text" class="form-control">
                    @if ($errors->has('title'))
                    <p class="error-message text-danger">{{ $errors->first('title') }}</p>
                    @endif
                </div>

                <div>
                    <label>お問い合わせ内容</label>
                    <textarea name="body" class="form-control">{{ old('body') }}</textarea>
                    @if ($errors->has('body'))
                    <p class="error-message text-danger">{{ $errors->first('body') }}</p>
                    @endif
                </div>

                <button type="submit" class="btn mt-4 mb-4 pl-5 pr-5 site-btn text-white">
                    入力内容確認
                </button>
            </form>
        </div>
    </div>
</section>
@endsection