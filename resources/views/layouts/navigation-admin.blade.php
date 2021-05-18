<nav class="navbar-mobile align-items-center row">
    <div class="hamburger col-2 d-lg-none d-flex justify-content-start">
        <img src="/images/svg/hamburger.svg" alt="menu">
    </div>
    <div class="logo col-8 d-flex justify-content-center d-lg-none">
        <a href="/admin">
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

<div class="sidebar admin">
    <div class="close-sidebar">
        <i class="fas fa-times"></i>
    </div>
    <div class="sidebar-admin-mobile">
        <ul>
            <a href="/admin">
                <li>Dashboard</li>
            </a>
            <a href="{{ route('admin.products') }}">
                <li>Products</li>
            </a>
            <a href="{{ route('admin.articles') }}">
                <li>Articles</li>
            </a>
            <a href="#">
                <li>Sales</li>
            </a>
            <a href="#">
                <li>Payment Confirmation</li>
            </a>
            <a href="{{ route('admin.paymentMethods') }}">
                <li>Payment Methods</li>
            </a>
            <a href="{{ route('admin.tags') }}">
                <li>Tags</li>
            </a>
            <a href="{{ route('logout') }}">
                <li>Logout</li>
            </a>
        </ul>
    </div>
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
