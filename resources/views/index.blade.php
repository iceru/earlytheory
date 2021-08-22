<x-app-layout>
    @section('title')
        Early Theory - Homepage
    @endsection
    <div class="index col-12">
        <div class="sliders">
            @foreach ($sliders as $slider)
            <a target="_blank" href="{{ $slider->link }}">
                <div class="slider-item">
                    <img src="{{Storage::url('sliders-image/'.$slider->image)}}" alt="">
                </div>
            </a>

            @endforeach
        </div>

        <div class="products row mt-3">
            @forelse ($products as $product)
                <div class="product-item-container col-6 col-md-4 col-lg-3">
                    <div class="product-image">
                        @foreach ((array)json_decode($product->image) as $item)
                            <a href="/product/{{$product->slug}}"><img src="{{Storage::url('product-image/'.$item)}}" loading="lazy" alt="{{ $product->title }}"></a>
                        @endforeach
                    </div>
                    <div class="product-item">
                        <div class="product-title">
                            <a href="/product/{{$product->slug}}"><h3>{{$product->title}}</h3></a>
                        </div>
                        <p class="product-price">idr {{number_format($product->price)}} @if($product->duration > 0) <span> / {{ $product->duration }} menit  </span> @endif </p>
                        <div class="product-desc">{{ $product->description_short }}</div>
                    </div>
                    @if ($product->stock <= 0 && $product->category == 'product')
                        <div class="button disabled my-3" disabled>Out of Stock</div>
                    @else
                        <div data-id="{{$product->id}}" class="button primary my-3 addcart">Add To Cart</div>
                    @endif
                </div>
            @empty
                <h4 class="evogria">No Product</h4>
            @endforelse
        </div>
    </div>

    @section('js')
    <script>

        $(document).ready(function(){
            $('.sliders').slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 3000,
                pauseOnHover: false,
            });
            $('.product-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false,
            });
            
            if(navigator.userAgent.includes("Instagram") ){
                Swal.fire({
                    title: "Gunakan browser Chrome atau Safari untuk menghindari error dalam bertransaksi",
                    icon: "warning"
                })
            }
        });

    </script>
    @endsection
</x-app-layout>
