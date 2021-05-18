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
        <h3 class="evogria">Products Admin</h3>
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Sorry !</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/products/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="inputTitle">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputPrice" name="inputPrice" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Duration</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputDuration" placeholder="Duration in Minutes" name="inputDuration" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <div class="input-group control-group increment" >
                            <input type="file" name="inputImage[]" class="form-control">
                            <div class="input-group-btn">
                              <button class="btn btn-success" type="button"><i class="fas fa-plus    "></i> Add</button>
                            </div>
                          </div>
                          <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                              <input type="file" name="inputImage[]" class="form-control">
                              <div class="input-group-btn">
                                <button class="btn btn-danger" type="button"><i class="fas fa-times    "></i> Remove</button>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Short Description</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="inputShortDesc" id="inputShortDesc" cols="30"
                            rows="2"></input>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inputDesc" id="inputDesc" cols="30" rows="5"></textarea>
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
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Short Description</th>
                        <th>Description</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>
                            @foreach ((array)json_decode($product->image) as $item)
                                <img class="mb-2" src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                            @endforeach
                        </td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->duration}}</td>
                        <td>{{$product->description_short}}</td>
                        <td>{{substr($product->description, 0, 100) . '...'}}</td>
                        <td><a href="/admin/products/edit/{{$product->id}}">Edit</a> |
                            <a href="/admin/products/delete/{{$product->id}}">Delete</a></td>
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

            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".clone").after(html);
            });

            $('body').on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });
        });

        tinymce.init({
          selector: 'textarea',
          toolbar_mode: 'floating',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',
       });
    </script>
    <script>

    </script>
    @endsection

</x-admin-layout>
