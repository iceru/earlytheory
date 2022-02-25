<div class="col-12 col-md-3">
    <div class="account-navigation">
        <ul class="sidebar-account">
            <li>
                <a class="{{ (request()->is('account')) ? 'active' : '' }}" href="{{ route('user.account') }}">Account</a>
            </li>
            <li>
                <a class="{{ (request()->is('orders')) ? 'active' : '' }}" href="{{ route('user.orders') }}">Orders</a>
            </li>
            <li>
                <a class="{{ (request()->is('account-horoscope')) ? 'active' : '' }}" href="{{ route('user.horoscopes') }}">Birth Chart</a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();">
                        Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>