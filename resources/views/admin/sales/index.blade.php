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
                        <th>Total Price</th>
                        <th>Name</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th>Proof of Payment</th>
                        {{-- <th>Sales Detail</th> --}}
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$sale->sales_no}}</td>
                        <td>{{date_format($sale->created_at, 'd F Y H:i:s')}}</td>
                        <td>{{number_format($sale->total_price-$sale->discount+$sale->ship_cost)}}</td>
                        @if($sale->user)
                        <td>{{$sale->user->name}}</td>
                        @else
                        <td>{{ $sale->name }}</td>
                        @endif
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
                        <td><a href="/admin/sales/{{$sale->id}}" class="btn btn-primary d-flex align-items-center btn-sm mb-2 justify-content-center"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="ms-1">Detail</span></a>
                            <button onclick="deleteConfirmation({{$sale->id}})" class="btn btn-danger d-flex align-items-center btn-sm justify-content-center"><i class="fas fa-trash    "></i> <span class="ms-1">Delete</span></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );

        function deleteConfirmation(id) {
            Swal.fire({
                title: "Delete the Data?",
                text: "You will not be able to recover it",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'GET',
                        url: "{{url('/admin/sales/delete')}}/" + id,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                Swal.fire("Done!", results.success, 'success').then(function(){
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", results.success, 'error').then(function(){
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }
    </script>
    @endsection
</x-admin-layout>

