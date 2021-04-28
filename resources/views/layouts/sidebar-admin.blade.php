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
