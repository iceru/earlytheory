<x-app-layout>
    <div class="product-detail container main-content">
        <div class="product row">
            <div class="col-12 col-lg-5 product-image">
                <img src="{{Storage::url('product-image/'.$product->image)}}" alt="No Image">
            </div>
            <div class="col-12 col-lg-7">
                <div class="product-title mb-2">
                    <h3>{{$product->title}}</h3>
                </div>
                <div class="product-price mb-4">
                    <p>idr {{number_format($product->price)}}</p>
                </div>
                <div class="product-desc mt-4 mb-3">
                    {{$product->description}}
                </div>
                <div class="add-to-cart">
                    <button class="button primary">
                        Order Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
