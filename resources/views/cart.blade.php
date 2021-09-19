<x-app-layout>
    @section('title')
        Cart
    @endsection
    <div class="col-12 cart main-content">
        <div class="row">
            <div class="col-12 mb-5 evogria">
                <h2>MY CART</h2>
            </div>
            {{-- <div class="col-12">
                <div class="d-flex mb-3">
                    <a href="/cart/clear" class="button primary align-items-center" onclick="return confirm('Are you sure you want to delete all the items?');">
                        <span class="me-2 ">Remove All</span> <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div> --}}
            <div class="col-12 col-lg-8 product-cart ">
                <div class="products">
                    <div class="row mb-3 products-header">
                        <div class="col-8 col-lg-6">
                            <h5 class="grey-color">Product</h5>
                        </div>
                        <div class="col-3 qty-row">
                            <h5 class="grey-color">Qty</h5>
                        </div>
                        <div class="col-3 col-lg-2">
                            <h5 class="grey-color">Total</h5>
                        </div>
                    </div>
                    
                    @forelse ($items as $item)
                    <div class="row product-item mb-3">
                        <div class="col-8 col-lg-6 ">
                            <div class="row">
                                <div class="col-4 product-image">
                                    @foreach ((array)json_decode($item->model->image) as $image)
                                        <div class="ratio ratio-1x1">
                                            <img src="{{Storage::url('product-image/'.$image)}}" alt="{{ $item->title }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-8">
                                    <div class="product-title"><h3>{{$item->model->title}}</h3></div>
                                    <p class="product-price mb-2 mb-lg-0">idr {{number_format($item->model->price)}}</p>

                                    <div class="qty-mobile">
                                        <div class="qty-spinner d-flex">
                                            <div class="min-button">
                                                @if ($item->quantity > 1)
                                                <a href="/cart/min/{{$item->id}}" style="color: inherit;"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                @elseif ($item->quantity == 1)
                                                <a href="/cart/remove/{{$item->id}}" style="color: inherit;"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                @endif
                                            </div>
                                            <div class="qty">{{$item->quantity}}</div>
                                            <div class="plus-button">
                                                <a href="/cart/plus/{{$item->id}}" style="color: inherit;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 qty-row">
                            <div class="qty-spinner d-flex">
                                <div class="min-button">
                                    @if ($item->quantity > 1)
                                    <a href="/cart/min/{{$item->id}}" style="color: inherit;"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                    @elseif ($item->quantity == 1)
                                    <a href="/cart/remove/{{$item->id}}" style="color: inherit;"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="qty">{{$item->quantity}}</div>
                                <div class="plus-button">
                                    <a href="/cart/plus/{{$item->id}}" style="color: inherit;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-lg-2 product-total">
                            <h5 class="primary-color">idr {{ number_format($item->model->price * $item->quantity) }}</h5>
                        </div>
                        <div class="col-1">
                            <a href="/cart/remove/{{$item->id}}" onclick="return confirm('Are you sure you want to delete the item?');">
                                <i class="fa fa-trash primary-color" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                        <p class="my-3">No Item</p>
                    @endforelse
                </div>
            </div>

            <div class="col-12 col-lg-4 cart-summary">
                <div class="total-price">
                    <h5>
                       <span class="text">Total</span> <br>
                       <span class="price">idr {{number_format($total)}}</span>
                    </h5>
                </div>
                <div class="checkout-btn">
                    @if (\Cart::isEmpty())
                        {{-- <a href="#" class="button primary disabled" aria-disabled="true">Checkout</a> --}}
                        <a href="#" class="btn btn-disabled btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Checkout</a>
                    @else
                        <a href="/checkout" class="button primary">Checkout</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script>

        $(document).ready(function(){

            $('.product-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
            });
        });
    </script>
    @endsection
</x-app-layout>
