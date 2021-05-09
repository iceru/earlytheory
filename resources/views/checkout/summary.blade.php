<x-app-layout>
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
            <div class="products col-12">
                <div class="row">
                    @foreach ($sales->products as $item)
                    <div class="product-item-container col-12 col-lg-6">
                        <div class="row">
                            <div class="product-title col-12">
                                <h3>{{$item->title}}</h3>
                            </div>
                            <div class="product-price col-12">
                                <p>idr {{number_format($item->price)}}</p>
                            </div>
                            <div class="col-5 col-lg-3 product-image">
                                <img src="{{Storage::url('product-image/'.$item->image)}}" alt="">
                            </div>
                            <div class="col-7 col-lg-9 ps-0 product-question">
                                <h5>Pertanyaan</h5>
                                <p>{{nl2br($item->pivot->question)}}</p>
                                <button class="button primary mt-3 mt-lg-2">
                                    <span><i class="fas fa-edit"></i> &nbsp;</span>
                                    <a href="/checkout/{{$sales->id}}/detail"><span>
                                        Edit</span></a>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <form action="/checkout/{{$sales->id}}/discount" method="post">
                    @csrf
                    <div class="col-12">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <input type="text" class="form-control mb-2" placeholder="Discount Code" name="inputDiscount">
                    </div>
                    <div class="col-12 d-grid gap-2">
                        <button type="submit" class="button secondary">Go to Payment</button>
                        {{-- <a class="button secondary" href="/checkout/{{$sales->id}}/payment">
                            Go to Payment
                        </a> --}}
                    </div>
                </form>
            </div>
        </div>
</x-app-layout>
