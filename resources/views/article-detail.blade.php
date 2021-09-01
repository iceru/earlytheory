<x-app-layout>
    @section('title')
        {{$article->title}} - Early Theory
    @endsection
    <div class="col-12 g-0 article-detail main-content">
        <div class="breadcrumb mb-3 fw-normal">
            <a href="{{ route('articles') }}" class="primary-color">Articles</a><span>&nbsp; <span class="primary-color">/</span> &nbsp;{{ $article->title }}</span>
        </div>
        <div class="article-image" style="background-image: url('{{Storage::url('article-image/'.$article->image)}}')">
            {{-- <div class="share">
                <i class="fas fa-share    "></i>
            </div> --}}
            <div class="back">
                <i class="fas fa-chevron-left"></i>
            </div>

            <div class="title" style="background-color: {{ $article->accent_color }}; opacity: 0.8">
                <h1>{{$article->title}}</h1>
            </div>
        </div>
        <div class="article-body">
            <div class="addthis_inline_share_toolbox mb-4"></div>
            <div class="mb-3">
                <div class="tags">
                    @forelse ($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->id) }}">
                            <p>#{{$tag->tag_name}}</p>
                        </a>
                    @empty
                        <p>No Tag</p>
                    @endforelse
                </div>
            </div>
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
            <article class="article-text">
                {!! ($article->description) !!}
            </article>

            <div class="sliders mt-5">
                @foreach ($sliders as $slider)
                <a href="{{ $slider->link }}">
                    <div class="slider-item">
                        <img src="{{Storage::url('sliders-image/'.$slider->image)}}" alt="">
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-608aa065d81b6e37"></script>


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
