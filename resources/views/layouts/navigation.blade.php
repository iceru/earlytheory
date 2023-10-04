<nav class="navbar-mobile no-print d-flex d-lg-none">
    {{-- <div class="col-lg-6 d-none d-lg-block justify-content-start ">
            @auth
                <div class="dropdown">
                    <a class="d-flex align-items-center me-3" id="userDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-user me-2 primary-color" aria-hidden="true"></i>
                        <span class="dropdown-toggle grey-color fw-bold"><span
                                class="name-section">{{ auth()->user()->name }} @if (count($sales) > 0)
                            </span><span class="orders-alert"></span>
                            @endif </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.account') }}">Account</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.orders') }}">Orders @if (count($sales) > 0)
                                    <span class="orders-alert"></span>
                                @endif
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('user.horoscopes') }}">Birth Chart</a></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault();
                            this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="evogria primary-color d-flex"><i class="fa fa-user me-2"
                        style="line-height: 1.4" aria-hidden="true"></i> <span class="grey-color">Login</span></a>
            @endauth
        </div> --}}
    <div class="logo d-flex justify-content-center">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="hamburger ">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        @if (count($sales) > 0)
            <span class="orders-alert"></span>
        @endif
    </div>

</nav>
<div class="container">
    <nav class="navbar align-items-center row d-none d-lg-flex pt-4">
        <div class="col-4 nav-links">
            <a class="{{ request()->is('/tarot') ? 'active' : '' }}" href="{{ route('tarot') }}">Ramalan</a>
            <a class="{{ request()->is('/workshop') ? 'active' : '' }}" href="{{ route('workshops') }}">Workshop</a>
            <a href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" target="_blank">Toko Mejik</a>
        </div>
        <div class="col-4 logo-lg text-center">
            <a href="/">
                <img src="/images/MainLogo.png" alt="Early Theory">
            </a>
        </div>
        <div class="col-4 nav-links">
            <a class="{{ request()->is('articles-page') ? 'active' : '' }}" href="{{ route('articles.index') }}"
                class="article-link">Articles</a>
            <a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">Contact Us</a>
            <a class="{{ request()->is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
        </div>
    </nav>
</div>
<div class="account-nav">
    <div class="container">
        <div class="user-name">
            <i class="fa fa-user me-1"></i>
            @auth
                <a href="{{ route('user.account') }}"> Hello, {{ Auth::user()->name }}</a>
            @else
                <a href="{{ route('login') }}"> Login</a>
            @endauth
        </div>
        <div class="cart">
            <div class="cart-icon d-flex justify-content-end">
                <a href="/cart" class="cart-icon-a">
                    <img src="/images/svg/cart.svg" alt="cart">
                </a>
            </div>
            <div class="badge-count" id="cartcount">{{ \Cart::getContent()->count() }}</div>
        </div>
    </div>
</div>
<div class="sidebar">
    <ul class="nav-links">
        <li>
            <a class="{{ request()->is('/tarot') ? 'active' : '' }}" href="{{ route('tarot') }}">Order Ramalan</a>
        </li>
        <li>
            <a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ route('workshops') }}">Kelas &
                Workshop</a>
        </li>
        <li>
            <a class="{{ request()->is('contact-us') ? 'active' : '' }}"
                href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" target="_blank">Toko
                Mejik</a>
        </li>
        <li>
            <a class="{{ request()->is('articles') ? 'active' : '' }}" href="{{ route('articles') }}">Artikel</a>
        </li>
        <li>
            <a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">Kontak</a>
        </li>
        <li>
            <a class="{{ request()->is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
        </li>
    </ul>
    <div class="sidebar-img">
        <img src="/images/FavIcon.png" alt="Early Theory">
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.hamburger').click(function() {
            $('.sidebar').toggleClass('active');
            $(this).toggleClass('active');
            $('body').toggleClass('no-scroll', '');
        })

        // $(document).scroll(function() {
        //     var scroll = $(this).scrollTop();
        //     var topDist = $(".navbar-mobile").position();
        //     if (scroll > topDist.top) {
        //         $('.navbar-mobile').addClass('sticky');
        //         $('.navbar').addClass('sticky');
        //         $('.name-section').hide();
        //         $('.navbar-mobile .row').addClass('container sticky-container');
        //     } else {
        //         $('.navbar-mobile').removeClass('sticky');
        //         $('.navbar').removeClass('sticky');
        //         $('.name-section').show();
        //         $('.navbar-mobile .row').removeClass('container sticky-container');
        //     }
        // });
    })
</script>
