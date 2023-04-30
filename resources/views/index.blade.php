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
                            <img src="{{ Storage::url('sliders-image/' . $slider->image) }}" alt="">
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- <div class="page-tabs">
        <div class="tab active" id="products" onclick="ActivePage('products')">
            <h4>Tarot</h4>
        </div>
        <div class="tab" id="astrologi" onclick="ActivePage('astrologi')">
            <h4>Astrologi</h4>
        </div>
        <div class="tab" id="spiritual" onclick="ActivePage('spiritual')">
            <h4>Spiritual</h4>
        </div>
    </div> --}}
    <div class="page-tabs">
        <a href="#products" class="tab active" id="productsTab">
            <h4>Tarot</h4>
        </a>
        <a href="#astrologi" class="tab" id="astrologiTab">
            <h4>Astrologi</h4>
        </a>
        <a href="#spiritual" class="tab" id="spiritualTab">
            <h4>Spiritual</h4>
        </a>
    </div>

    <div class="popupPage" id="popup">
        <a href="https://shopee.co.id/tokomejik?smtt=0.775443230-1656594335.9" class="popup-img">
            <div class="close" id="closePopup"> <i class="fas fa-times" aria-hidden="true"></i></div>
            <div class="ratio">
                <img src="/images/banner-shopee.png" alt="">
            </div>
        </a>
    </div>
    <div class="col-12 index">
        <div class="products mt-3 page active" id="products">
            <div class="title">
                Tarot
            </div>
            <div class="row">
                @forelse ($services as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image service-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        {{-- <div class="sale">
                            <img src="/images/PROMOSTAR.png" alt="Promo">
                        </div>
                        @if ($product->discount_price)
                            <div class="sale active">
                                <img src="/images/PROMOSTAR.png" alt="Promo">
                            </div>
                        @endif --}}
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
        <div class="astrologi mt-3 page active" id="astrologi">
            <div class="title">
                Astrologi
            </div>
            <div class="row products">
                @forelse ($astrologi as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image astrologi-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        {{-- <div class="sale">
                            <img src="/images/PROMOSTAR.png" alt="Promo">
                        </div>
                        @if ($product->discount_price)
                            <div class="sale active">
                                <img src="/images/PROMOSTAR.png" alt="Promo">
                            </div>
                        @endif --}}
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
        <div class="spiritual mt-3 page active" id="spiritual">
            <div class="title">
                Spiritual
            </div>
            <div class="row products">
                @forelse ($spiritual as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3">
                        <div class="product-image spiritual-image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        {{-- <div class="sale">
                            <img src="/images/PROMOSTAR.png" alt="Promo">
                        </div>
                        @if ($product->discount_price)
                            <div class="sale active">
                                <img src="/images/PROMOSTAR.png" alt="Promo">
                            </div>
                        @endif --}}
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>
                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
    </div>
    {{-- <div class="birth-chart row mt-3 page">
            @include('horoscope-index')
        </div> --}}

    {{-- <div class="kristal page mt-3">
            @include('article-index')
            <div class="row products">
                <div class="col-12 products-title d-flex">
                    Gelang Kristal by <img src="/images/Logo-tokomejik.png" alt="Toko Mejik">
                </div>
                @forelse ($products as $product)
                    <div class="product-item-container col-6 col-md-4 col-lg-3 mt-4">
                        <div class="product-image physical-image" id="product_image">
                            @foreach ((array) json_decode($product->image) as $item)
                                <a href="/product/{{ $product->slug }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ Storage::url('product-image/' . $item) }}" loading="lazy"
                                            alt="{{ $product->title }}">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="sale">
                            <img src="/images/PROMOSTAR.png" alt="Promo">
                        </div>
                        @if ($product->discount_price)
                            <div class="sale active">
                                <img src="/images/PROMOSTAR.png" alt="Promo">
                            </div>
                        @endif
                        <div class="product-item">
                            <div class="product-title">
                                <a href="/product/{{ $product->slug }}">
                                    <h3>{{ $product->title }}</h3>
                                </a>
                            </div>
                            @if (!$product->discount_price)
                                <div class="prices skus">
                                    <p class="product-price mb-0">idr {{ number_format($product->price) }}
                                    </p>

                                </div>
                            @else
                                <div class="prices">
                                    <p class="product-price discount mb-0">idr
                                        {{ number_format($product->discount_price) }}
                                    </p>
                                    <span class="striked">idr {{ number_format($product->base_price) }}</span>
                                </div>
                            @endif
                            @if ($product->duration > 0)
                                <p class="duration">
                                    {{ $product->duration }} menit
                                </p>
                            @endif
                            <div class="product-desc">{{ $product->description_short }}</div>
                        </div>
                        <div data-id="{{ $product->id }}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                    </div>
                @empty
                    <h4 class="evogria">No Product</h4>
                @endforelse
            </div>
        </div>
    </div> --}}

    @section('js')
        <script>
            function checkSku() {
                var skus = {!! $skus !!};
                $.each($('.addcart'), function(index, item) {
                    Object.keys(skus).forEach(function(element) {
                        if (skus[element].product_id == $(item).attr('data-id')) {
                            $(item).attr('data-price', skus[element].price);
                            $(item).attr('data-sku', skus[element].id);
                            $(item).attr('data-values', skus[element].values);
                            $(item).siblings('.product-item').children('.prices.skus').children(
                                '.product-price').text('idr ' + (
                                skus[element].price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                            if (skus[element].base_price) {
                                $(item).siblings('.product-item').children('.prices.skus').children(
                                    '.product-price').addClass('discount')
                                $(item).siblings('.product-item').children('.prices.skus').append(
                                    `<span class="striked">idr ${skus[element].base_price}</span>`);
                                $(item).siblings('.sale').addClass('active');
                            }
                            // $(item).attr('data-values', element.values);
                        }
                    });
                    if (!$(item).attr('data-price')) {
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

            $(window).scroll(function() {
                ;
                w = Math.floor($(window).scrollTop());
                $('.tab').removeClass('active');
                if (w <= $('#products').offset().top) {
                    $('#productsTab').addClass('active');
                } else if (w <= $('#astrologi').offset().top) {
                    $('#astrologiTab').addClass('active');
                } else if (w <= $('#spiritual').offset().top) {
                    $('#spiritualTab').addClass('active');
                }

            });


            function options() {
                return {
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                }
            }
            $(document).ready(function() {
                if (sessionStorage && !sessionStorage.getItem('popupShow')) {
                    $('#popup').addClass('active');
                    sessionStorage.setItem('popupShow', true);
                }

                $('#closePopup').click(function(e) {
                    e.preventDefault();
                    $('#popup').removeClass('active');
                });

                $('.sliders-index').slick({
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                });
                $('.service-image').slick(options());
                $('.astrologi-image').slick(options());
                $('.spiritual-image').slick(options());

                checkSku();
                // setTimeout(() => {
                //     if(window.location.pathname === '/')
                //         ActivePage('products');
                //     else
                //         ActivePage(page);
                // }, 1000);
                // window.history.pushState({
                //     page: 'products'
                // }, "", '/');

                // if (window.location.pathname == '/birth-chart') {
                //     ActivePage('birth-chart');
                // }

                // if (window.location.pathname == '/kristal') {
                //     ActivePage('kristal');
                // }

                // if (window.location.pathname == '/articles') {
                //     ActivePage('articles');
                // }

                sameDiv();
            });

            function ReinitSliders(page) {
                if (page == 'products') {
                    $('.service-image').slick('unslick');
                    $('.service-image').slick(options());
                } else if (page == 'astrologi') {
                    $('.astrologi-image').slick('unslick')
                    $('.astrologi-image').slick(options());
                } else if (page == 'spiritual') {
                    $('.spiritual-image').slick('unslick')
                    $('.spiritual-image').slick(options());
                }
            }


            const pagestate = window.location.pathname.slice(1);

            function ActivePage(page) {
                $('.page').removeClass('active');
                $('.tab').removeClass('active');
                $('.' + page).addClass('active');
                $('#' + page).addClass('active');
                // window.history.pushState({
                //     article: '',
                //     page: pagestate
                // }, "", '/' + page);
                // if (page === 'articles') {
                //     getArticles(window.location.origin + window.location.pathname)
                // }
                // checkSku();
                ReinitSliders(page);
            }

            // $('body').on('click', '.pagination a', function(e) {
            //     e.preventDefault();
            //     var url = $(this).attr('href');
            //     getArticles(url);
            // });

            // function getArticles(url) {
            //     $.ajax({
            //         url: url
            //     }).done(function(data) {
            //         $('.articles').html(data);
            //         const urlParse = new URL(url);
            //         history.pushState({
            //             article: url,
            //             page: pagestate
            //         }, "", urlParse.pathname + urlParse.search)
            //     })
            // }

            // window.onpopstate = function(e) {
            //     const data = e.state.article;
            //     const page = e.state.page;

            //     dataUrl = new URL(data);

            //     if ((data || !dataUrl.search) && pagestate === 'articles')
            //         ActivePage(page)
            //     else
            //         getArticles(data);
            // }
        </script>
    @endsection
</x-app-layout>
