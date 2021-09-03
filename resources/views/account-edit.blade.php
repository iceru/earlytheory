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

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input class="form-control" type="text"
                                value="{{ old('name', optional($user)->name) }}" name="name" required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email"
                                value="{{ old('email', optional($user)->email) }}" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="inputPhone">Nomor Telepon</label>
                            <input type="tel" class="form-control" value="{{ old('phone', optional($user)->phone) }}" name="phone"
                                required>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="inputBirthdate">Tanggal Lahir</label>
                            <input type="text" class="form-control" value="{{ old('birthdate', optional($user)->birthdate) }}"
                                name="birthdate" id="datepicker" required autocomplete="off">
                        </div>

                        {{-- <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="relationship">Status Relationship</label>
                            <select class="form-select" name="relationship" id="relationship">
                                <option selected disabled>Select</option>
                                <option value="single" @if (old('relationship', optional($user)->relationship)=="single" ) {{ 'selected' }}
                                    @endif>Single</option>
                                <option value="pacaran" @if (old('relationship', optional($user)->relationship)=="pacaran" ) {{ 'selected' }}
                                    @endif>Pacaran</option>
                                <option value="menikah" @if (old('relationship', optional($user)->relationship)=="menikah" ) {{ 'selected' }}
                                    @endif>Menikah</option>
                                <option value="divorced" @if (old('relationship', optional($user)->relationship)=="divorced" ) {{ 'selected' }}
                                    @endif>Divorced</option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-lg-6 mb-3">
                            <label for="pekerjaan">Status Pekerjaan</label>
                            <select class="form-select" name="job" id="pekerjaan">
                                <option selected disabled>Select</option>
                                <option value="unemployed" @if (old('job', optional($user)->job)=="unemployed" ) {{ 'selected' }}
                                    @endif>Unemployed</option>
                                <option value="employed" @if (old('job', optional($user)->job)=="employed" ) {{ 'selected' }}
                                    @endif>Employed</option>
                                <option value="business" @if (old('job', optional($user)->job)=="business" ) {{ 'selected' }}
                                    @endif>Business</option>
                                <option value="student" @if (old('job', optional($user)->job)=="student" ) {{ 'selected' }} @endif>
                                    Student</option>
                            </select>
                        </div> --}}
                        <div class="col-12">
                            <button type="submit" class="button primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>

        $(document).ready(function(){
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                altFormat: 'yy/mm/dd',
            });
        });
    </script>
</x-app-layout>