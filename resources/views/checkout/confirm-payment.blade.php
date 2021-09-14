<x-app-layout>
    @section('title')
    Confirm Payment - {{$sales->sales_no}}
    @endsection
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Confirm Payment</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
            </div>
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

            @if (session('soldout') || $is_soldout === 1)
            <div class="alert alert-danger">
                Sorry, the product on your order already sold out.
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="/checkout/{{$sales->sales_no}}/confirm-payment/submit" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-payment col-12">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="inputName" class="fw-bold">Nama Lengkap</label>
                                <input class="form-control-plaintext" type="text" value="{{ $sales->user->name }}" name="inputName"
                                    readonly>
                            </div>
                        </div>
                        <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail" class="fw-bold">Email</label>
                                <input type="email" name="inputEmail" value="{{ $sales->user->email }}" class="form-control-plaintext"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="inputPhone" class="fw-bold">Nomor Telepon</label>
                                <input type="tel" class="form-control-plaintext" value="{{ $sales->user->phone }}" name="inputPhone"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="inputBirthdate" class="fw-bold">Tanggal Lahir</label>
                                <input type="text" class="form-control-plaintext" value="{{ $sales->user->birthdate }}"
                                    name="inputBirthdate" id="datepicker" readonly autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group ">
                                <label for="inputRelationship" class="fw-bold">Status Relationship</label>
                                <select class="form-control-plaintext" name="inputRelationship" id="inputRelationship" disabled>
                                    <option selected disabled>Select</option>
                                    <option value="single" @if ($sales->relationship == "single") {{ 'selected' }} @endif
                                        disabled>Single</option>
                                    <option value="pacaran" @if ($sales->relationship == "pacaran") {{ 'selected' }} @endif
                                        disabled>Pacaran</option>
                                    <option value="menikah" @if ($sales->relationship == "menikah") {{ 'selected' }} @endif
                                        disabled>Menikah</option>
                                    <option value="divorced" @if ($sales->relationship == "divorced") {{ 'selected' }} @endif
                                        disabled>Divorced</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group ">
                                <label for="inputPekerjaan" class="fw-bold">Status Pekerjaan</label>
                                <select class="form-control-plaintext" name="inputPekerjaan" id="inputPekerjaan" disabled>
                                    <option selected disabled>Select</option>
                                    <option value="unemployed" @if ($sales->job == "unemployed") {{ 'selected' }} @endif
                                        disabled>Unemployed</option>
                                    <option value="employed" @if ($sales->job == "employed") {{ 'selected' }} @endif
                                        disabled>Employed</option>
                                    <option value="business" @if ($sales->job== "business") {{ 'selected' }} @endif
                                        disabled>Business</option>
                                    <option value="student" @if ($sales->job == "student") {{ 'selected' }} @endif
                                        disabled>Student</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPayType">Tipe Pembayaran</label>
                        <select class="form-select" name="inputPayType" id="inputPayType">
                            <option selected disabled>Select</option>
                            @foreach ($paymentMethods as $payType)
                            <option {{old('inputPayType') == $payType->id ? 'selected' : ''}} value="{{$payType->id}}">
                                {{$payType->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputPayment">Upload Bukti Transfer (Max. 5MB)</label>
                        <input type="file" class="form-control" id="inputPayment" name="inputPayment"
                            accept="image/jpeg,image/png,image/svg+xml" required>
                    </div>

                    <p class="mb-3" style="font-weight: 700">
                        Jika error dalam upload file bukti transfer kemungkinan besar karena kamu mengunjungi website
                        dari link di instagram (otomatis dibuka menggunakan browser instagram yang banyak errornya).
                        Pastikan kamu buka website ini lewat browser utama kamu (Chrome , Safari, dsb.)
                    </p>

                    <div class="col-12 d-grid gap-2">
                        <button type="submit" class="button secondary"
                        @if ($is_soldout === 1)
                            disabled
                        @endif>
                            Submit
                            </a>
                    </div>
                </div>
            </form>

        </div>

        {{-- <script>
            $( function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                altFormat: 'yy/mm/dd',
            });
        } );
        </script> --}}

        <style>
            select.form-control-plaintext {
                -webkit-appearance: none;
                -moz-appearance: none;
                text-indent: 1px;
                text-overflow: '';
            }
        </style>
</x-app-layout>