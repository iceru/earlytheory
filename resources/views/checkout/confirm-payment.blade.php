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

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="/checkout/{{$sales->sales_no}}/confirm-payment/submit" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-payment col-12">
                    <div class="form-group">
                        <label for="inputName">Nama Lengkap</label>
                        <input class="form-control-plaintext" type="text" value="{{ $sales->name }}" name="inputName" readonly>
                    </div>
                    <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="inputEmail" value="{{ $sales->email }}" class="form-control-plaintext" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Nomor Telepon</label>
                        <input type="tel" class="form-control-plaintext" value="{{ $sales->phone }}" name="inputPhone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputBirthdate">Tanggal Lahir</label>
                        <input type="text" class="form-control-plaintext" value="{{ $sales->birthdate }}" name="inputBirthdate" id="datepicker" readonly autocomplete="off">
                    </div>
                    <div class="form-group ">
                        <label for="inputRelationship">Status Relationship</label>
                        <select class="form-control-plaintext" name="inputRelationship" id="inputRelationship" disabled>
                            <option selected disabled>Select</option>
                            <option value="single"  @if ($sales->relationship == "single") {{ 'selected' }} @endif disabled>Single</option>
                            <option value="pacaran"  @if ($sales->relationship == "pacaran") {{ 'selected' }} @endif disabled>Pacaran</option>
                            <option value="menikah" @if ($sales->relationship  == "menikah") {{ 'selected' }} @endif disabled>Menikah</option>
                            <option value="divorced" @if ($sales->relationship  == "divorced") {{ 'selected' }} @endif disabled>Divorced</option>
                        </select>
                    </div>
                    <div class="form-group ">
                      <label for="inputPekerjaan">Status Pekerjaan</label>
                      <select class="form-control-plaintext" name="inputPekerjaan" id="inputPekerjaan" disabled>
                            <option selected disabled>Select</option>
                            <option value="unemployed" @if ($sales->job  == "unemployed") {{ 'selected' }} @endif disabled>Unemployed</option>
                            <option value="employed" @if ($sales->job == "employed") {{ 'selected' }} @endif disabled>Employed</option>
                            <option value="business" @if ($sales->job== "business") {{ 'selected' }} @endif disabled>Business</option>
                            <option value="student"  @if ($sales->job == "student") {{ 'selected' }} @endif disabled>Student</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="inputPayType">Tipe Pembayaran</label>
                        <select class="form-select" name="inputPayType" id="inputPayType">
                            <option selected disabled>Select</option>
                            @foreach ($paymentMethods as $payType)
                            <option {{old('inputPayType') == $payType->id ? 'selected' : ''}} value="{{$payType->id}}">{{$payType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputPayment">Upload Bukti Transfer (Max. 5MB)</label>
                        <input type="file" class="form-control" id="inputPayment" name="inputPayment" accept="image/jpeg,image/png,image/svg+xml" required>
                    </div>
                    <div class="col-12 d-grid gap-2">
                        <button type="submit" class="button secondary">
                            Submit
                        </a>
                    </div>
                </div>
            </form>

    </div>

    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                altFormat: 'yy/mm/dd',
            });
        } );
    </script>

    <style>
        select.form-control-plaintext {
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1px;
        text-overflow: '';
        }
    </style>
</x-app-layout>
