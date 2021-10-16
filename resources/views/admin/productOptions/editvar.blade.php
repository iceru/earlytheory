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
        <h3 class="evogria">Update Product Variants</h3>
    </div>
    
    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/product-variants/update">
                @csrf
                <input type="hidden" name="id" value="{{$variant->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateVariant" name="updateVariant" value="{{$variant->option_name}}">
                    </div>
                </div>
                @foreach ($variant->optionvalues as $varval)
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Variant Value {{$loop->index+1}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="idVariantVal[]" name="idVariantVal[]" value="{{$varval->id}}" hidden>
                        <div class="input-group">
                            <input type="text" class="form-control" id="updateVariantVal[]" name="updateVariantVal[]" value="{{$varval->value_name}}">
                            {{-- <a class="btn btn-outline-secondary" type="button" href="">Edit</a> --}}
                            <a class="btn btn-outline-secondary" type="button" href="/admin/product-variant/value/{{$varval->id}}/delete">Delete</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">New Variant Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="newVariantVal" name="newVariantVal" placeholder="Example: Red,Green,Blue">
                        <div class="form-text">Separate with comma (,) without space</div>
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
