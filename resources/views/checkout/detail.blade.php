<x-app-layout>
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Detail</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle active"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>
            <form action="/checkout/{{$sales->sales_no}}/question/add" method="post">
                @csrf
                <div class="products col-12">
                    <div class="row">
                        @foreach ($sales->products as $item)
                        <input type="text" name="id[]" value="{{$item->id}}" hidden>
                        <div class=" col-12 col-lg-6 ">
                            <div class="product-item-container row">
                                <div class="product-title col-12">
                                    <h4>{{$item->title}}</h4>
                                </div>
                                <div class="product-price col-12">
                                    <p>idr {{number_format($item->price)}}</p>
                                </div>
                               <div class="row g-0">
                                   <h5 class="primary-color mb-3">Jabarkan Pertanyaanmu Disini</h5>
                                <div class="col-4 col-lg-3 product-image">
                                    @foreach ((array)json_decode($item->image) as $image)
                                        <img src="{{Storage::url('product-image/'.$image)}}" alt="">
                                    @endforeach
                                </div>
                                <div class="col-8 col-lg-9 ps-2">
                                    <textarea name="question[]" id="question" placeholder="Jabarkan Pertanyaanmu Disini.." required>{{$item->pivot->question}}</textarea>
                                </div>
                               </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 d-grid gap-2">
                    {{-- <a class="button secondary" href="/checkout/summary">
                        Go to Summary
                    </a> --}}
                    <button type="submit" class="button secondary">Go to Summary</button>
                </div>
            </form>
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
