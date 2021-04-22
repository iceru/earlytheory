<x-app-layout>
    <div class="col-12 articles">
        <div class="row">
            <div class="col-12">
                <div class="sliders">
                    <div class="slider-item">
                        <img src="/images/Sliders1.png" alt="">
                    </div>
                    <div class="slider-item">
                        <img src="/images/Sliders1.png" alt="">
                    </div>
                </div>
            </div>
            @forelse ($articles as $article)
                <div class="col-12 col-md-6 article">
                    <div class="row article-info">
                        <div class="col-5 article-image">
                            <img src="/images/SWOT.png" alt="">
                        </div>
                        <div class="col-7">
                            <div class="tags">
                                <p>#TAG1</p>
                                <p>#TAG2</p>
                            </div>
                            <div class="title">
                                <h5>{{$article->title}}</h5>
                            </div>
                            <div class="information">
                                <p>{{date_format($article->created_at, "j F Y")}}</p>
                                <div class="circle"></div>
                                <p>{{$article->time_read}} min read</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No Article</p>
            @endforelse
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


