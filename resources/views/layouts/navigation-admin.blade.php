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
                <li class="{{ (request()->is('admin')) ? 'active' : '' }}"> <i class="fas fa-home fa-fw"></i> &nbsp; Dashboard</li>
            </a>
            <a href="{{ route('admin.products') }}">
                <li class="{{ (request()->is('admin/products')) ? 'active' : '' }}"> <i class="fas fa-box fa-fw"></i> &nbsp; Products</li>
            </a>
            <a href="{{ route('admin.articles') }}">
                <li class="{{ (request()->is('admin/articles')) ? 'active' : '' }}"><i class="fas fa-newspaper fa-fw"></i> &nbsp; Articles</li>
            </a>
            <a href="{{ route('admin.sales') }}">
                <li class="{{ (request()->is('admin/sales')) ? 'active' : '' }}"><i class="fas fa-money-bill-wave fa-fw"></i> &nbsp; Sales</li>
            </a>
            <a href="{{ route('admin.confirm-payment') }}">
                <li class="{{ (request()->is('admin/confirm-payment')) ? 'active' : '' }}"><i class="fas fa-receipt fa-fw"></i> &nbsp; Payment Confirmation</li>
            </a>
            <a href="{{ route('admin.sliders') }}">
                <li class="{{ (request()->is('admin/sliders')) ? 'active' : '' }}"><i class="fas fa-images fa-fw"></i> &nbsp; Slider Images</li>
            </a>
            <a href="{{ route('admin.paymentMethods') }}">
                <li class="{{ (request()->is('admin/paymentMethods')) ? 'active' : '' }}"><i class="fas fa-credit-card fa-fw"></i> &nbsp; Payment Methods</li>
            </a>
            <a href="{{ route('admin.discount') }}">
                <li class="{{ (request()->is('admin/discount')) ? 'active' : '' }}"><i class="fas fa-percent fa-fw"></i> &nbsp; Discount</li>
            </a>
            <a href="{{ route('admin.faq') }}">
                <li class="{{ (request()->is('admin/faq')) ? 'active' : '' }}"><i class="fas fa-question-circle fa-fw"></i> &nbsp; FAQ</li>
            </a>
            <a href="{{ route('admin.tags') }}">
                <li class="{{ (request()->is('admin/tags')) ? 'active' : '' }}"><i class="fas fa-tags fa-fw"></i> &nbsp; Tags</li>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();">
                    <li><i class="fas fa-sign-out-alt fa-fw"></i> &nbsp; Logout</li>
                </a>
            </form>
        </ul>
    </div>
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
