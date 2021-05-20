<x-app-layout>
    @section('title')
        Articles
    @endsection
    <div class="col-12 articles">
        <div class="row">
            <div class="col-12">
                <div class="sliders">
                    @foreach ($sliders as $slider)
                    <a href="{{ $slider->link }}">
                        <div class="slider-item">
                            <img src="{{Storage::url('sliders-image/'.$slider->image)}}" alt="">
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @forelse ($articles as $article)
                <div class="col-12 col-md-6 col-xxl-4 article">
                    <div class="row article-info">
                        <div class="col-5 article-image">
                            <a href="/article-detail/{{$article->id}}"><img src="{{Storage::url('article-image/'.$article->image)}}" alt="{{ $article->title }}"></a>
                        </div>
                        <div class="col-7">
                            <div class="tags">
                                @forelse ($article->tags as $tag)
                                    <p>#{{$tag->tag_name}}</p>
                                @empty
                                    <p>No Tag</p>
                                @endforelse
                            </div>
                            <div class="title">
                                <a href="/article-detail/{{$article->id}}"><h5>{{$article->title}}</h5></a>
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
                <h4 class="evogria">No Article</h4>
            @endforelse
            <div class="d-flex justify-content-center">{{$articles->links()}}</div>
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


