<x-admin-layout>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    @endsection

    @if (count($errors) > 0)
        <div class="alert alert-danger mt-3">
            <strong>Sorry !</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Sliders Image</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/sliders/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Order Number</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputOrdernumber" name="inputOrdernumber">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="inputImage" name="inputImage" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputLink" name="inputLink">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Category</label>
                    <div class="col-sm-10">
                        <select name="inputCategory" class="form-select" id="inputCategory">
                            <option value="" disabled selected>Select Category</option>
                            <option value="products">Products</option>
                            {{-- <option value="articles">Articles</option> --}}
                            <option value="birthchart">Birth Chart</option>
                            <option value="article-detail">Article Detail</option>
                        </select>
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
                        {{-- <th>No</th> --}}
                        <th>Order</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Category</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            {{-- <td scope="row">{{$loop->iteration}}</td> --}}
                            <td>{{ $slider->ordernumber }}</td>
                            <td>
                                <div class="ratio ratio-16x9">
                                    <img src="{{ Storage::url('sliders-image/' . $slider->image) }}" alt="No Image"
                                        width="100">
                                </div>
                            </td>
                            <td>{{ $slider->link }}</td>
                            <td>{{ $slider->category }}</td>
                            <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                    href="/admin/sliders/edit/{{ $slider->id }}"><i class="fas fa-edit me-1"></i>
                                    Edit</a>
                                <a href="/admin/sliders/delete/{{ $slider->id }}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                        class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
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
            });
        </script>
    @endsection
</x-admin-layout>
