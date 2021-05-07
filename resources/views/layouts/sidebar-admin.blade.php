<div class="col-12 col-lg-3 sidebar-admin">
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
        <a href="{{ route('admin.sliders') }}">
            <li>Slider Images</li>
        </a>
        <a href="{{ route('admin.paymentMethods') }}">
            <li>Payment Methods</li>
        </a>
        <a href="{{ route('admin.faq') }}">
            <li>FAQ</li>
        </a>
        <a href="{{ route('admin.tags') }}">
            <li>Tags</li>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            this.closest('form').submit();">
                <li>Logout</li>
            </a>
        </form>
    </ul>
</div>
