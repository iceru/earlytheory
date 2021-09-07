<x-app-layout>
    @section('title')
        {{$product->title}}
    @endsection
    <div class="product-detail container main-content">
        <div class="product row">
            <div class="col-12 col-lg-5 product-image ">
                @foreach ((array)json_decode($product->image) as $item)
                    <img class="pb-2" src="{{Storage::url('product-image/'.$item)}}" alt="No Image">
                @endforeach
            </div>
            <div class="col-12 col-lg-7">
                <div class="product-title mb-2">
                    <h3>{{$product->title}}</h3>
                </div>
                <div class="product-price mb-4">
                    <p>idr {{number_format($product->price)}}</p>
                </div>
                <div class="product-desc mt-4 mb-3">
                    {!! $product->description !!}
                </div>
                <div class="add-to-cart">
                    @if ($product->stock <= 0 && $product->category == 'product')
                    <div class="button secondary my-3" disabled>Out of Stock</div>
                    @else
                    <div data-id="{{$product->id}}" class="button primary my-3 addcart">Add To Cart</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="other-products">
            <h3 class="evogria other-title">Other Products</h3>
            <div class="row products">
                @foreach ($related as $product)
                <div class="product-item-container col-6 col-md-3">
                    <div class="product-images related">
                        @foreach ((array)json_decode($product->image) as $item)
                            <img class="pb-2" src="{{Storage::url('product-image/'.$item)}}" alt="No Image">
                        @endforeach
                    </div>
                    <div class="product-item">
                        <div class="product-title">
                            <a href="/product/{{$product->slug}}">
                                <h3>{{$product->title}}</h3>
                            </a>
                        </div>
                        <p class="product-price">idr {{number_format($product->price)}}</p>
                        <p class="product-desc">{{$product->description_short}}</p>
                    </div>
                    @if ($product->stock <= 0 && $product->category == 'product')
                    <div class="button secondary my-3" disabled>Out of Stock</div>
                    @else
                    <div data-id="{{$product->id}}" class="button primary my-3 addcart">Add To Cart</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('js')
    <script>

        $(document).ready(function(){
            $('.product-image').slick({
                dots: true,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 5000,
            });

            $('.product-images').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
            });
        });
    </script>
    @endsection
</x-app-layout>
