<nav class="navbar-mobile align-items-center row">
    <div class="hamburger col-2 d-lg-none d-flex justify-content-start">
        <img src="/images/svg/hamburger.svg" alt="menu">
    </div>
    <div class="logo col-8 d-flex justify-content-center d-lg-none">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="cart-icon col-2 col-lg-12 d-flex justify-content-end">
        <a href="/cart">
            <img src="/images/svg/cart.svg" alt="cart">
        </a>
    </div>
</nav>
<nav class="navbar align-items-center row d-none d-lg-flex">
    <div class="col-4 nav-links">
        <a href="{{ route('index') }}">Products</a>
        <a href="{{ route('articles') }}">Articles</a>
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
        <li>
            <a href="{{ route('articles') }}">Articles</a>
        </li>
        <li>
            <a href="{{ route('contact-us') }}">Contact Us</a>
        </li>
        <li>
            <a href="{{ route('faq') }}">FAQ</a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        $('.hamburger').click(function(){
            $('.sidebar').toggleClass('active');
        })

        $('.close-sidebar').click(function () {
            $('.sidebar').removeClass('active');
        })
    })
</script>
