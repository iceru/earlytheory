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
            
        </a>
    </div>
</nav>
<nav class="navbar align-items-center row d-none d-lg-flex">
    
    <div class="col-6 logo-lg">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="col-6 user-menu d-flex justify-content-end">
        {{ Auth::user()->name }}
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
            <a href="#">Contact Us</a>
        </li>
        <li>
            <a href="#">FAQ</a>
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
