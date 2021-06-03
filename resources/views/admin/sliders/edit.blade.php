<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h3 class="evogria">Update Sliders</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/sliders/update">
                @csrf
                <input type="hidden" name="id" value="{{$slider->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Link</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateOrdernumber" name="updateOrdernumber" value="{{$slider->ordernumber}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="updateImage" name="updateImage" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateLink" name="updateLink" value="{{$slider->link}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slider Category</label>
                    <div class="col-sm-10">
                       <select name="updateCategory" class="form-select" id="updateCategory">
                            <option value="" disabled>Select Category</option>
                           <option value="products" {{old('category',$slider->category)=="products"? 'selected':''}}>Products</option>
                           <option value="articles" {{old('category',$slider->category)=="articles"? 'selected':''}}>Articles</option>
                           <option value="article-detail" {{old('category',$slider->category)=="article-detail"? 'selected':''}}>Article Detail</option>
                       </select>
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>

</x-admin-layout>

