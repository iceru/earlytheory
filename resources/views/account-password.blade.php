<x-app-layout>
    @section('title')
        Ubah Password
    @endsection

    <div class="container account__wrapper">
        <div class="row">
            <div class="account__bread">
                <a href="{{ route('user.account') }}">Akun</a>
                <span>/</span>
                <span>Ubah Password</span>
            </div>
            <h3 class="account__titlePage">Ubah Password</h3>

            @if (session('success'))
                <div class="alert alert-success my-3">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('user.update-password') }}" method="POST">
                @csrf
                <div class="form-group col-12 col-lg-6 mb-3">
                    <label for="password" class="mb-1">New Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Type new password"
                        autocomplete="off">
                </div>
                <div class="form-group col-12 col-lg-6 mb-3">
                    <label for="password_confirmation" class="mb-1">Confirm New Password</label>
                    <input class="form-control" type="password" name="password_confirmation"
                        placeholder="Type new password again" autocomplete="off">
                </div>
                <div class="col-12">
                    <button type="submit" class="button primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
