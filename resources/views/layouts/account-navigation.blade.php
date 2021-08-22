<div class="col-3">
    <div class="account-navigation">
        <ul class="sidebar-account">
            <li>
                <a href="{{ route('user.account') }}">Account</a>
            </li>
            <li>
                <a href="{{ route('user.orders') }}">Orders</a>
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