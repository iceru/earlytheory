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
        <h3 class="evogria">Update Product SKU</h3>
    </div>
    
    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/product-variants/update-sku">
                @csrf
                <input type="hidden" name="id" value="{{$sku->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">SKU</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{$sku->id}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updatePrice" name="updatePrice" value="{{$sku->price}}" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateStock" name="updateStock" value="{{$sku->stock}}" min="0">
                    </div>
                </div>
                {{-- @foreach ($skuvalues as $skuval)
                    @foreach ($variants as $variant)
                        @if ($variant->id == $skuval->option_id)
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">{{$variant->option_name}}</label>
                            <div class="col-sm-10"> --}}
                                {{-- <input type="text" class="form-control" id="updateVariant" name="updateVariant"> --}}
                                {{-- <select class="form-select" name="updateskuval[]">
                                    @foreach($variant->optionvalues as $varval)
                                    <option value="{{$variant->id}}-{{$varval->id}}" {{ $varval->id === $skuval->value_id ? "selected" : "" }}>{{$varval->value_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @elseif ($variant->id != $skuval->option_id)
                        -
                        @endif
                    @endforeach
                @endforeach --}}
                @foreach ($variants as $variant)
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">{{$variant->option_name}}</label>
                        <div class="col-sm-10">
                            {{-- <input type="text" class="form-control" id="updateVariant" name="updateVariant"> --}}
                            <select class="form-select" name="newskuval[]">
                                <option selected disabled>Select {{$variant->option_name}} Value</option>
                                @foreach($variant->optionvalues as $varval)
                                <option value="{{$variant->id}}-{{$varval->id}}">{{$varval->value_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
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
