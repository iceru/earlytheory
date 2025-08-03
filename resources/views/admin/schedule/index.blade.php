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
        <h3 class="evogria">Schedule Sales</h3>
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
                        <th>Status</th>
                        <th>Schedule</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $sale->sales_no }}</td>
                            <td>{{ date_format($sale->updated_at, 'd F Y H:i:s') }}</td>
                            <td>{{ number_format($sale->total_price - $sale->discount) }}</td>
                            <td>
                                @if ($sale->user)
                                    {{ $sale->user->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ ucwords($sale->status) }}</td>
                            <td>
                                @if($sale->start_date && $sale->end_date)
                                    {{ $sale->start_date->format('d M Y') }} - {{ $sale->end_date->format('d M Y') }}
                                @elseif($sale->start_date)
                                    {{ $sale->start_date->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$sale->additional->isEmpty())
                                    <a href="/admin/additional/{{ $sale->id }}"
                                        class="button secondary d-flex align-items-center btn-sm justify-content-center mb-2"><i
                                            class="fa fa-list" aria-hidden="true"></i> <span
                                            class="ms-1">Additional</span></a>
                                @endif

                                <a href="/admin/sales/{{ $sale->id }}"
                                    class="btn btn-primary justify-content-center d-flex align-items-center  btn-sm mb-2">
                                    <i class="fa fa-info-circle me-1" aria-hidden="true"></i> Detail</a>
                                <a class="btn btn-success d-flex align-items-center justify-content-center mb-2 btn-sm"
                                    href="/admin/schedule/{{ $sale->id }}/confirm"><i
                                        class="fa fa-check me-1" aria-hidden="true"></i> Confirm</a>

                                <button onclick="deleteConfirmation({{ $sale->id }})"
                                    class="btn btn-danger d-flex align-items-center btn-sm"><i
                                        class="fas fa-trash    "></i> <span class="ms-1">Delete</span></button>
                            </td>
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
            })
        </script>
    @endsection
</x-admin-layout>