<x-app-layout>
    @section('title')
        My Account
    @endsection

    <div class="container account__wrapper">
        <div class="row">
            <section class="account__info">
                <div>
                    <h3>{{ $user->name }}</h3>
                    <p>Member sejak {{ \Carbon\Carbon::parse($user->created_at)->format('j M Y') }}</p>
                </div>
                <div>
                    <a href="{{ route('logout') }}" class="btn btn-logout">
                        Keluar
                    </a>
                </div>
            </section>
            <section class="account__menu">
                <a href="{{ route('user.orders') }}">
                    <div class="account__menuItem">
                        Riwayat <br> Pemesanan
                    </div>
                </a>
                <a href="{{ route('user.account-edit') }}">
                    <div class="account__menuItem">
                        Edit <br> Profile
                    </div>
                </a>
                <a href="">
                    <div class="account__menuItem">
                        Kelas & <br> Workshop
                    </div>
                </a>
                <a href="">
                    <div class="account__menuItem">
                        Ubah <br> Password
                    </div>
                </a>
            </section>
        </div>

    </div>
</x-app-layout>
