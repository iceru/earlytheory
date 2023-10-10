<x-app-layout>
    @section('title')
        Confirm Payment - {{ $sales->sales_no }}
    @endsection
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Confirm Payment</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                @if ($is_additional)
                    <div class="circle"></div>
                    <div class="line"></div>
                @endif
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Sorry !</strong> Terdapat masalah dalam input data.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('soldout') || $is_soldout === 1)
                <div class="alert alert-danger">
                    Maaf, Produk tersebut sudah habis.
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/checkout/{{ $sales->sales_no }}/confirm-payment/submit" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-payment col-12">
                    <div>
                        Pesanan No: <strong>#{{ $sales->sales_no }}</strong>
                    </div>
                    <div class="confirm__total">
                        Total: IDR {{ number_format($sales->total_price - $sales->discount + $sales->ship_cost) }}
                    </div>
                    <div class="form-group">
                        <label for="inputPayType">Pilih Tipe Pembayaran</label>
                        <select class="form-select" name="inputPayType" id="inputPayType">
                            <option selected disabled>Pilih Pembayaran</option>
                            @foreach ($paymentMethods as $payType)
                                <option {{ old('inputPayType') == $payType->id ? 'selected' : '' }}
                                    value="{{ $payType->id }}">
                                    {{ $payType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputPayment">Upload Bukti Transfer (Max. 5MB)</label>
                        <input type="file" class="form-control" id="inputPayment" name="inputPayment"
                            accept="image/jpeg,image/png,image/svg+xml" required>
                    </div>

                    <p class="confirm__infoPayment">
                        Jika error dalam upload file bukti transfer kemungkinan besar karena kamu mengunjungi website
                        dari link di instagram (otomatis dibuka menggunakan browser instagram yang banyak errornya).
                        Pastikan kamu buka website ini lewat browser utama kamu (Chrome , Safari, dsb.)
                    </p>

                    <div class="col-12 d-grid gap-2">
                        <button type="submit"
                            @if ($is_soldout === 1) class="button disabled" disabled @else class="button secondary" @endif>
                            Submit
                        </button>
                    </div>
                </div>
            </form>

        </div>

        <style>
            select.form-control-plaintext {
                -webkit-appearance: none;
                -moz-appearance: none;
                text-indent: 1px;
                text-overflow: '';
            }
        </style>
</x-app-layout>
