<x-admin-layout>
    @section('title')
        Products Admin
    @endsection

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
      
    <div class="py-12">
        <h3 class="evogria">Products Admin</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/products/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Order Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputOrdernumber" name="inputOrdernumber">
                    </div>
                </div>
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
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="inputCategory">
                            <option selected disabled>Select Category</option>
                            <option value="product">Product</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Question Field</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="inputQuestion">
                            <option selected disabled>Select Question Field</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputStock" name="inputStock" min="0">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table display nowrap" id="table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Question Field</th>
                        <th>Stock</th>
                        <th>Short Description</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        {{-- <td scope="row">{{$loop->iteration}}</td> --}}
                        <td>{{$product->ordernumber}}</td>
                        <td>
                            @foreach ((array)json_decode($product->image) as $item)
                               <div class="ratio ratio-1x1 mb-2">
                                    <img src="{{Storage::url('product-image/'.$item)}}" alt="Image" width="100">
                               </div>
                            @endforeach
                        </td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->duration}}</td>
                        <td>{{ucwords($product->question)}}</td>
                        <td>
                            @if ($product->category == 'product')
                                {{$product->stock}}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{$product->description_short}}</td>
                        <td>{{substr($product->description, 0, 100) . '...'}}</td>
                        <td>{{ucfirst($product->category)}}</td>
                        <td> {{-- <a class="btn btn-secondary btn-small d-flex align-items-center justify-content-center mb-2" href="/admin/products/{{$product->id}}/variant"><i class="fas fa-list me-1"></i></i> Variant</a> --}}
                            <a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2" href="/admin/products/edit/{{$product->id}}"><i class="fas fa-edit me-1"></i> Edit</a>
                            <a class="btn btn-danger btn-small d-flex align-items-center justify-content-center" href="/admin/products/delete/{{$product->id}}"><i class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true
            });

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
          height: "480"
       });
    </script>
    @endsection

</x-admin-layout>
