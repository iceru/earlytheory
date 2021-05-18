<x-app-layout>
    <div class="col-12 checkout no-print">
        <div class="row page-success">
            <div class="col-12 title-page">
                <h1>Payment Success</h1>
            </div>
            {{-- <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
            </div> --}}
            <div class="col-12 payment-success">
                <div class="text-center thank-you mb-3">
                    <img src="/images/pay.svg" alt="">
                    <h5>Thank you for your Purchase!</h5>
                    <p>We will contact you soon</p>
                </div>
                <hr>
                <div class="row proof">
                    <div class="col-12 col-md-6 proof-desc">
                        <div class="row">
                            <div class="col-6">
                                <p><b>Sales Number:</b> <br> {{$sales->sales_no}}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Name:</b> <br> {{$sales->name}}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Email:</b> <br> {{$sales->email}}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Phone Number:</b> <br> {{$sales->phone}}</p>
                            </div>
                            <div class="col-12 mt-3">
                                <button id="print" class="button primary">Print Invoice &nbsp; <i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                        {{-- <h5>Relationship: {{strtoupper($sales->relationship)}}</h5>
                        <h5>Pekerjaan: {{strtoupper($sales->job)}}</h5> --}}
                    </div>

                    <div class="col-12 col-md-6 proof-image">
                        <b>Proof of Payment:</b>
                        <img src="{{Storage::url('payment-proof/'.$sales->payment)}}">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="print">
        <h1 class="mb-3 text-center pt-3">Invoice</h1>
        <hr>
        <p>Sales Number: {{$sales->sales_no}}</p>
        <p class="mb-3">Order Status: <span style="color: green">PAID (Will be Confirmed)</span></p>
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
                {{-- <td>
                    @foreach ((array)json_decode($product->image) as $item)
                        <img src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                    @endforeach
                </td> --}}
                <td>{{$product->title}}</td>
                <td>idr {{number_format($product->price)}} @if($product->duration) / {{$product->duration}} Minutes @endif</td>
                <td>{{$product->pivot->question}}</td>
            </tr>
            @endforeach
        </table>
        <p><b>Total Paid:</b> idr {{number_format($sales->total_price)}}</p>
        @if ($sales->discount)
        <p><b>Discount:</b> - idr {{number_format($sales->discount)}}</p>
        <p><b>Total Paid (After Discount):</b> idr {{number_format($sales->total_price-$sales->discount)}}</p>
        @endif
        <div class="mt-3">
            <p class="mb-2">Proof of Payment: <br>
                <img width=150 src="{{Storage::url('payment-proof/'.$sales->payment)}}" alt="">
            </p>
        </div>

    </div>

    @section('js')
    <script>
        $('#print').click(function() {
            window.print();
        })
    </script>
    @endsection
</x-app-layout>
