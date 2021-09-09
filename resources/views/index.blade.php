<x-app-layout>
    @section('title')
        Early Theory - Homepage
    @endsection
    <div class="index col-12">
        <div class="sliders-index">
            @foreach ($sliders as $slider)
            <a target="_blank" href="{{ $slider->link }}">
                <div class="slider-item">
                    <div class="ratio ratio-16x9">
                        <img src="{{Storage::url('sliders-image/'.$slider->image)}}" alt="">
                    </div>
                </div>
            </a>

            @endforeach
        </div>

        <div class="page-tabs">
            <div class="tab" onclick="ActivePage('services')">
                <h4 >Tarot Services</h4>
            </div>
            <div class="tab"  onclick="ActivePage('items')">
                <h4>Products</h4>
            </div>
            <div class="tab"  onclick="ActivePage('article-index')">
                <h4>Articles</h4>
            </div>
        </div>

        <p>{{ url()->full() }}</p>

        <div class="products services row mt-3 page active" >
            @forelse ($services as $product)
                <div class="product-item-container col-6 col-md-4 col-lg-3">
                    <div class="product-image service-image">
                        @foreach ((array)json_decode($product->image) as $item)
                            <a href="/product/{{$product->slug}}">
                                <div class="ratio ratio-1x1">
                                    <img src="{{Storage::url('product-image/'.$item)}}" loading="lazy" alt="{{ $product->title }}">
                                </div>
                            </a>
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
        <div class="products items row mt-3 page">
            @forelse ($products as $product)
            <div class="product-item-container col-6 col-md-4 col-lg-3">
                <div class="product-image physical-image" id="product_image">
                    @foreach ((array)json_decode($product->image) as $item)
                        <a href="/product/{{$product->slug}}">
                            <div class="ratio ratio-1x1">
                                <img src="{{Storage::url('product-image/'.$item)}}" loading="lazy" alt="{{ $product->title }}">
                            </div>
                        </a>
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

        <div class="article-index page mt-3">
            @include('article-index')
        </div>
    </div>

    @section('js')
    <script>

        $(document).ready(function(){
            $('.sliders-index').slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 3000,
                pauseOnHover: false,
            });
            $('.service-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false,
            });
            $('.physical-image').slick({
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

        function ReinitSliders(page) {
            if (page == 'services') {
                $('.service-image').slick('unslick');
                $('.service-image').slick({
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                });
            } else if (page == 'items') {
                $('.physical-image').slick('unslick')
                $('.physical-image').slick({
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                });
            } 
        }

        function ActivePage(page) {
            $('.page').removeClass('active');
            $('.'+page).addClass('active');

            ReinitSliders(page);
        }

    </script>
    @endsection
</x-app-layout>
