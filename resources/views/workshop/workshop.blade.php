<x-app-layout>
    @section('title')
        Workshop
    @endsection
    <div class="workshop__wrapper">
        <div class="page__title">
            <div class="page__titleImage">
                <img src="/images/Favicon.png" width="50" alt="">
            </div>
            <div class="page__titleText">
                Workshop
            </div>
        </div>
        <div class="workshop__titlePage">
            Daftar Program
        </div>
        <div class="workshop__lists">
            @foreach ($workshops as $workshop)
                <div class="workshop__item">
                    <div class="workshop__image">
                        <img src="{{ Storage::url('workshop-image/' . $workshop->image) }}" alt="">
                    </div>
                    <h3 class="workshop__title">
                        {{ $workshop->title }}
                    </h3>
                    <div class="workshop__desc">
                        {!! $workshop->description !!}
                    </div>
                    <a href="{{ route('workshop.detail', $workshop->slug) }}" class="button button-white">Telusuri</a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $('.workshop__lists').slick({
            dots: false,
            autoplay: false,
            autoplaySpeed: 5000,
            pauseOnHover: false,
            nextArrow: `<button class="slick-next">
                <img src="/images/arrow.svg" alt="" />
            </button>`
        });
    </script>
</x-app-layout>
