<x-app-layout>
    @section('title')
        Early Theory - Homepage
    @endsection
    <div class="index col-12">
        <div class="sliders-index sliders">
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
    </div>

    <div class="page-tabs">
        <div class="tab active" id="services" onclick="ActivePage('services')">
            <h4>Ramalan</h4>
        </div>
        <div class="tab" id="items" onclick="ActivePage('items')">
            <h4>Kristal</h4>
        </div>
        <div class="tab" id="article-index" onclick="ActivePage('article-index')">
            <h4>Artikel</h4>
        </div>
    </div>
    <div class="col-12 index">
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

        function options(){
            return {
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false,
            }
        }
        function sameDiv() {
            var maxHeight = 0
            $(".product-item").each(function(){
                if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });
            $(".product-item").height(maxHeight);
        }

        $( window ).resize(function() {
            sameDiv();
        });
      
        $(document).ready(function(){
            $('.sliders-index').slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false,
            });
            $('.service-image').slick(options());
            $('.physical-image').slick(options());
            

            if(window.location.pathname == '/articles') {
                ActivePage('article-index');
                if(document.body.scrollTop === 0) {
                    setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $(".article-index").offset().top - 70
                    }, 100);
                }, 1000)
                }
            }

            sameDiv();
        });

        function ReinitSliders(page) {
            if (page == 'services') {
                $('.service-image').slick('unslick');
                $('.service-image').slick(options());
            } else if (page == 'items') {
                $('.physical-image').slick('unslick')
                $('.physical-image').slick(options());
            } 
        }
        

        function ActivePage(page) {
            $('.page').removeClass('active');
            $('.tab').removeClass('active');
            $('.'+page).addClass('active');
            $('#'+page).addClass('active');

            ReinitSliders(page);
        }

        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            
            var url = $(this).attr('href');
            getArticles(url);
            window.history.pushState("", "", url);
        });

        function getArticles(url) {
            $.ajax({
                url:url
            }).done(function (data){
                $('.article-index').html(data);
            })
        }
    </script>
    @endsection
</x-app-layout>
