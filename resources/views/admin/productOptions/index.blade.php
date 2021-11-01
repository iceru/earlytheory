<x-admin-layout>
    @section('title')
        Product Variants Admin
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
        <h3 class="evogria">Product Variants Admin</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Product Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$product->title}}" readonly>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/product-variants/store">
                @csrf
                {{-- <input type="text" name="product_id" id="product_id" value="{{$product->id}}" hidden>
                @forelse ($variants as $variant)
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputVariant" name="inputVariant" value="{{$variant->option_name}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Value(s)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputVariantVal" name="inputVariantVal">
                    </div>
                </div>
                @empty --}}
                <input type="text" name="product_id" id="product_id" value="{{$product->id}}" hidden>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputVariant" name="inputVariant" value="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Value(s)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputVariantVal" name="inputVariantVal" placeholder="Example: Red,Green,Blue">
                        <div class="form-text">Separate with comma (,) without space</div>
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
            {{-- @endforelse --}}
        </div>
    </div>
    
    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($variants as $variant)
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Variant <b>{{$variant->option_name}}</b></label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control" value="@foreach($variant->optionvalues as $varval){{$varval->value_name}}, @endforeach" readonly>
                        <a class="btn btn-outline-secondary" type="button" href="/admin/product-variant/{{$variant->id}}/edit">Edit</a>
                        <a class="btn btn-outline-secondary" type="button" href="/admin/product-variant/{{$variant->id}}/delete">Delete</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr>
        <div class="d-grid gap-2">
            <button class="button secondary" id="newSKU">Create New Product SKU</button>
        </div>
        <h5 id="newSKUtitle" hidden>New Product SKU</h5>
    </div>
    
    <div class="py-12 my-4" id="formSKU" hidden>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/product-variants/store-sku">
                @csrf
                <input type="text" name="product_id" id="product_id" value="{{$product->id}}" hidden>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputPrice" name="inputPrice" value="{{$product->price}}" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputStock" name="inputStock" value="" min="0">
                    </div>
                </div>
                @foreach ($variants as $variant)
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{$variant->option_name}}</label>
                    <div class="col-sm-10">
                        {{-- <input type="text" class="form-control" id="inputVariant" name="inputVariant"> --}}
                        <select class="form-select" name="inputvarval[]">
                            <option selected disabled>Select {{$variant->option_name}} Value</option>
                            @foreach($variant->optionvalues as $varval)
                            <option value="{{$variant->id}}-{{$varval->id}}">{{$varval->value_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endforeach
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Variant Values</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skus as $sku)
                    <tr>
                        {{-- <td scope="row">{{$loop->iteration}}</td> --}}
                        {{-- <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2" href="/admin/product-options/edit/{{$product->id}}"><i class="fas fa-edit me-1"></i> Edit</a></td> --}}
                        <td>{{$sku->id}}</td>
                        <td>@foreach ($sku->skuvalues as $item)
                            <b>{{$item->options->option_name}}:</b> {{$item->optionvalues->value_name}}, 
                        @endforeach</td>
                        <td>{{$sku->price}}</td>
                        <td>{{$sku->stock}}</td>
                        <td><a href="/admin/product-variant/sku/{{$sku->id}}/edit">Update</a> | <a href="/admin/product-variant/sku/{{$sku->id}}/delete">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function(){
            $("#newSKU").click(function(){
                $("#formSKU").removeAttr("hidden");
                $("#newSKUtitle").removeAttr("hidden");
                $('#newSKU').attr("hidden", "true");
            });
        });

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
          height: "480"
       });
    </script>
    @endsection

</x-admin-layout>
