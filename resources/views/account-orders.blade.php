<x-app-layout>
    @section('title')
        My Orders
    @endsection

    <div class="container account__wrapper">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="text-page">My Orders</h3>
            </div>

            <div class="col-12 col-md-9 orders-content">
                @forelse ($orders as $order)
                    <div class="row order-item">
                        <div class="order-header ">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <h5>#{{ $order->sales_no }}</h5>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-end">IDR {{ $order->total_price }}</h5>
                                </div>
                                <div class="col-6 fw-bold">
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
                                <div class="col-6 grey-color  text-end ">
                                    <p>{{ date_format($order->created_at, 'd F Y ') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-products col-12">
                            {{-- cek created_at order sebelum perubahan dari products ke skus --}}
                            @if ($order->created_at >= '2021-11-01')
                                @foreach ($order->skus as $item)
                                    <div class="product-item">
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
                                                    <p class="mb-1 mb-lg-0">Quantity: {{ $item->pivot->qty }}</p>
                                                </div>
                                                <p class="mb-1 mb-lg-2">IDR {{ $item->price }}</p>
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
                                    <div class="product-item">
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
                                                    <p class="mb-1 mb-lg-0">Quantity: {{ $product->pivot->qty }}</p>
                                                </div>
                                                <p class="mb-1 mb-lg-2">IDR {{ $product->price }}</p>
                                                <div class="d-none d-lg-block">
                                                    <p>{{ $product->description_short }}</p>
                                                    @if ($product->pivot->question != '')
                                                        <h6>Question: </h6>
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
                            @else
                                @foreach ($order->products as $product)
                                    <div class="product-item">
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
                                                    <p class="mb-1 mb-lg-0">Quantity: {{ $product->pivot->qty }}</p>
                                                </div>
                                                <p class="mb-1 mb-lg-2">IDR {{ $product->price }}</p>
                                                <div class="d-none d-lg-block">
                                                    <p>{{ $product->description_short }}</p>
                                                    @if ($product->pivot->question != '')
                                                        <h6>Question: </h6>
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
                            <div class="col-12 mt-2 mt-lg-4">
                                <div class="d-flex">
                                    @foreach ($order->skus as $item)
                                        @if ($item->products->category === 'service' || $item->products->question === 'yes')
                                            <a href="{{ route('sales.detail', $order->sales_no) }}"
                                                class="button secondary me-2"><i class="fas fa-edit me-2"></i>Edit
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
                <h5>There is no orders</h5>
            @endforelse

        </div>
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
