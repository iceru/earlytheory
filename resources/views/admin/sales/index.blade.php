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
        <h3 class="evogria">Sales</h3>
    </div>

    <div class="py-12 my-4">
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sales Number</th>
                        <th>Order Date</th>
                        <th>Total Price (After Discount)</th>
                        <th>Name</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th>Proof of Payment</th>
                        <th>Sales Detail</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$sale->sales_no}}</td>
                        <td>{{date_format($sale->created_at, 'd F Y g:i:s')}}</td>
                        <td>{{number_format($sale->total_price-$sale->discount)}}</td>
                        <td>{{$sale->name}}</td>
                        @if ($sale->paymentmethods)
                        <td>{{$sale->paymentmethods->name}}</td>
                        @else
                        <td></td>
                        @endif
                        <td class="text-capitalize">{{$sale->status}}</td>
                        @if ($sale->payment)
                            <td><img src="{{Storage::url('payment-proof/'.$sale->payment)}}" width="100" alt="-"></td>
                        @else
                            <td>-</td>
                        @endif
                        <td><a href="/admin/sales/{{$sale->id}}" class="primary-color"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</a></td>
                        <td><a href="/admin/sales/delete/{{$sale->id}}" class="primary-color"><i class="fas fa-trash    "></i> Delete</a></td>
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

