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
                    <div class="button disabled my-3" disabled>Out of Stock</div>
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
        var option_values = []
        var id = $('.product .addcart').attr('data-id');
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
                // $('.variants').find('.values').find('.value:first-child').addClass('selected');

                // selectValue();
            }
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
            getSku();
        }

        function getSku() {
            $.ajax({
                type: "POST",
                url: "/get-sku",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'option_values': option_values, 'id': id },
                success: function (response) {
                    var data = response;
                    $('.product .addcart').attr('data-price', data.price);
                    $('.product .addcart').attr('data-sku', data.id);
                    $('.product .addcart').attr('data-values', data.values);
                    var price_data = 'idr '+(data.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    var price_text = price_data.substring(0, price_data.length-3);
                    $('.product-price p').text(price_text);
                    $('.product .addcart').addClass('primary');
                    $('.product .addcart').removeClass('disabled');
                },
                error: function(response) {
                    alert(response.responseJSON.message);
                    // $('.value').removeClass('selected');
                    $('.product .addcart').removeClass('primary');
                    $('.product .addcart').addClass('disabled');

                    // $('.variants').find('.values').find('.value:first-child').addClass('selected');
                    // selectValue();
                }
            });
        }
    </script>
    @endsection
</x-app-layout>
