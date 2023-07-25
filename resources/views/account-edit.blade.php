<x-app-layout>
    @section('title')
        Edit Account
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">Edit Account</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-12 col-lg-9 account-content">
                <form action="{{ route('user.account-update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Sorry !</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input class="form-control" type="text" value="{{ old('name', optional($user)->name) }}"
                                name="name" required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email" value="{{ old('email', optional($user)->email) }}"
                                class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="inputPhone">Nomor Telepon</label>
                            <input type="tel" class="form-control"
                                value="{{ old('phone', optional($user)->phone) }}" name="phone" required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3 ">
                            <label for="inputBirthdate">Tanggal Lahir</label>
                            <div class="position-relative">
                                <input type="text" class="form-control"
                                    value="{{ old('birthdate', optional($user)->birthdate) }}" name="birthdate"
                                    id="datepicker" required autocomplete="off" readonly="readonly">
                                <div class="logoCalendar">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3">Change Password</h5>
                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="password">New Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Type new password"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input class="form-control" type="password" name="password_confirmation"
                                placeholder="Type new password again" autocomplete="off">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="button primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1960:2012",
                altFormat: 'yy/mm/dd',
                defaultDate: new Date('2000/01/01'),
            });
        });
    </script>
</x-app-layout>
