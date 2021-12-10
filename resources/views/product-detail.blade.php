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
                @foreach ($values as $items)
                <div class="variants mb-3">
                    <p class="mb-2 skylar">{{ $items['option'] }}</p>

                    <div class="values d-flex">
                        @foreach ($items->slice(0, $items->count() - 1) as $item)
                            <div class="value button primary-line hollow me-2" data-option="{{ $item->option_id }}" id={{ $item->id }}>
                                {{ $item->value_name }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                <div class="product-desc mt-4 mb-3">
                    {!! $product->description !!}
                </div>
                <div class="add-to-cart">
                    <div class="button primary my-3 addcart">Add To Cart</div>
                </div>
            </div>
        </div>
        <div class="other-products">
            <h3 class="evogria other-title">Other Products</h3>
            <div class="row products">
                @foreach ($related as $product_related)
                <div class="product-item-container col-6 col-md-3">
                    <div class="product-images related mb-3">
                        @foreach ((array)json_decode($product_related->image) as $item)
                            <a href="/product/{{$product_related->slug}}">
                                <div class="ratio ratio-1x1">
                                    <img src="{{Storage::url('product-image/'.$item)}}" loading="lazy" alt="{{ $product_related->title }}">
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="product-item">
                        <div class="product-title">
                            <a href="/product/{{$product_related->slug}}">
                                <h3>{{$product_related->title}}</h3>
                            </a>
                        </div>
                        <p class="product-price">idr {{number_format($product_related->price)}}</p>
                        <p class="product-desc">{{$product_related->description_short}}</p>
                    </div>
                    <div data-id="{{$product_related->id}}" class="button primary my-3 addcart addcart-related">Add To Cart</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('js')
    <script>
        var option_values = []
        var id = {!! $product->id !!};
        var price = {{ $product->price }}

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
            if($('.variants').length > 0) {
                $('.product .addcart').toggleClass('primary disabled');
                $('.product .addcart').attr('disable', true);
                // $('.variants').find('.values').find('.value:first-child').addClass('selected');

                // selectValue();
            } else {
                getSku('non-variants');
            }

            var skus = {!! $skus !!};
            $.each($('.addcart-related'), function (index, item) {
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
        });

        $('.value').click(function (e) { 
            e.preventDefault();
            if($(this).siblings('.selected')) {
                $(this).closest('.values').children().removeClass('selected');
            }
            $(this).addClass('selected');
            if ($('.variants').length == 1) {
                selectValue();
            } else if ($('.variants').length > 1 && $('.values').find('.selected').length == $('.values').length ) {
                selectValue();
            }
        });
 
        function selectValue() {
            option_values = [];
            $('.value.selected').each(function(item) {
                data_options = {
                    "option": $(this).attr('data-option'),
                    "value": $(this).attr('id'),
                    "product_id": id
                }

                option_values.push(data_options);
            })
            getSku('variants');
        }

        function getSku(variants) {
            $.ajax({
                type: "POST",
                url: "/get-sku",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'option_values': option_values, 'id': id, variants: variants },
                success: function (response) {
                    var data = response;
                    if(data.stock > 0){
                        $('.product .addcart').attr('data-price', data.price);
                        $('.product .addcart').attr('data-sku', data.id);
                        $('.product .addcart').attr('data-values', data.values);
                        $('.product .addcart').attr('data-id', data.product_id);
                        $('.product .addcart').attr('data-stock', data.stock);
                        var price_data = 'idr '+(data.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        var price_text = price_data.substring(0, price_data.length-3);
                        $('.product-price p').text(price_text);
                        $('.product .addcart').addClass('primary');
                        $('.product .addcart').addClass('addcart');
                        $('.product .addcart').removeClass('disabled');
                    } else {
                        $('.product .addcart').attr('disabled', 'disabled');
                        $('.product .addcart').removeClass('primary');
                        $('.product .addcart').addClass('disabled');
                        $('.product .addcart').text('Stok Habis');
                        $('.product .addcart').removeAttr('data-id');
                    }
                },
                error: function(response) {
                    alert(response.responseJSON.message);
                    // $('.value').removeClass('selected');
                    $('.product .addcart').removeClass('primary');
                    $('.product .addcart').addClass('disabled');
                    $('.product .addcart').removeClass('addcart');
                    $('.product .addcart').text('Stok Habis');
                    $('.product .addcart').attr('disabled', true);
                    // $('.variants').find('.values').find('.value:first-child').addClass('selected');
                    // selectValue();
                }
            });
        }
    </script>
    @endsection
</x-app-layout>
