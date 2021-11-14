<x-app-layout>
    @section('title')
        Summary - {{$sales->sales_no}}
    @endsection
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Summary</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle active"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>
            @if ($sales->address_id)
            <div class="col-12">
                <div class=" mb-3 pb-2 border-bottom border-dark">
                    <h5 class="evogria">Alamat Pengiriman</h5>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-6 mb-3">
                        <b>Alamat:</b> <br>
                        {{ $sales->shippingAddress->ship_address }}
                    </div>
                    <div class="col-6 mb-3">
                        <b>Kota:</b> <br>
                        {{ $sales->shippingAddress->city }}
                    </div>
                    <div class="col-6 mb-3">
                        <b>Provinsi:</b> <br>
                        {{ $sales->shippingAddress->province }}
                    </div>
                    <div class="col-6 mb-3">
                        <b>Kode Pos:</b> <br>
                        {{ $sales->shippingAddress->ship_zip }}
                    </div>
                    <div class="col-6">
                        <b>Metode Pengiriman:</b> <br>
                        {{ $sales->ship_method }}
                    </div>
                    <div class="col-12">
                        <a class="btn button primary inline btn-sm mt-3 mt-lg-2" href="/checkout/{{$sales->sales_no}}/detail">
                            <span><i class="fas fa-edit"></i> &nbsp;</span> Edit
                        </a>
                    </div>
                </div>
            </div>
            @endif
            <div class="products col-12">
                <div class="row">
                    @foreach ($sales->skus as $item)
                    <div class="col-12 col-lg-6">
                        <div class="row product-item-container">
                            <div class="product-title col-12">
                                <h3>{{$item->products->title}}</h3>
                            </div>
                            <div class="product-price col-12">
                                <p>idr {{number_format($item->price)}}</p>
                            </div>
                            <div class="col-5 col-lg-3 product-image">
                                @foreach ((array)json_decode($item->products->image) as $image)
                                <div class="ratio ratio-1x1">
                                    <img src="{{Storage::url('product-image/'.$image)}}" alt="No Image">
                                </div>
                                @endforeach
                            </div>
                            <div class="col-7 col-lg-9 product-question"  >
                                @if($item->variants)
                                    <div>
                                        <p class="me-2">Variants: </p>
                                            @foreach ($item->variants as $variant)
                                                <span class="variant-item me-2">{{ $variant }}</span>
                                            @endforeach
                                    </div>
                                @endif
                                <div @if ($item->products->question != 'yes' || $item->products->category == 'product') hidden @endif>
                                    <h5>Pertanyaan</h5>
                                    <p>{{nl2br($item->pivot->question)}}</p>
                                    <button class="button primary mt-3 mt-lg-2">
                                        <span><i class="fas fa-edit"></i> &nbsp;</span>
                                        <a class="white-color" href="/checkout/{{$sales->sales_no}}/detail"><span>
                                            Edit</span></a>
                                    </button>
                                </div>

                                <div @if (strtolower($item->products->title) != 'mencari jodoh') hidden @endif>
                                    <h5>Preferensi Gender</h5>
                                    <p>{{(ucfirst($item->pivot->question))}}</p>
                                    <button class="button primary mt-3 mt-lg-2">
                                        <span><i class="fas fa-edit"></i> &nbsp;</span>
                                        <a class="white-color" href="/checkout/{{$sales->sales_no}}/detail"><span>
                                            Edit</span></a>
                                    </button>
                                </div>
                                @if (($item->question != 'yes' && strtolower($item->products->title) != 'mencari jodoh') || $item->products->category == 'product')
                                    <p>{!! $item->description_short !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @foreach ($sales->products as $item)
                    <div class="col-12 col-lg-6">
                        <div class="row product-item-container">
                            <div class="product-title col-12">
                                <h3>{{$item->title}}</h3>
                            </div>
                            <div class="product-price col-12">
                                <p>idr {{number_format($item->price)}}</p>
                            </div>
                            <div class="col-5 col-lg-3 product-image">
                                @foreach ((array)json_decode($item->image) as $image)
                                <div class="ratio ratio-1x1">
                                    <img src="{{Storage::url('product-image/'.$image)}}" alt="No Image">
                                </div>
                                @endforeach
                            </div>
                            <div class="col-7 col-lg-9 product-question"  >
                                <div @if ($item->question != 'yes' || $item->category == 'product') hidden @endif>
                                    <h5>Pertanyaan</h5>
                                    <p>{{nl2br($item->pivot->question)}}</p>
                                    <button class="button primary mt-3 mt-lg-2">
                                        <span><i class="fas fa-edit"></i> &nbsp;</span>
                                        <a class="white-color" href="/checkout/{{$sales->sales_no}}/detail"><span>
                                            Edit</span></a>
                                    </button>
                                </div>

                                <div @if (strtolower($item->title) != 'mencari jodoh') hidden @endif>
                                    <h5>Preferensi Gender</h5>
                                    <p>{{(ucfirst($item->pivot->question))}}</p>
                                    <button class="button primary mt-3 mt-lg-2">
                                        <span><i class="fas fa-edit"></i> &nbsp;</span>
                                        <a class="white-color" href="/checkout/{{$sales->sales_no}}/detail"><span>
                                            Edit</span></a>
                                    </button>
                                </div>
                                @if (($item->question != 'yes' && strtolower($item->title) != 'mencari jodoh') || $item->category == 'product')
                                    <p>{!! $item->description_short !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <form action="/checkout/{{$sales->sales_no}}/discount" method="post">
                        @csrf
                        <div class="col-12">
                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            <input type="text" class="form-control mb-3" placeholder="Discount Code" name="inputDiscount">
                        </div>
                        <div class="col-12 d-grid gap-2">
                            <button type="submit" class="button secondary">Lanjut ke Pembayaran</button>
                            {{-- <a class="button secondary" href="/checkout/{{$sales->id}}/payment">
                                Go to Payment
                            </a> --}}
                        </div>
                    </form>
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
