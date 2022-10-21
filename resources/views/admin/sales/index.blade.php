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

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table data-table" id="table">
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
                {{-- <a href="/admin/sales/edit/{{$sale->id}}" class="btn btn-secondary d-flex align-items-center btn-sm mb-2 justify-content-center"><i class="fas fa-edit me-1" aria-hidden="true"></i> <span class="ms-1">Edit</span></a> --}}
                {{-- <tbody>
                    @foreach ($sales as $sale)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$sale->sales_no}}</td>
                        <td>{{date_format($sale->created_at, 'd F Y H:i:s')}}</td>
                        <td>{{number_format($sale->total_price-$sale->discount+$sale->ship_cost)}}</td>
                        @if ($sale->user)
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
                </tbody> --}}
            </table>
        </div>
    </div>

    @section('js')
        <script>
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.sales') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'sales_no',
                            name: 'sales_no'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'total_price',
                            name: 'total_price'
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'paymentmethods.name',
                            name: 'paymentmethods.name'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });

            });

            function deleteConfirmation(id) {
                Swal.fire({
                    title: "Delete the Data?",
                    text: "You will not be able to recover it",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    reverseButtons: !0
                }).then(function(e) {
                    if (e.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'GET',
                            url: "{{ url('/admin/sales/delete') }}/" + id,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
                            success: function(results) {

                                if (results.success === true) {
                                    Swal.fire("Done!", results.success, 'success').then(function() {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error!", results.success, 'error').then(function() {
                                        location.reload();
                                    });
                                }
                            }
                        });

                    } else {
                        e.dismiss;
                    }

                }, function(dismiss) {
                    return false;
                })
            }
        </script>
    @endsection
</x-admin-layout>
