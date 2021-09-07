<x-app-layout>
    @section('title')
        Payment - {{$sales->sales_no}}
    @endsection
    <div class="col-12 checkout ">
        <div class="row no-print">
            <div class="col-12 title-page">
                <h1>Payment</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>
            @if (session('status'))
            <div class="col-12">
                <div class="alert alert-primary">
                    {{ session('status') }}
                </div>
            </div>
            @endif

            {{-- <div class="button-invoice">
                <button id="print" class="text-center button secondary">Print Invoice &nbsp; <i class="fa fa-print" aria-hidden="true"></i></button>
            </div> --}}
            <div class="total-payment">
                <h4>Total Payment: idr {{number_format($sales->total_price-$sales->discount+$sales->ship_cost)}}</h4>
            </div>
            <div class="disclaimer">
                <h5 class="text-center text-danger mb-3"><b>Disclaimer:</b> Transaksi hanya akan diproses jika anda sudah melakukan konfirmasi pembayaran</h5>
            </div>
            <div class="mx-auto col-12">
            </div>
            <div class="payment-method col-12">
                <div class="row payment-method-container">
                    <div class="col-12 type active" id="bank">
                        <p>Bank Transfer / QR</p>
                    </div>
                    {{-- <div class="col-6 type" id="qr">
                        <p>QR Payment (Gopay, OVO)</p>
                    </div> --}}
                </div>
                <div class="bank-detail payment-detail show">
                    @foreach ($paymethods_bank as $item)
                    @if ($loop->first)
                    <div class="bank-method-item row mb-3 align-items-center">
                        <div class="bank-image col-12">
                            <img src="{{Storage::url('payment-logo/'.$item->logo)}}" alt="">
                        </div>
                        {{-- <div class="bank-text col-12 col-lg-4">
                            <span class="bank-number">{{$item->account_number}}</span> <br>
                            <span class="bank-owner"> a/n {{$item->account_owner}}</span>
                        </div> --}}
                    </div>
                    @endif
                    
                    @endforeach
                </div>

            <div class="col-12 d-grid gap-2">
                <div class="d-flex justify-content-center">
                    <a class="button primary me-3" href="/checkout/{{$sales->sales_no}}/confirm-payment">
                        Konfirmasi Pembayaran Sekarang
                    </a>
                    <a class="button primary-line" href="/orders">
                        Konfirmasi Lain Waktu
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="print">
        <h1 class="mb-3 text-center pt-3">Invoice</h1>
        <hr>
        <p>Sales Number: {{$sales->sales_no}}</p>
        <p class="mb-3">Order Status: <span style="color: orange">{{strtoupper($sales->status)}}</span></p>
        <h5 class="mb-2">Products</h5>
        <table class="table table-bordered">
            @foreach ($sales->products as $product)
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Question</th>
                </tr>
            </thead>
            <tr>
                <td scope="row">{{$loop->iteration}}</td>
                <td>
                    @foreach ((array)json_decode($product->image) as $item)
                        <img src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                    @endforeach
                </td>
                <td>{{$product->title}}</td>
                <td>idr {{number_format($product->price)}} @if($product->duration) / {{$product->duration}} Minutes @endif</td>
                <td>{{$product->pivot->question}}</td>
            </tr>
            @endforeach
        </table>
        <p><b>Total Payment:</b> idr {{number_format($sales->total_price)}}</p>
        @if ($sales->discount)
        <p><b>Discount:</b> - idr {{number_format($sales->discount)}}</p>
        <p><b>Total Payment (After Discount):</b> idr {{number_format($sales->total_price-$sales->discount)}}</p>
        @endif

    </div>--}}
    @section('js')
    <script>
        $(document).ready(function(){
            $('#bank').click(function() {
                $('.bank-detail').addClass('show');
                $('.qr-detail').removeClass('show');
                $('#qr').removeClass('active');
                $(this).addClass('active');
            });

            $('#qr').click(function() {
                $('.bank-detail').removeClass('show');
                $('.qr-detail').addClass('show');
                $(this).addClass('active');
                $('#bank').removeClass('active');
            })

            $('#print').click(function() {
                window.print();
            })
        });
    </script>
    @endsection
</x-app-layout>
