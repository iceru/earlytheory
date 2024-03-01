<x-app-layout>
    @section('title')
        Payment Success - {{ $sales->sales_no }}
    @endsection
    <div class="col-12 checkout no-print">
        <div class="row page-success">
            <div class="col-12 title-page">
                <h1>Pembayaran Berhasil</h1>
            </div>
            <div class="col-12 payment-success">
                <div class="text-center thank-you mb-4">
                    <img src="/images/pay.svg" alt="">
                    <h5>Kami akan konfirmasi orderanmu lewat Whatsapp!</h5>
                    {{-- <p>Pengiriman file dalam waktu 2-3 hari kerja</p> --}}
                </div>
                <hr>

                <div class="row products">
                    <div class="col-12 mb-3">
                        <h4 class="evogria">
                            Products
                        </h4>
                    </div>
                    @foreach ($sales->skus as $item)
                        <div class="col-12 col-lg-6">
                            <div class="product-item-container">
                                <div class="d-flex">
                                    <div class="product-image">
                                        @foreach ((array) json_decode($item->products->image) as $image)
                                            <div class="ratio ratio-1x1">
                                                <img src="{{ Storage::url('product-image/' . $image) }}" alt="No Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        <div class="product-title">
                                            <h3>{{ $item->products->title }}</h3>
                                        </div>
                                        <div class="product-price">
                                            <p>idr {{ number_format($item->price) }}</p>
                                        </div>
                                        @if ($item->products->estimate)
                                            <p class="text-bold">
                                                {{ $item->products->estimate->estimate }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-7 col-lg-9 product-question">
                                    @if ($item->variants)
                                        <div>
                                            <p class="me-2">Variants: </p>
                                            @foreach ($item->variants as $variant)
                                                <span class="variant-item me-2">{{ $variant }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div @if (
                                        $item->products->question != 'yes' ||
                                            $item->products->category == 'product' ||
                                            strtolower($item->products->title) === 'mencari jodoh') hidden @endif>
                                        <h5>Pertanyaan</h5>
                                        <p>{{ nl2br($item->pivot->question) }}</p>
                                        <a style="color: black;" href="/checkout/{{ $sales->sales_no }}/detail">
                                            <button class="button primary mt-3 mt-lg-2">
                                                <span><i class="fas fa-edit"></i> &nbsp;</span>
                                                <span>
                                                    Edit</span>
                                            </button>
                                        </a>
                                    </div>

                                    <div @if (strtolower($item->products->title) != 'mencari jodoh') hidden @endif>
                                        {{-- <h5>Preferensi Gender</h5> --}}
                                        <p>{{ ucfirst($item->pivot->question) }}</p>
                                        <button class="button primary mt-3 mt-lg-2">
                                            <span><i class="fas fa-edit"></i> &nbsp;</span>
                                            <a style="color: black;"
                                                href="/checkout/{{ $sales->sales_no }}/detail"><span>
                                                    Edit</span></a>
                                        </button>
                                    </div>
                                    @if (
                                        ($item->question != 'yes' && strtolower($item->products->title) != 'mencari jodoh') ||
                                            $item->products->category == 'product')
                                        <p>{!! $item->description_short !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($workshops as $workshop)
                        <div class="mb-4">
                            <div class="detail__workshopContainer">
                                <div class="detail__workshopImage">
                                    <img src="{{ Storage::url('workshop-image/' . $workshop->image) }}" alt="">
                                </div>
                                <div>
                                    <h3 class="detail__workshopTitle">{{ $workshop->title }}</h3>
                                    <div class="detail__workshopDesc">{!! $workshop->description !!}</div>
                                </div>
                            </div>
                            @foreach ($workshop->course as $course)
                                @foreach ($sales->course as $item)
                                    @if ($course->id === $item->id)
                                        <div class="detail__courseItem">
                                            <div class="d-flex">
                                                <div class="detail__courseImage">
                                                    <img src="{{ Storage::url('course-image/' . $item->image) }}"
                                                        alt="">
                                                </div>
                                                <h5 class="detail__courseTitle">
                                                    {{ $item->title }}
                                                </h5>
                                            </div>
                                            <div class="detail__coursePrice">
                                                IDR {{ number_format($item->price) }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach

                    @foreach ($sales->products as $item)
                        <div class="col-12 col-lg-6">
                            <div class="row product-item-container">
                                <div class="product-title ">
                                    <h3>{{ $item->title }}</h3>
                                </div>
                                <div class="product-price ">
                                    <p>idr {{ number_format($item->price) }}</p>
                                </div>
                                <div class="col-5 col-lg-3 product-image">
                                    @foreach ((array) json_decode($item->image) as $image)
                                        <div class="ratio ratio-1x1">
                                            <img src="{{ Storage::url('product-image/' . $image) }}" alt="No Image">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-7 col-lg-9 product-question">
                                    <div @if ($item->question != 'yes' || $item->category == 'product') hidden @endif>
                                        <h5>Pertanyaan</h5>
                                        <p>{{ nl2br($item->pivot->question) }}</p>
                                        <button class="button primary mt-3 mt-lg-2">
                                            <span><i class="fas fa-edit"></i> &nbsp;</span>
                                            <a style="color: black;"
                                                href="/checkout/{{ $sales->sales_no }}/detail"><span>
                                                    Edit</span></a>
                                        </button>
                                    </div>

                                    <div @if (strtolower($item->title) != 'mencari jodoh') hidden @endif>
                                        <h5>Preferensi Gender</h5>
                                        <p>{{ ucfirst($item->pivot->question) }}</p>
                                        <button class="button primary mt-3 mt-lg-2">
                                            <span><i class="fas fa-edit"></i> &nbsp;</span>
                                            <a style="color: black;"
                                                href="/checkout/{{ $sales->sales_no }}/detail"><span>
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
                <hr>
                <div class="row proof">
                    <div class="col-12 col-md-6 proof-desc">
                        <div class="row">
                            <div class="col-6">
                                <p><b>Sales Number:</b> <br> {{ $sales->sales_no }}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Nama Lengkap:</b> <br> {{ $sales->user->name }}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Email:</b> <br> {{ $sales->user->email }}</p>
                            </div>
                            <div class="col-6">
                                <p><b>No. Telepon:</b> <br> {{ $sales->user->phone }}</p>
                            </div>
                            <div class="col-6">
                                <p><b>Tanggal Lahir:</b> <br>
                                    {{ \Carbon\Carbon::parse($sales->user->birthdate)->toFormattedDateString() }}</p>
                            </div>
                            {{-- <div class="col-12 mt-3">
                                <button id="print" class="button primary">Print Invoice &nbsp; <i class="fa fa-print" aria-hidden="true"></i></button>
                            </div> --}}
                        </div>

                        {{-- <h5>Relationship: {{strtoupper($sales->relationship)}}</h5>
                        <h5>Pekerjaan: {{strtoupper($sales->job)}}</h5> --}}
                    </div>

                    <div class="col-12 col-md-6 proof-image">
                        <div>
                            <b>Bukti Pembayaran:</b>
                        </div>
                        <img class="w-auto mt-2" src="{{ Storage::url('payment-proof/' . $sales->payment) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $('#print').click(function() {
                window.print();
            })
            $(document).ready(function() {
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
