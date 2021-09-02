<x-app-layout>
    @section('title')
        Cart
    @endsection
    <div class="col-12 cart main-content">
        <div class="row">
            <div class="col-12 title-page text-center primary-color">
                <h1>MY CART</h1>
            </div>
            <div class="col-12">
                <div class="d-flex mb-3">
                    <a href="/cart/clear" class="button primary align-items-center">
                        <span class="me-2 ">Remove All</span> <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6 product-cart ">

                <div class="products">
                    @forelse ($items as $item)
                        <div class="product-item-container row m-0">
                            <div class="col-4 col-lg-3 product-image">
                                @foreach ((array)json_decode($item->model->image) as $image)
                                    <div class="ratio ratio-1x1">
                                        <img src="{{Storage::url('product-image/'.$image)}}" alt="{{ $item->title }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-8 col-lg-9 product-item">
                                <div class="product-title"><h3>{{$item->model->title}}</h3></div>
                                <p class="product-price">idr {{number_format($item->model->price)}}</p>
                                <div class="qty-spinner d-flex">
                                    <div class="min-button">
                                        @if ($item->quantity > 1)
                                        <a href="/cart/min/{{$item->id}}" style="color: inherit;"><i class="fas fa-minus-circle"></i></a>
                                        @elseif ($item->quantity == 1)
                                        <a href="/cart/remove/{{$item->id}}" style="color: inherit;"><i class="fas fa-minus-circle"></i></a>
                                        @endif
                                    </div>
                                    <div class="qty">{{$item->quantity}}</div>
                                    <div class="plus-button">
                                        <a href="/cart/plus/{{$item->id}}" style="color: inherit;"><i class="fas fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Item</p>
                    @endforelse
                </div>
            </div>

            <div class="col-12 col-lg-6 cart-summary">
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
