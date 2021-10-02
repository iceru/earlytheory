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
                        <input type="text" class="form-control" id="inputVariantVal" name="inputVariantVal">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
            {{-- @endforelse --}}
        </div>
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Options</th>
                        <th>Variant Name</th>
                        <th>Variant Values</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variants as $variant)
                    <tr>
                        {{-- <td scope="row">{{$loop->iteration}}</td> --}}
                        <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2" href="/admin/product-options/edit/{{$product->id}}"><i class="fas fa-edit me-1"></i> Edit</a></td>
                        <td>{{$variant->option_name}}</td>
                        <td></td>
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
