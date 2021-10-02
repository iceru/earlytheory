<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    @endsection

    <div class="py-12">
        <h3 class="evogria">Detail of Sales #{{$sales->sales_no}}</h3>
    </div>

    <div class="py-12 my-4">
    </div>

    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Total Price</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="IDR {{number_format($sales->total_price-$sales->discount+$sales->ship_cost)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Discount</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="IDR {{number_format($sales->discount)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Cost</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="IDR {{number_format($sales->ship_cost)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Total Price (After Discount + Shipping)</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="IDR {{number_format($sales->total_price-$sales->discount)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" @if ($sales->user) value="{{$sales->user->name}}" @else value="{{$sales->name}}" @endif readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Email</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext"@if ($sales->user) value="{{$sales->user->email}}" @else value="{{$sales->email}}" @endif readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Phone Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" @if ($sales->user) value="{{$sales->user->phone}}" @else value="{{$sales->phone}}" @endif readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Date of Birth</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" @if ($sales->user) value="{{\Carbon\Carbon::parse($sales->user->birthdate)->toFormattedDateString()}}" @else value="{{\Carbon\Carbon::parse($sales->birthdate)->toFormattedDateString()}}" @endif  readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Payment Type</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" @if ($sales->paymentmethods)
            value="{{$sales->paymentMethods->name}}"
            @endif readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Status Relationship</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->relationship}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Status Pekerjaan</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->job}}" readonly>
        </div>
    </div>
    {{-- <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Status</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->status}}" readonly>
        </div>
    </div> --}}
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label fw-bolder">Proof of Payment</label>
        <div class="col-sm-9">
            @if ($sales->payment)
                <img width=150 src="{{Storage::url('payment-proof/'.$sales->payment)}}" alt="Payment">
            @else
                -
            @endif
        </div>
    </div>
    @if ($sales->address_id)
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Address</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->shippingAddress->ship_address.', '.$sales->shippingAddress->city.', '.$sales->shippingAddress->province.' '.$sales->shippingAddress->ship_zip}}" alt="-" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Method</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->ship_method}}" alt="-" readonly>
        </div>
    </div>
    @endif

    <h5 class="mb-2 mt-5">Product Sales</h5>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Duration</th>
                        <th>Short Description</th>
                        <th>Question</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales->products as $product)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>
                            @foreach ((array)json_decode($product->image) as $item)
                                <img class="mb-1" src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                            @endforeach
                        </td>
                        <td>{{$product->title}}</td>
                        <td>idr {{number_format($product->price)}}</td>
                        <td>{{$product->pivot->qty}}</td>
                        <td>
                            @if ($product->duration > 0)
                                {{$product->duration}} menit
                            @else
                                -
                            @endif
                        </td>
                        <td>{{$product->description_short}}</td>
                        <td>{{$product->pivot->question}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
    @endsection
</x-admin-layout>

