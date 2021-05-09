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
            <form action="/checkout/{{$sales->id}}/question/add" method="post">
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
                                <div class="col-4 col-lg-3 product-image">
                                    <img src="{{Storage::url('product-image/'.$item->image)}}" alt="">
                                </div>
                                <div class="col-8 col-lg-9 ps-2">
                                    <textarea name="question[]" id="question" placeholder="Jabarkan Pertanyaanmu Disini..">{{$item->pivot->question}}</textarea>
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
</x-app-layout>
