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

            <div class="col-9 account-content">
                <form action="">
                    <div class="row">
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputName">Nama Lengkap</label>
                            <input class="form-control" type="text"
                                value="{{ old('inputName', optional($user)->name) }}" name="name" required>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email"
                                value="{{ old('inputEmail', optional($user)->email) }}" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="inputPhone">Nomor Telepon</label>
                            <input type="tel" class="form-control" value="{{ old('phone') }}" name="phone"
                                required>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="inputBirthdate">Tanggal Lahir</label>
                            <input type="text" class="form-control" value="{{ old('birthdate') }}"
                                name="birthdate" id="datepicker" required autocomplete="off">
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="relationship">Status Relationship</label>
                            <select class="form-select" name="relationship" id="relationship">
                                <option selected disabled>Select</option>
                                <option value="single" @if (old('relationship')=="single" ) {{ 'selected' }}
                                    @endif>Single</option>
                                <option value="pacaran" @if (old('relationship')=="pacaran" ) {{ 'selected' }}
                                    @endif>Pacaran</option>
                                <option value="menikah" @if (old('relationship')=="menikah" ) {{ 'selected' }}
                                    @endif>Menikah</option>
                                <option value="divorced" @if (old('relationship')=="divorced" ) {{ 'selected' }}
                                    @endif>Divorced</option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="pekerjaan">Status Pekerjaan</label>
                            <select class="form-select" name="pekerjaan" id="pekerjaan">
                                <option selected disabled>Select</option>
                                <option value="unemployed" @if (old('pekerjaan')=="unemployed" ) {{ 'selected' }}
                                    @endif>Unemployed</option>
                                <option value="employed" @if (old('pekerjaan')=="employed" ) {{ 'selected' }}
                                    @endif>Employed</option>
                                <option value="business" @if (old('pekerjaan')=="business" ) {{ 'selected' }}
                                    @endif>Business</option>
                                <option value="student" @if (old('pekerjaan')=="student" ) {{ 'selected' }} @endif>
                                    Student</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>