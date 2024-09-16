<header class="header-wrapper">
    <div class="header">
        <div class="header__logo">
            <a href="/"><img class="header__logo-img" src="{{ asset('storage/logo/logo.svg') }}" alt="coachtech-logo"></a>
        </div>
        <form class="header-search" action="" method="get">
            <input class="header-search__box" type="text" placeholder="何をお探しですか？">
        </form>
        <div class="header-nav__modal">
            <button class="header-nav__modal-button">
                <span class="material-symbols-outlined header-nav__modal-button-icon" id="menu">menu</span>
                <span class="material-symbols-outlined header-nav__modal-button-icon" id="close" style="display:none">close</span>
            </button>
        </div>
        <nav class="header-nav">
            <ul class="header-nav__list">
                @if(Auth::check())
                <li class="header-nav__item">
                    <a class="header-nav__item--link" href="#" onclick="document.getElementById('logout').submit();">ログアウト</a>
                    <form id="logout" action="/logout" method="post" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__item--link" href="/mypage">マイページ</a>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__item--button" href="/sell">出品</a>
                </li>
                @else
                <li class="header-nav__item">
                    <a class="header-nav__item--link" href="/login">ログイン</a>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__item--link" href="/register">会員登録</a>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__item--button" href="/register">出品</a>
                </li>
                @endif
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script>
        const menu = document.getElementById('menu');
        const close = document.getElementById('close');
        $(function() {
            $(".header-nav__modal-button").click(function() {
                $(".header-nav").slideToggle("");
                if(close.style.display=="none"){
                    menu.style.display='none';
                    close.style.display='block';
                }else{
                    menu.style.display='block';
                    close.style.display='none';
                }
            });
        });
    </script>
</header>