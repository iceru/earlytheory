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
        <h3 class="evogria">Sliders Image</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/sliders/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Link</label>
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
                            <option value="articles">Articles</option>
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
                        <th>Order Number</th>
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
                        <td><img src="{{Storage::url('sliders-image/'.$slider->image)}}" alt="No Image" width="100"></td>
                        <td>{{ $slider->link }}</td>
                        <td>{{ $slider->category }}</td>
                        <td><a href="/admin/sliders/edit/{{$slider->id}}">Edit</a> |
                            <a href="/admin/sliders/delete/{{$slider->id}}">Delete</a></td>
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
    @endsection
</x-admin-layout>

