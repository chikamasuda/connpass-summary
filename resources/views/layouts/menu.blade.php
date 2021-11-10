<li class="c-sidebar-nav-item mt-3">
    <a class="c-sidebar-nav-link c-active" href="{{ route('home') }}">
        <i class="c-sidebar-nav-icon cil-list-rich"></i>イベント情報(connpass)
    </a>
    <!-- <a class="c-sidebar-nav-link c-active" href="">
        <i class="c-sidebar-nav-icon cil-list-rich"></i>ストアカイベント一覧
    </a> -->
    <!-- <a class="c-sidebar-nav-link c-active" href="">
        <i class="c-sidebar-nav-icon cil-cloud-download"></i>イベント情報(ストアカ)
    </a> -->
    <a class="c-sidebar-nav-link c-active" href="">
        <i class="c-sidebar-nav-icon cil-cog"></i>ユーザー設定
    </a>
    <a class="c-sidebar-nav-link c-active" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="c-sidebar-nav-icon cil-account-logout"></i>ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>
