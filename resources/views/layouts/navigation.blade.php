<nav class="navbar-mobile no-print">
    <div class="row align-items-center">
        <div class="col-lg-6 d-none d-lg-block justify-content-start ">
            @auth
            <div class="dropdown">
                <a class="d-flex align-items-center me-3"  id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user me-2 primary-color" aria-hidden="true"></i>
                    <span class="dropdown-toggle grey-color fw-bold"><span class="name-section">{{ auth()->user()->name }} @if (count($sales) > 0) </span><span class="orders-alert"></span> @endif </span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('user.account') }}">Account</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.orders') }}">Orders @if (count($sales) > 0) <span class="orders-alert"></span> @endif</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.horoscopes') }}">Birth Chart</a></li>
                
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
            @else
            <a href="{{ route('login') }}" class="evogria primary-color d-flex"><i class="fa fa-user me-2" style="line-height: 1.4" aria-hidden="true"></i> <span class="grey-color">Login</span></a>
            @endauth
        </div>
        <div class="hamburger col-3 d-lg-none d-flex justify-content-start">
            <img src="/images/svg/hamburger.svg" alt="menu"> @if (count($sales) > 0) <span class="orders-alert"></span> @endif 
        </div>
        <div class="logo col-6 d-flex justify-content-center d-lg-none">
            <a href="/">
                <img src="/images/MainLogo.png" alt="Early Theory">
            </a>
        </div>
        <div class="cart-icon col-3 col-lg-6 d-flex justify-content-end">
            <a href="/cart" class="cart-icon-a">
                <img src="/images/svg/cart.svg" alt="cart">
            </a>
            <div class="badge-count" id="cartcount">{{ \Cart::getContent()->count() }}</div>
        </div>
    </div>
</nav>
<nav class="navbar align-items-center row d-none d-lg-flex">
    <div class="col-4 nav-links">
        <a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('index') }}">Products</a>
        <a class="{{ (request()->is('articles-page')) ? 'active' : '' }}" href="{{ route('articles.index') }}" class="article-link">Articles</a>
    </div>
    <div class="col-4 logo-lg text-center">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="col-4 nav-links">
        <a class="{{ (request()->is('contact-us')) ? 'active' : '' }}" href="{{ route('contact-us') }}">Contact Us</a>
        <a class="{{ (request()->is('faq')) ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
    </div>
</nav>

<div class="sidebar">
    <div class="close-sidebar">
        <i class="fas fa-times"></i>
    </div>
    <div class="logo-sidebar">
        <img src="/images/Favicon.png" alt="">
    </div>
    <ul class="nav-links">
        <li>
            <a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('index') }}">Products</a>
        </li>
        <li class="article-link">
            <a class="{{ (request()->is('articles-page')) ? 'active' : '' }}" href="{{ route('articles.index') }}">Articles</a>
        </li>
        <li>
            <a class="{{ (request()->is('contact-us')) ? 'active' : '' }}" href="{{ route('contact-us') }}">Contact Us</a>
        </li>
        <li>
            <a class="{{ (request()->is('faq')) ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
        </li>
        @auth
        <li class="login-link">
            <a class="{{ (request()->is('account')) ? 'active' : '' }}" href="{{ route('user.account') }}">My Account</a>
        </li>
        <li>
            <a class="{{ (request()->is('orders')) ? 'active' : '' }}" href="{{ route('user.orders') }}">My Orders  @if (count($sales) > 0) <span class="orders-alert"></span> @endif </a>
        </li>
        <li>
            <a class="{{ (request()->is('account/horoscopes')) ? 'active' : '' }}" href="{{ route('user.horoscopes') }}">My Birth Chart</a>
        </li>
        @else
        <li class="login-link">
            <a href="{{ route('login') }}">Login</a>
        </li>
        @endauth

    </ul>
</div>

<script>
    $(document).ready(function() {
        $('.hamburger').click(function(){
            $('.sidebar').toggleClass('active');
            $('body').css('overflow-y', 'hidden');
        })

        $('.close-sidebar').click(function () {
            $('.sidebar').removeClass('active');
            $('body').css('overflow-y', 'auto');
        })

        $(document).scroll(function () {
            var scroll = $(this).scrollTop();
            var topDist = $(".navbar-mobile").position();
            if (scroll > topDist.top) {
                $('.navbar-mobile').addClass('sticky');
                $('.navbar').addClass('sticky');
                $('.name-section').hide();
                $('.navbar-mobile .row').addClass('container sticky-container');
            } else {
                $('.navbar-mobile').removeClass('sticky');
                $('.navbar').removeClass('sticky');
                $('.name-section').show();
                $('.navbar-mobile .row').removeClass('container sticky-container');
            }
        });
    })
</script>
