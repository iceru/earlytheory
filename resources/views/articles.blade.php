<x-app-layout>
    @section('title')
        Articles
    @endsection
    @include('article-index')

    <script>
        $(document).ready(function(){
            $('.sliders').slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 3000,
                pauseOnHover: false,
            });
        });
    </script>
</x-app-layout>


