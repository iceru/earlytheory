<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Discount Admin
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/discount/update">
                @csrf
                <input type="text" name="id" value="{{$discount->id}}" hidden>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateCode" name="updateCode" value="{{$discount->code}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nominal</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateNominal" name="updateNominal" min="0" value="{{$discount->nominal}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Minimum Purchase</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateMin" name="updateMin" min="0" value="{{$discount->min_total}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Product</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="updateProduct" id="updateProduct">
                            <option value="0" {{$discount->product_id == NULL ? 'selected' : ''}}>For all product</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}" {{$discount->product_id == $product->id ? 'selected' : ''}}>{{$product->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>
</x-admin-layout>

