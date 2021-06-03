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
        <h3 class="evogria">Payment Methods</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/payment-methods/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="inputName">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Logo</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="inputLogo" name="inputLogo" accept="image/*">
                        <div class="form-text">(Upload QR image for QR payment)</div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Account Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputAccNum" name="inputAccNum">
                        <div class="form-text">(Input "qr" (without quote) for QR payment)</div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Account Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputAccOwn" name="inputAccOwn">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Account Number</th>
                        <th>Account Owner</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentMethods as $paymentMethod)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$paymentMethod->name}}</td>
                        <td><img src="{{Storage::url('payment-logo/'.$paymentMethod->logo)}}" alt="{{$paymentMethod->logo}}" width="100"></td>
                        <td>{{$paymentMethod->account_number}}</td>
                        <td>{{$paymentMethod->account_owner}}</td>
                        <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                            href="/admin/payment-methods/edit/{{$paymentMethod->id}}"><i class="fas fa-edit me-1"></i> Edit</a>
                        <a href="/admin/payment-methods/edit/{{$paymentMethod->id}}"
                            class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a></td>
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

