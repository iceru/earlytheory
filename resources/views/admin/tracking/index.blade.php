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
        <h3 class="evogria">Shipping</h3>
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
                        {{-- <th>Products</th> --}}
                        <th>Shipping Courier</th>
                        <th>Tracking Number</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr>
                        <form action="{{ route('admin.tracking.update', $sale->id) }}">
                            <td scope="row">{{$loop->iteration}}</td>
                            <td>{{$sale->sales_no}}</td>
                            <td>{{date_format($sale->created_at, 'd F Y H:i:s')}}</td>
                            <td>{{number_format($sale->total_price-$sale->discount)}}</td>
                            <td>{{$sale->user->name}}</td>
                            {{-- <td>
                                <ul class="ps-3 m-0">
                                    @foreach ($sale->products as $item)
                                        <li>
                                            {{ $item->title }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td> --}}
                            <td>
                                {{ $sale->ship_method }}
                            </td>
                            <td>
                                <div class="form-group" id="tracking_no" @if (!empty($sale->tracking_no)) hidden @endif>
                                    <input type="text" class="form-control" name="tracking_no" 
                                    @if (!empty($sale->tracking_no)) value="{{ $sale->tracking_no }}" @endif placeholder="Tracking Number">
                                </div> 
                                <div id="tracking_ex">
                                    {{ $sale->tracking_no }}
                                </div>
                            </td>
                            <td>
                                <button type="submit" id="tracking_submit" class="btn btn-success justify-content-center d-flex align-items-center  btn-sm mb-2" 
                                @if (!empty($sale->tracking_no)) style="display: none !important;" @endif> <i class="fa fa-paper-plane me-1"></i> Submit</button>
                                <button class="btn btn-warning btn-sm mb-2" id="tracking_edit" type="button"><i class="fas fa-edit me-1"></i> Edit</button>
                                <a href="/admin/sales/{{$sale->id}}" type="submit" class="btn btn-primary justify-content-center d-flex align-items-center  btn-sm mb-2">
                                    <i class="fa fa-info-circle me-1"></i> Detail
                                </a>
                            </td>
                        </form>
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
        });
        
        $('#tracking_edit').click(function (e) { 
            e.preventDefault();
            $('#tracking_no').removeAttr('hidden');
            $('#tracking_submit').css('display', 'flex');
            $(this).hide();
            $('#tracking_ex').hide();
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

