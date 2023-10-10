<x-app-layout>
    @section('title')
        Cart
    @endsection
    <div class="col-12 cart main-content">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Sorry !</strong> There were some problems.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="page__title">
                <div class="page__titleImage">
                    <img src="/images/Favicon.png" width="50" alt="">
                </div>
                <div class="page__titleText">
                    Keranjang
                </div>
            </div>
            {{-- <div class="col-12">
                <div class="d-flex mb-3">
                    <a href="/cart/clear" class="button primary align-items-center" onclick="return confirm('Are you sure you want to delete all the items?');">
                        <span class="me-2 ">Remove All</span> <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div> --}}
            <div class="col-12 @if (count($items) > 0) col-lg-8 @endif cart__items">
                @if (count($ramalan) > 0)
                    <div class="cart__title">
                        Ramalan
                    </div>
                    <section class="mb-5">
                        @foreach ($ramalan as $item)
                            <div class="cartItem__item mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="cartItem__image">
                                        @foreach ((array) json_decode($item->associatedModel->image) as $image)
                                            <div class="ratio ratio-1x1">
                                                <a href="/product/{{ $item->associatedModel->slug }}">
                                                    <img src="{{ Storage::url('product-image/' . $image) }}"
                                                        alt="{{ $item->title }}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="cartItem__info">
                                        <a href="/product/{{ $item->associatedModel->slug }}">
                                            <div class="product-title">
                                                <h3>{{ $item->associatedModel->title }}</h3>
                                            </div>
                                        </a>
                                        @if ($item->attributes->values)
                                            <p class="mb-1">Variant: {{ $item->attributes->values }}</p>
                                        @endif
                                        <div class="cartItem__total">idr
                                            {{ number_format($item->price * $item->quantity) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="cartItem__qty">
                                    <div class="qty-spinner d-flex">
                                        <div class="min-button">
                                            @if ($item->quantity > 1)
                                                <a href="/cart/min/{{ $item->id }}" style="color: inherit;"><i
                                                        class="fa fa-minus" aria-hidden="true"></i></a>
                                            @elseif ($item->quantity == 1)
                                                <a href="/cart/remove/{{ $item->id }}" style="color: inherit;"><i
                                                        class="fa fa-minus" aria-hidden="true"></i></a>
                                            @endif
                                        </div>
                                        <div class="qty">{{ $item->quantity }}</div>
                                        <div class="plus-button">
                                            <a href="/cart/plus/{{ $item->id }}" style="color: inherit;"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cartItem__remove">
                                    <a href="/cart/remove/{{ $item->id }}"
                                        onclick="return confirm('Are you sure you want to delete the item?');">
                                        <i class="fa fa-trash primary-color" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </section>
                @endif

                @if (count($workshops) > 0)
                    <div class="cart__title">
                        Workshop
                    </div>
                    @foreach ($workshops as $item)
                        <div class="cartItem__item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="cartItem__image">
                                    @foreach ((array) json_decode($item->associatedModel->image) as $image)
                                        <div class="ratio ratio-1x1">
                                            <a href="/product/{{ $item->associatedModel->slug }}">
                                                <img src="{{ Storage::url('product-image/' . $image) }}"
                                                    alt="{{ $item->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cartItem__info">
                                    <a href="/product/{{ $item->associatedModel->slug }}">
                                        <div class="product-title">
                                            <h3>{{ $item->associatedModel->title }}</h3>
                                        </div>
                                    </a>
                                    <div class="cartItem__total">IDR
                                        {{ number_format($item->price * $item->quantity) }}
                                    </div>
                                </div>
                            </div>
                            <div class="cartItem__qty">
                                <div class="qty-spinner d-flex">
                                    <div class="min-button">
                                        @if ($item->quantity > 1)
                                            <a href="/cart/min/{{ $item->id }}" style="color: inherit;"><i
                                                    class="fa fa-minus" aria-hidden="true"></i></a>
                                        @elseif ($item->quantity == 1)
                                            <a href="/cart/remove/{{ $item->id }}" style="color: inherit;"><i
                                                    class="fa fa-minus" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="qty">{{ $item->quantity }}</div>
                                    <div class="plus-button">
                                        <a href="/cart/plus/{{ $item->id }}" style="color: inherit;"><i
                                                class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="cartItem__remove">
                                <a href="/cart/remove/{{ $item->id }}"
                                    onclick="return confirm('Are you sure you want to delete the item?');">
                                    <i class="fa fa-trash primary-color" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if (count($items) === 0)
                    <div class="row">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <?xml version="1.0" ?><svg viewBox="0 0 24 24" class="cart-none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="cart-delete">
                                    <path
                                        d="M8,17a2,2,0,1,0,2,2A2.002,2.002,0,0,0,8,17Zm0,3a1,1,0,1,1,1-1A1.0013,1.0013,0,0,1,8,20Z" />
                                    <path
                                        d="M18,17a2,2,0,1,0,2,2A2.002,2.002,0,0,0,18,17Zm0,3a1,1,0,1,1,1-1A1.0013,1.0013,0,0,1,18,20Z" />
                                    <path
                                        d="M14.353,10.646a.5.5,0,1,1-.707.707L12.5,10.207l-1.147,1.147a.5.5,0,0,1-.707-.707L11.793,9.5,10.6465,8.3535a.5.5,0,0,1,.707-.707L12.5,8.793l1.1465-1.1465a.5.5,0,0,1,.707.707L13.207,9.5Z" />
                                    <path
                                        d="M21.7505,7.7759l-.5557,5A2.4979,2.4979,0,0,1,18.71,15H8.5A2.503,2.503,0,0,1,6,12.5v-5A1.5017,1.5017,0,0,0,4.5,6h-2a.5.5,0,0,1,0-1h2A2.503,2.503,0,0,1,7,7.5v5A1.5017,1.5017,0,0,0,8.5,14H18.71a1.4986,1.4986,0,0,0,1.4907-1.3345l.5556-5a1.5023,1.5023,0,0,0-.373-1.166A1.482,1.482,0,0,0,19.2656,6H16.5a.5.5,0,0,1,0-1h2.7656a2.5008,2.5008,0,0,1,2.4849,2.7759Z" />
                                </g>
                            </svg>
                            <h5 class="text-center mb-3">No Items</h5>
                            <a href="/" class="button primary inline m-auto">Continue Shopping</a>
                        </div>
                    </div>
                @endif
            </div>
            @if (count($items) > 0)
                <div class="col-12 col-lg-4 cart-summary">
                    <div class="total-price">
                        <h5>
                            <span class="text">Total</span> <br>
                            <span class="price">idr {{ number_format($total) }}</span>
                        </h5>
                    </div>
                    <div class="checkout-btn">
                        @if (\Cart::isEmpty())
                            {{-- <a href="#" class="button primary disabled" aria-disabled="true">Checkout</a> --}}
                            <a href="#" class="btn btn-disabled btn-lg disabled" tabindex="-1" role="button"
                                aria-disabled="true">Checkout</a>
                        @else
                            <a href="/checkout" class="button primary">Checkout</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    @section('js')
        <script>
            $(document).ready(function() {

                $('.cartItem__image').slick({
                    dots: false,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                });
            });
        </script>
    @endsection
</x-app-layout>
