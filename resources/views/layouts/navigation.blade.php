<nav class="navbar-mobile align-items-center row no-print">
    <div class="col-lg-6 d-none d-lg-block justify-content-start">
        @auth
        <div class="dropdown">
            <a class="d-flex align-items-center me-3"  id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user me-2 primary-color" aria-hidden="true"></i>
                <span class="evogria dropdown-toggle">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('user.account') }}">Account</a></li>
                <li><a class="dropdown-item" href="{{ route('user.orders') }}">Orders</a></li>
                <li>
                    <form method="POST" class="dropdown-item" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>
        @else
        <a href="{{ route('login') }}" class="evogria button primary inline"><i class="fa fa-user me-2" style="font-size: 13px" aria-hidden="true"></i> Login</a>
        @endauth
    </div>
    <div class="hamburger col-3 d-lg-none d-flex justify-content-start">
        <img src="/images/svg/hamburger.svg" alt="menu">
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
</nav>
<nav class="navbar align-items-center row d-none d-lg-flex">
    <div class="col-4 nav-links">
        <a href="{{ route('index') }}">Products</a>
        <a href="{{ route('articles') }}" class="article-link">Articles</a>
    </div>
    <div class="col-4 logo-lg text-center">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="col-4 nav-links">
        <a href="{{ route('contact-us') }}">Contact Us</a>
        <a href="{{ route('faq') }}">FAQ</a>
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
            <a href="{{ route('index') }}">Products</a>
        </li>
        <li class="article-link">
            <a href="{{ route('articles') }}">Articles</a>
        </li>
        <li>
            <a href="{{ route('contact-us') }}">Contact Us</a>
        </li>
        <li>
            <a href="{{ route('faq') }}">FAQ</a>
        </li>
        @auth
        <li>
            <a href="{{ route('user.account') }}">My Account</a>
        </li>
        @else
        <a href="{{ route('login') }}" class="button primary" style="font-size: 20px">Login</a>
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
    })
</script>
