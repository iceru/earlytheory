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
            <h4>Produk</h4>
        </div>
        <div class="tab" id="items" onclick="ActivePage('items')">
            <h4>Horoscope</h4>
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
                    <div data-id="{{$product->id}}" class="button primary my-3 addcart">PESAN SEKARANG</div>
                </div>
            @empty
                <h4 class="evogria">No Product</h4>
            @endforelse

            <hr>

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
                <div data-id="{{$product->id}}" class="button primary my-3 addcart">PESAN SEKARANG</div>
            </div>
            @empty
                <h4 class="evogria">No Product</h4>
            @endforelse
        </div>
        <div class="products items row mt-3 page">
            <div class="col-12 main-content">
                <div class="row input-horoscope">
                    <div class="col-12 text-center mb-5">
                        <h2 class="evogria">Horoscopes</h2>
                    </div>
                    <div class="row form-horoscopes">
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ $user ? $user->name : "" }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ $user ? $user->email : "" }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <div>
                                <label for="" class="form-label">Birth Date</label>
                                <input  type="text" class="form-control" name="birthdate" id="datepicker" placeholder="" value="{{ $user ? $user->birthdate : "" }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div>
                                <label for="" class="form-label">Birth Time</label>
                                <input  type="time" class="form-control" name="birthtime" id="birthtime" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div>
                                <label for="" class="form-label">Birth Place</label>
                                <input  type="text" class="form-control" name="birthplace" id="birthplace" placeholder="">
                            </div>
                        </div>
                        <div class="col-12" >
                            <button style="width: 100%" id="submitHoroscope" class="button primary expanded">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                Get your Chart
                            </button>
                        </div>
                    </div>
                </div>
        
                <div class="results row">
                    <div class="col-12 col-lg-5">
                        <div class="identity mb-5">
                        </div>
                        <div class="row planets">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 wheel">
                    </div>
                </div>
        
                <div class="atc row">            
                </div>
            </div>
        
            <script>
                var place;
                var birthplace;
                $(document).ready(function(){
                    $( "#datepicker" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1930:2021",
                        dateFormat: 'yy-mm-dd',
                    });
                    $('results').hide();
                    $("#birthplace").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                type: "POST",
                                url: "/horoscope/places",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                },
                                data: {"name": request.term},
                                
                                success: function (data) {
                                    console.log(data.data);
                                    var results = $.map(data.data, function (item, key) {
                                        return {
                                            label: item.name + ', ' + item.admin1_code + ', ' + item.timezone,
                                            id: item.id
                                        }
                                    })
                                    response(results.slice(0, 10));
                                },
                            });
                        },
                        focus: function(event, ui) {
                            $('#birthplace').val(ui.item.label);
                            return false;
                        },
                        select: function (event, ui) {
                            birthplace = ui.item.id
                            return false;
                        },
                        minLength: 3
                    })
                });
        
                $('#submitHoroscope').click(function (e) { 
                    e.preventDefault();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var birthdate = $('#datepicker').val();
                    var birthtime = $('#birthtime').val();
        
                    var data = {
                        "name": name,
                        "date": birthdate,
                        "time": birthtime,
                        "place_id": birthplace,
                        "email": email,
                    }
        
                    $(this).prop('disabled', true);
                    $('.spinner-border').removeAttr('hidden');
        
                    $.ajax({
                        type: "POST",
                        url: "/horoscope/natal",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: data,
                        
                        success: function (response) {
                            var obj = JSON.parse(response);
                            console.log(response);
                            // history.pushState({
                            //     horoscope: obj,
                            // }, null, `natal/${obj.intro.id}`)
                            $('.input-horoscope').hide();
                            $('.results').show();
                            $('.identity').append(`
                                <h5 class="skylar primary-color mb-1">Nama: ${obj.profile.name}</h5>
                                <p>Tempat Lahir: ${obj.profile.cityName}</p>
                                <p>Tanggal Lahir: ${obj.profile.birthdate.date.slice(0,16)}</p>
                            `);
                           
                            obj.planets.forEach(item => {
                                $(".planets").append(`
                                    <div class="col-12 col-lg-6 mb-4">
                                        <h3 class="skylar primary-color">${item.planetName}</h5>
                                        <h5 class="primary-color">House Position: ${item.housePosition}</h5>
                                        <p>${item.degrees}&#176; ${item.minutes}" ${item.seconds}'</p>
                                        <p>Sign Name: ${item.signName}</p>
                                        <p>Retrogade: ${item.retrograde}</p>
                                    </div>
                                `)
                            });
        
                            $('.wheel').append(`<img src="${obj.wheel}" class="w-100" alt="Wheel Natal Chart ${obj.profile.name}" />`);
        
                            var productid = {!! $horoscope_product->id !!}
                            $('.atc').append(`<div data-id="${productid}" class="button primary my-3 addcart">Ingin Tau Lebih Lanjut? Masukan Ke Keranjang</div>`)
                        },
                        always: function() {
                            $(this).prop('disabled', false);
                        }
                    });
                });
        
                function checkSku() {
                    var skus = {!! $skus_horoscope !!};
                    console.log(skus);
                    Object.keys(skus).forEach(function(element) {
                        $.each($('.addcart'), function (index, item) {
                            if (skus[element].product_id == $(item).attr('data-id')) {
                                $(item).attr('data-price', skus[element].price);
                                $(item).attr('data-sku', skus[element].id);
                                $(item).attr('data-values',  skus[element].values);
                                // $(item).attr('data-values', element.values);
                            }
                        });
                    });
                }
            </script>
        </div>

        <div class="article-index page mt-3">
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
            // checkSku();
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
