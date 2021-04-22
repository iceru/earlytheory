<x-app-layout>
    <div class="index col-12">
        <div class="sliders">
            <div class="slider-item">
                <img src="/images/Sliders1.png" alt="">
            </div>
            <div class="slider-item">
                <img src="/images/Sliders1.png" alt="">
            </div>
        </div>

        <div class="products row mt-3">
            @forelse ($products as $product)
                <div class="product-item-container col-6 col-md-3">
                    <div class="product-image">
                        <a href="/product/{{$product->id}}"><img src="{{Storage::url('product-image/'.$product->image)}}" alt="No Image"></a>
                    </div>
                    <div class="product-item">
                        <div class="product-title">
                            <a href="/product/{{$product->id}}"><h3>{{$product->title}}</h3></a>
                        </div>
                        <p class="product-price">idr {{number_format($product->price)}}</p>
                        <p class="product-desc">{{$product->description_short}}</p>
                    </div>
                    <a href="" class="button primary my-3">Add To Cart</a>
                </div>
            @empty
                <p>No Product</p>
            @endforelse
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function(){
            $('.sliders').slick({
                dots: true
            });
        });
    </script>
    @endsection
</x-app-layout>
