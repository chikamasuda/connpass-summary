<nav class="navbar navbar-expand-sm navbar-light shadow-sm" style="background: #fff;">
    <h1 class="brand-text title ml-3 pt-1"><a href="{{ route('home') }}" class="text-decoration-none">Connpass Summary</a></h1>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end mr-3" id="nav-bar">
        <ul class="navbar-nav">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">HOME</a></li>
            <li class="nav-item"><a href="{{ route('popular') }}" class="nav-link">人気イベント</a></li>
            <li class="nav-item"><a href="{{ route('php') }}" class="nav-link">PHPイベント</a></li>
            <li class="nav-item"><a href="{{ route('contact.index') }}" class="nav-link">お問い合わせ</a></li>
        </ul>
    </div>
</nav>