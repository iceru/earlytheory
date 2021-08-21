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

            <div class="col-9 account-content">
                <h4 class="mb-4 account-name">Muhamad Hafiz</h4>
                <div class="row mb-3">
                    <div class="col-6 account-item">
                        <p><b>Email: </b> m.hafiz1825@gmail.com</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Birthdate: </b> 25 November 1997</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Nomor Telepon: </b>08112312321</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Status Relationship: </b>Single</p>
                    </div>
                    <div class="col-6 account-item">
                        <p><b>Status Pekerjaan: </b>Employed</p>
                    </div>
                </div>
                <a href="{{ route('user.account-edit') }}" class="button primary">Edit Account <i class="ms-2 fas fa-edit"></i></a>
            </div>
        </div>

    </div>
</x-app-layout>