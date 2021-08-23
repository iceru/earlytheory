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
            <input type="text" class="form-control-plaintext" value="idr {{number_format($sales->total_price)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Discount</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="idr {{number_format($sales->discount)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Cost</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="idr {{number_format($sales->ship_cost)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Total Price (After Discount + Shipping)</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="idr {{number_format($sales->total_price-$sales->discount)}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{{$sales->user->name}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Email</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{{$sales->user->email}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Phone Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{{$sales->user->phone}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Date of Birth</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{{\Carbon\Carbon::parse($sales->user->birthdate)->toFormattedDateString()}}" readonly>
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
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->user->relationship}}" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Status Pekerjaan</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->user->job}}" readonly>
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
            <img width=150 src="{{Storage::url('payment-proof/'.$sales->payment)}}" alt="-">
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Address</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->ship_address}}, {{$sales->city}}, {{$sales->province}}, {{$sales->ship_zip}}" alt="-" readonly>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-sm-3 col-form-label fw-bolder">Shipping Method</label>
        <div class="col-sm-9">
            <input type="text" class="form-control-plaintext text-capitalize" value="{{$sales->ship_method}}" alt="-" readonly>
        </div>
    </div>

    <h5 class="mb-2">Product Sales</h5>
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
                        <td>{{$product->duration}} menit</td>
                        <td>{{$product->description_short}}</td>
                        <td>{{$product->pivot->question}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>

    @section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
    @endsection
</x-admin-layout>

