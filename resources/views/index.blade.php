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
        <div class="tab active" id="products" onclick="ActivePage('products')">
            <h4>Produk</h4>
        </div>
        <div class="tab" id="birth-chart" onclick="ActivePage('birth-chart')">
            <h4>Birth Chart</h4>
        </div>
        <div class="tab" id="articles" onclick="ActivePage('articles')">
            <h4>Artikel</h4>
        </div>
    </div>
    <div class="col-12 index">
        <div class="products row mt-3 page active" >
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
                    <div data-id="{{$product->id}}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                </div>
            @empty
                <h4 class="evogria">No Product</h4>
            @endforelse

            <hr>

            @forelse ($products as $product)
            <div class="product-item-container col-6 col-md-4 col-lg-3 mt-4">
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
                <div data-id="{{$product->id}}" class="button primary my-3 addcart">PESAN SEKARANG</div>
            </div>
            @empty
                <h4 class="evogria">No Product</h4>
            @endforelse
        </div>
        <div class="birth-chart row mt-3 page">
            @include('horoscope-index')
        </div>

        <div class="articles page mt-3">
            @include('article-index')
        </div>
    </div>


    @section('js')
    <script>
        function checkSku() {
            var skus = {!! $skus !!};
            $.each($('.addcart'), function (index, item) {
                Object.keys(skus).forEach(function(element) {
                    if (skus[element].product_id == $(item).attr('data-id')) {
                        $(item).attr('data-price', skus[element].price);
                        $(item).attr('data-sku', skus[element].id);
                        $(item).attr('data-values',  skus[element].values);
                        // $(item).attr('data-values', element.values);
                    } 
                });
                if(!$(item).attr('data-price')) {
                    $(item).removeClass('primary');
                    $(item).removeClass('addcart');
                    $(item).removeAttr('data-id');
                    $(item).addClass('disabled');
                    $(item).text('STOK HABIS');
                    $(item).attr('disabled', true);
                    $(item).parent().insertAfter($('.product-item-container').last());
                }
            });
        }
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

            if (maxHeight > 0) {
                $(".product-item").height(maxHeight);
            }
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
            
            checkSku();
            // setTimeout(() => {
            //     if(window.location.pathname === '/')
            //         ActivePage('products');
            //     else
            //         ActivePage(page);
            // }, 1000);
            window.history.pushState({page: 'products'}, "", '/');

            if(window.location.pathname == '/birth-chart') {
                ActivePage('birth-chart');
            }
            
            if(window.location.pathname == '/articles') {
                ActivePage('articles');
            }

            sameDiv();
        });

        function ReinitSliders(page) {
            if (page == 'products') {
                $('.service-image').slick('unslick');
                $('.service-image').slick(options());
            } else if (page == 'birth-chart') {
                $('.physical-image').slick('unslick')
                $('.physical-image').slick(options());
            } 
        }
        

        const pagestate = window.location.pathname.slice(1);

        function ActivePage(page) {
            $('.page').removeClass('active');
            $('.tab').removeClass('active');
            $('.'+page).addClass('active');
            $('#'+page).addClass('active');
            window.history.pushState({article: '', page: pagestate}, "", '/'+page);
            if(page === 'articles') {
                getArticles(window.location.origin+window.location.pathname)
            }
            // checkSku();
            ReinitSliders(page);
        }

        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getArticles(url);
        });

        function getArticles(url) {
            $.ajax({
                url:url
            }).done(function (data){
                $('.articles').html(data);
                const urlParse = new URL(url);
                history.pushState({article: url, page: pagestate}, "", urlParse.pathname + urlParse.search)
            })
        }

        window.onpopstate = function(e) {
            const data = e.state.article;
            const page = e.state.page;

            dataUrl = new URL(data);

            if((data || !dataUrl.search) && pagestate === 'articles')
                ActivePage(page)
            else
                getArticles(data);
        }
    </script>
    @endsection
</x-app-layout>
