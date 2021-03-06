<nav class="navbar navbar-expand-sm header-nav shadow-sm">
    <div class="container">
        <h1 class="logo">
            <a href="{{ route('home') }}" class="text-decoration-none">
                Connpass Summary
            </a>
        </h1>

        <button type="button" class="navbar-toggler mr-3" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="nav-bar">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link mr-3">ホーム</a></li>
                <li class="nav-item"><a href="{{ route('popular.index') }}" class="nav-link mr-3">人気イベント</a></li>
                <li class="nav-item"><a href="{{ route('php.index') }}" class="nav-link mr-3">PHPイベント</a></li>
                <li class="nav-item"><a href="{{ route('like.index') }}" class="nav-link">お気に入り</a></li>
            </ul>
        </div>
    </div>