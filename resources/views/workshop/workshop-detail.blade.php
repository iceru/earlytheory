<x-app-layout>
    @section('title')
        Workshop - {{ $workshop->title }}
    @endsection
    <div class="workshop-container container">
        <section class="header-page">
            <div>
                <img width="50" src="/images/Favicon.png" alt="">
            </div>
            <div>
                Kelas & Workshop
            </div>
        </section>
        <section class="workshop">
            <div class="workshop-content">
                <div class="workshop-info">
                    <div class="workshop-media">
                        <img src="{{ Storage::url('workshop-image/' . $workshop->image) }}" alt="">
                    </div>
                    <h1>
                        {{ $workshop->title }}
                    </h1>
                    <h6>{{ $workshop->course->count() }} Bab Materi - {{ $workshop->time }} Menit</h6>
                    <div>
                        {!! $workshop->description !!}
                    </div>
                </div>
                <div class="package">
                    <div class="buy-package">
                        <div>
                            <h5>Paket Full Program</h5>
                            <p>Rp {{ number_format($fullPrice) }}
                                {{ $workshop->discount ? '(' . $workshop->discount . '% OFF)' : '' }}</p>
                        </div>
                        <div>
                            <button class="button button-buy">
                                Beli
                            </button>
                        </div>
                    </div>
                    <div class="list-bab">
                        <h4>Daftar Bab</h4>
                        @foreach ($workshop->course as $key => $item)
                            <div class="item-bab">
                                <p>
                                    Bab {{ $key + 1 }} <br />
                                    {{ $item->title }}
                                </p>
                                @if (count($item->sales) > 0 && $item->status === 'active')
                                    <div>
                                        <a href="{{ route('course', $item->slug) }}"
                                            class="button button-buy text-dark">
                                            Pelajari
                                        </a>
                                    </div>
                                @else
                                    <div class="button-wrapper">
                                        @if ($item->price == 0)
                                            <a href="{{ route('course', $item->slug) }}"
                                                class="button button-buy text-dark">
                                                Pelajari
                                            </a>
                                        @else
                                            <div>
                                                <div class="button-buy">
                                                    IDR {{ number_format($item->price) }}
                                                </div>
                                            </div>
                                            <button class="button button-cart" data-id={{ $item->id }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M13.0901 9.9C13.7649 9.9 14.3587 9.531 14.6646 8.973L17.8854 3.132C18.2182 2.538 17.7864 1.8 17.1026 1.8H3.78759L2.94191 0H0V1.8H1.79933L5.03813 8.631L3.82358 10.827C3.16682 12.033 4.0305 13.5 5.398 13.5H16.194V11.7H5.398L6.38763 9.9H13.0901ZM4.64228 3.6H15.5732L13.0901 8.1H6.77448L4.64228 3.6ZM5.398 14.4C4.40836 14.4 3.60766 15.21 3.60766 16.2C3.60766 17.19 4.40836 18 5.398 18C6.38763 18 7.19733 17.19 7.19733 16.2C7.19733 15.21 6.38763 14.4 5.398 14.4ZM14.3947 14.4C13.405 14.4 12.6043 15.21 12.6043 16.2C12.6043 17.19 13.405 18 14.3947 18C15.3843 18 16.194 17.19 16.194 16.2C16.194 15.21 15.3843 14.4 14.3947 14.4Z"
                                                        fill="#A5F367" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $('.button-cart').on('click', function() {
            var id = $(this).attr('data-id');

            if (id) {
                $.ajax({
                    url: "/cart/add/course/" + id,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#cartcount').html(data.count);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                        })

                        if ($.isEmptyObject(data.error)) {
                            Toast.fire({
                                icon: 'success',
                                title: data.success + '&nbsp; | &nbsp;' +
                                    '<a style="color:#4A2984;" href="/cart">Go to Cart</a> '
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }
                    },
                });
            } else {
                alert('Stok Habis / Error');
            }
        });
    </script>

</x-app-layout>
