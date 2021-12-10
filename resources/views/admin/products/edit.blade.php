<x-admin-layout>
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

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Update Product</h3>
    </div>
    
    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/products/update">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Order Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateOrdernumber" name="updateOrdernumber"
                            value="{{$product->ordernumber}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateTitle" name="updateTitle"
                            value="{{$product->title}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updatePrice" name="updatePrice" min="0"
                            value="{{$product->price}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Duration</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateDuration" name="updateDuration" min="0"
                            value="{{$product->duration}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <div class="input-group control-group increment">
                            <input type="file" name="updateImage[]" class="form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="file" name="updateImage[]" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i class="fas fa-times    "></i>
                                        Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Short Description</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="updateShortDesc" id="updateShortDesc"
                            value="{{ $product->description_short }}"></input>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="updateDesc" id="updateDesc" cols="30"
                            rows="6">{{$product->description}}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="updateCategory">
                            <option selected disabled>Select Category</option>
                            <option {{  $product->category === "product" ? 'selected' : '' }} value="product">Product</option>
                            <option {{  $product->category === "service" ? 'selected' : '' }} value="service">Service</option>
                          </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Question</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Select Category" name="updateQuestion">
                            <option selected disabled>Select Question Field</option>
                            <option {{  $product->question === "yes" ? 'selected' : '' }} value="yes">Yes</option>
                            <option {{  $product->question === "no" ? 'selected' : '' }} value="no">No</option>
                          </select>
                    </div>
                </div>
                <div class="mb-3 row" hidden>
                    <label class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputStock" name="updateStock" min="0" value="{{$product->stock}}">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>
    @section('js')
    <script>
        $(document).ready(function() {
            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".clone").after(html);
            });

            $('body').on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });
        });
    </script>
    @endsection
</x-admin-layout>
