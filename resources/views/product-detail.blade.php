<x-app-layout>
    <div class="product-detail container">
        <div class="product row">
            <div class="col-12 col-lg-5 product-image">
                <img src="{{Storage::url('product-image/'.$product->image)}}" alt="No Image">
            </div>
            <div class="col-12 col-lg-7">
                <div class="product-title">
                    <h3>{{$product->title}}</h3>
                </div>
                <div class="product-price">
                    <p>idr {{$product->price}}</p>
                </div>
                <div class="product-desc">
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
