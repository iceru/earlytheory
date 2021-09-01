<x-app-layout>
    @section('title')
        My Orders
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">My Orders</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-12 col-md-9 orders-content">
                @forelse ($orders as $order)
                    <div class="row order-item">
                        <div class="order-header ">
                            <div class="row">
                                <div class="col-6">
                                    <h5>#{{ $order->sales_no }}</h5>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-end">IDR {{ $order->total_price }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="order-products mb-2 mb-lg-4 col-12">
                            @foreach ($order->products as $product)
                                <div class="product-item">
                                   <div class="row">
                                        <div class="col-3 product-image">
                                            @foreach ((array)json_decode($product->image) as $image)
                                            <img src="{{Storage::url('product-image/'.$image)}}" alt="">
                                            @endforeach
                                        </div>
                                        <div class="col-9">
                                            <div class="d-block d-lg-flex align-items-start justify-content-between">
                                                <h4 class="skylar primary-color mb-1">{{ $product->title }}</h4>
                                                <p class="mb-1 mb-lg-0">Quantity: {{$product->pivot->qty}}</p>
                                            </div>
                                            <p class="mb-1 mb-lg-2">IDR {{ $product->price }}</p>
                                            <div class="d-none d-lg-block">
                                                <p >{{$product->description_short}}</p>
                                                @if ($product->pivot->question != '')
                                                <h6>Question: </h6>
                                                <p>{{$product->pivot->question}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 d-block d-lg-none">
                                            <p class="mb-2">{{$product->description_short}}</p>
                                            @if ($product->pivot->question != '')
                                            <h6>Question: </h6>
                                            <p>{{$product->pivot->question}}</p>
                                            @endif
                                        </div>
                                   </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <a href="{{ route('user.order-detail', $order->id) }}" class="button primary me-3" style="display: inline-flex">Order Detail</a>
                                @if ($order->payment == '')
                                    <a href="" class="button secondary" style="display: inline-flex">Confirm Payment</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <h5>There is no orders</h5>
                @endforelse
                
            </div>
        </div>

    </div>
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
</x-app-layout>