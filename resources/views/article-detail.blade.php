<x-app-layout>
    <div class="col-12 g-0 pb-4 article-detail">
        <div class="article-image" style="background-image: url('/images/SWOT.png')">
            <div class="share">
                <i class="fas fa-share    "></i>
            </div>
            <div class="back">
                <i class="fas fa-chevron-left    "></i>
            </div>
            <div class="title">
                <h2>{{$article->title}}</h2>
            </div>
        </div>
        <div class="article-body">
            <div class="writer-info">
                <div class="writer-image">
                    <img src="/images/Favicon.png" alt="">
                </div>
                <div class="writer-name">
                    <p>{{$article->author}}</p>
                    <div class="information">
                        <p>{{date_format($article->created_at, "j F Y")}}</p>
                        <div class="circle"></div>
                        <p>{{$article->time_read}} Min Read</p>
                    </div>
                </div>
            </div>
            <div class="article-text">
                {!!nl2br($article->description)!!}
            </div>

            <div class="sliders mt-4">
                <div class="slider-item">
                    <img src="/images/Sliders1.png" alt="">
                </div>
                <div class="slider-item">
                    <img src="/images/Sliders1.png" alt="">
                </div>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        $(document).ready(function(){
            $('.sliders').slick({
                dots: true
            });
        });
    </script>
    @endsection
</x-app-layout>
