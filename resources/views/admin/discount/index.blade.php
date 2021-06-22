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
        <h3 class="evogria">Discount</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/discount/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCode" name="inputCode">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nominal</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputNominal" name="inputNominal" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Minimum Purchase</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputMin" name="inputMin" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Product</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="inputProduct" id="inputProduct">
                            <option selected value="0">For all product</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nominal</th>
                        <th>Minimum Purchase</th>
                        <th>Product</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discount as $disc)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$disc->code}}</td>
                        <td>{{$disc->nominal}}</td>
                        <td>{{$disc->min_total}}</td>
                        @if ($disc->products)
                        <td>{{$disc->products->title}}</td>
                        @else
                        <td>All Product</td>
                        @endif
                        <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                            href="/admin/discount/edit/{{$disc->id}}"><i class="fas fa-edit me-1"></i> Edit</a>
                        <a href="/admin/discount/delete/{{$disc->id}}"
                            class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
     <script>
        tinymce.init({
          selector: 'textarea',
          toolbar_mode: 'floating',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',
       });
      </script>
    @endsection

</x-admin-layout>

