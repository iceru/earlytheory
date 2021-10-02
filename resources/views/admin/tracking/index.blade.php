<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('css')
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
                                <div class="form-group" id="tracking_no_{{ $sale->id }}" @if (!empty($sale->tracking_no)) hidden @endif>
                                    <input type="text" class="form-control" name="tracking_no" 
                                    @if (!empty($sale->tracking_no)) value="{{ $sale->tracking_no }}" @endif placeholder="Tracking Number">
                                </div> 
                                <div id="tracking_ex_{{ $sale->id }}">
                                    {{ $sale->tracking_no }}
                                </div>
                            </td>
                            <td>
                                <button type="submit" id="tracking_submit_{{ $sale->id }}" class="btn btn-success justify-content-center d-flex align-items-center  btn-sm mb-2" 
                                @if (!empty($sale->tracking_no)) style="display: none !important;" @endif> <i class="fa fa-paper-plane me-1"></i> Submit</button>
                                <button @if (empty($sale->tracking_no)) style="display: none !important;" @endif class="btn btn-warning btn-sm mb-2" id="tracking_edit_{{ $sale->id }}" type="button"><i class="fas fa-edit me-1"></i> Edit</button>
                                <a href="/admin/sales/{{$sale->id}}" type="submit" class="btn btn-primary justify-content-center d-flex align-items-center  btn-sm mb-2">
                                    <i class="fa fa-info-circle me-1"></i> Detail
                                </a>
                            </td>
                        </form>

                        <script>
                             $('#tracking_edit_{{ $sale->id }}').click(function (e) { 
                                e.preventDefault();
                                $('#tracking_no_{{ $sale->id }}').removeAttr('hidden');
                                $('#tracking_submit_{{ $sale->id }}').css('display', 'flex');
                                $(this).hide();
                                $('#tracking_ex_{{ $sale->id }}').hide();
                            });
                        </script>
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

