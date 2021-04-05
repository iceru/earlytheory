<nav class="navbar py-3 align-items-center row">
    <div class="hamburger col-2">
        <img src="/images/svg/hamburger.svg" alt="menu">
    </div>
    <div class="logo col-6 d-flex justify-content-center">
        <a href="/">
            <img src="/images/MainLogo.png" alt="Early Theory">
        </a>
    </div>
    <div class="cart col-2 d-flex justify-content-end">
        <img src="/images/svg/cart.svg" alt="cart">
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

