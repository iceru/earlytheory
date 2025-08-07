<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
        <!-- Bootstrap Datepicker CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
    @endsection

    <div class="py-12">
        <h3 class="evogria">Payment Confirmation</h3>
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
                            @if ($sale->paymentmethods)
                                <td>{{ $sale->paymentmethods->name }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ ucwords($sale->status) }}</td>
                            @if ($sale->payment)
                                <td><img src="{{ Storage::url('payment-proof/' . $sale->payment) }}" width="100"
                                        alt="-"></td>
                            @else
                                <td>-</td>
                            @endif
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
                                <button onclick="showScheduleModal({{ $sale->id }})"
                                    class="btn btn-success d-flex align-items-center justify-content-center mb-2 btn-sm">
                                    <i class="fa fa-check me-1" aria-hidden="true"></i> Confirm</button>
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

    <!-- Schedule Confirmation Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title evogria" id="scheduleModalLabel">
                        <i class="fa fa-calendar me-2"></i>Confirm Schedule
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="scheduleForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="start_date" class="form-label">
                                        <i class="fa fa-calendar-plus me-1"></i>Schedule Date
                                    </label>
                                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" 
                                           placeholder="Select schedule date" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            Please select the schedule period for this confirmation.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check me-1"></i>Confirm Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('js')
        <!-- Bootstrap Datepicker JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('#table').DataTable();
                
                // Initialize datepickers
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: 'linked',
                    clearBtn: true,
                    autoclose: true,
                    todayHighlight: true,
                });

                // Handle date range validation
                $('#start_date').on('changeDate', function(selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $('#end_date').datepicker('setStartDate', startDate);
                });

                // Handle form submission
                $('#scheduleForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    var startDate = $('#start_date').val();
                    
                    if (!startDate) {
                        Swal.fire({
                            title: 'Validation Error',
                            text: 'Please select schedule date',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Confirming schedule',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: 'JSON',
                        success: function(response) {
                            Swal.close();
                            $('#scheduleModal').modal('hide');
                            
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Schedule confirmed successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            
                            var errorMessage = 'An error occurred while confirming the schedule';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });

            function showScheduleModal(saleId) {
                // Set the form action URL
                $('#scheduleForm').attr('action', '/admin/confirm-payment/' + saleId + '/confirm');
                
                // Clear previous values
                $('#start_date').val('');
                $('#end_date').val('');
                $('.datepicker').datepicker('update');
                
                // Show the modal
                $('#scheduleModal').modal('show');
            }

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