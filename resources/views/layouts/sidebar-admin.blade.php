<div class="col-12 col-lg-3 sidebar-admin">
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
            <li class="{{ (request()->is('admin/sliders')) ? 'active' : '' }}"><i class="fas fa-images fa-fw"></i> &nbsp; Sliders Image</li>
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
