<x-app-layout>
    @section('title')
        Riwayat Pemesanan
    @endsection

    <div class="container account__wrapper">
        <div class="order__wrapper">
            <div class="account__bread">
                <a href="{{ route('user.account') }}">Akun</a>
                <span>/</span>
                <span>Riwayat Pemesanan</span>
            </div>
            <h3 class="account__titlePage">Riwayat Pemesanan</h3>

            <section class="order__content">
                @forelse ($orders as $order)
                    <div class="row order__item">
                        <div class="order__header">
                            <div class="order__salesNo">
                                <h5><span>No:</span> {{ $order->sales_no }}</h5>
                            </div>
                            <div>
                                <h5 class="order__price">IDR {{ number_format($order->total_price, 0, '.', '.') }}</h5>
                            </div>
                        </div>
                        <div class="order__header ">
                            <div class="fw-bold">
                                @if ($order->payment == '')
                                    <p class="text-danger">Not Confirmed</p>
                                @else
                                    @if ($order->tracking_no !== null)
                                        <p class="text-success">Shipped</p>
                                        <p>Tracking Number: {{ $order->tracking_no }}</p>
                                    @else
                                        <p class="text-success">Paid</p>
                                    @endif
                                @endif
                            </div>
                            <div class="grey-color text-end">
                                <p>{{ date_format($order->created_at, 'd F Y ') }}</p>
                            </div>
                        </div>
                        <div class="order__products col-12">
                            @if ($order->created_at >= '2021-11-01')
                                @foreach ($order->skus as $item)
                                    <div class="order__productItem">
                                        <div class="row">
                                            <div class="col-3 product-image">
                                                @foreach ((array) json_decode($item->products->image) as $image)
                                                    <img src="{{ Storage::url('product-image/' . $image) }}"
                                                        alt="">
                                                @endforeach
                                            </div>
                                            <div class="col-9">
                                                <div
                                                    class="d-block d-lg-flex align-items-start justify-content-between">
                                                    <h4 class="skylar primary-color mb-1">{{ $item->products->title }}
                                                    </h4>
                                                </div>
                                                <div class="order__productInfo">
                                                    <p class="order__qty">Qty: {{ $item->pivot->qty }}</p>
                                                    <p>IDR {{ number_format($item->price, 0, '.', '.') }}</p>
                                                </div>
                                                <div class="d-none d-lg-block">
                                                    <p>{{ $item->products->description_short }}</p>
                                                    @if ($item->pivot->question != '')
                                                        <h6>Question: </h6>
                                                        <p>{{ $item->pivot->question }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 d-block d-lg-none">
                                                <p class="mb-2">{{ $item->products->description_short }}</p>
                                                @if ($item->pivot->question != '')
                                                    <h6>Question: </h6>
                                                    <p>{{ $item->pivot->question }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($order->products as $product)
                                    <div class="order__productItem">
                                        <div class="row">
                                            <div class="col-3 product-image">
                                                @foreach ((array) json_decode($product->image) as $image)
                                                    <img src="{{ Storage::url('product-image/' . $image) }}"
                                                        alt="">
                                                @endforeach
                                            </div>
                                            <div class="col-9">
                                                <div
                                                    class="d-block d-lg-flex align-items-start justify-content-between">
                                                    <h4 class="skylar primary-color mb-1">{{ $product->title }}</h4>
                                                </div>
                                                <div class="order__productInfo">
                                                    <p class="order__qty">Qty: {{ $product->pivot->qty }}</p>
                                                    <p>IDR
                                                        {{ number_format($product->price, 0, '.', '.') }}</p>
                                                </div>
                                                <div class="d-none d-lg-block mt-2">
                                                    <p>{{ $product->description_short }}</p>
                                                    @if ($product->pivot->question != '')
                                                        <h6 class="fw-bold">Question: </h6>
                                                        <p>{{ $product->pivot->question }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 d-block d-lg-none mt-2">
                                                <p class="mb-2">{{ $product->description_short }}</p>
                                                @if ($product->pivot->question != '')
                                                    <h6 class="fw-bold">Question: </h6>
                                                    <p>{{ $product->pivot->question }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($order->products as $product)
                                    <div class="order__productItem">
                                        <div class="row">
                                            <div class="col-3 product-image">
                                                @foreach ((array) json_decode($product->image) as $image)
                                                    <img src="{{ Storage::url('product-image/' . $image) }}"
                                                        alt="">
                                                @endforeach
                                            </div>
                                            <div class="col-9">
                                                <div
                                                    class="d-block d-lg-flex align-items-start justify-content-between">
                                                    <h4 class="skylar primary-color mb-1">{{ $product->title }}</h4>
                                                </div>
                                                <div class="order__productInfo">
                                                    <p class="order__qty">Qty: {{ $product->pivot->qty }}</p>
                                                    <p>IDR {{ $product->price }}</p>
                                                </div>
                                                <div class="d-none d-lg-block mt-2">
                                                    <p>{{ $product->description_short }}</p>
                                                    @if ($product->pivot->question != '')
                                                        <h6 class="fw-bold">Question: </h6>
                                                        <p>{{ $product->pivot->question }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 d-block d-lg-none">
                                                <p class="mb-2">{{ $product->description_short }}</p>
                                                @if ($product->pivot->question != '')
                                                    <h6>Question: </h6>
                                                    <p>{{ $product->pivot->question }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if ($order->payment == '')
                            <div class="col-12 mt-2">
                                <div class="order__buttonWrapper">
                                    @foreach ($order->skus as $item)
                                        @if ($item->products->category === 'service' || $item->products->question === 'yes')
                                            <a href="{{ route('sales.detail', $order->sales_no) }}"
                                                class="button secondary "><i class="fas fa-edit me-2"></i>Edit
                                                Question</a>
                                        @break
                                    @endif
                                @endforeach
                                <a href="{{ route('user.confirm-payment', $order->sales_no) }}"
                                    class="button primary" style="display: inline-flex">Confirm Payment</a>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <h5 class="text-center">Riwayat Pemesanan Kosong</h5>
            @endforelse

        </section>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.product-image').slick({
            dots: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 5000,
        });
    });
</script>
</x-app-layout>
