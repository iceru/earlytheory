<x-app-layout>
    @section('title')
        My Account
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">My Account</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-12 col-md-9 account-content">
                <h4 class="mb-4 account-name">{{ $user->name }}</h4>
                <div class="row mb-3">
                    <div class="col-6 account-item">
                        <p><b>Email: <br> </b> {{ $user->email }}</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Birthdate: <br> </b> {{ $user->birthdate ? $user->birthdate : '-' }}</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Phone Number: <br> </b>{{ $user->phone ? $user->phone : '-' }}</p>
                    </div>
                    {{-- <div class="col-6 account-item">
                        <p><b>Status Relationship: <br> </b>{{ $user->relationship ? $user->relationship : '-' }}</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Status Pekerjaan: <br> </b>{{ $user->job ? $user->job : '-' }}</p>
                    </div> --}}
                </div>
                <a href="{{ route('user.account-edit') }}" class="button primary">Edit Account <i class="ms-2 fas fa-edit"></i></a>
            </div>
        </div>

    </div>
</x-app-layout>