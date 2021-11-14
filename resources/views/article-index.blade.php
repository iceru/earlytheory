<div class="col-12 articles">
    <div class="row">
        @forelse ($articles as $article)
            <div class="col-12 col-md-4 article">
                <div class="row article-info">
                    <div class="col-12 article-image">
                        <a href="/article-detail/{{$article->slug}}">
                            <div class="ratio ratio-16x9">
                                <img src="{{Storage::url('article-image/'.$article->image)}}" alt="{{ $article->title }}" loading="lazy">
                            </div>
                        </a>
                    </div>
                    {{-- <div class="col-7">
                        <div class="tags">
                            @forelse ($article->tags->slice(0, 6) as $tag)
                                <a href="{{ route('tag.show', $tag->id) }}">
                                    <p>#{{$tag->tag_name}}</p>
                                </a>
                            @empty
                                <p>No Tag</p>
                            @endforelse
                        </div>
                        <div class="title">
                            <a href="/article-detail/{{$article->slug}}"><h5>{{$article->title}}</h5></a>
                        </div>
                        <div class="information">
                            <p>{{date_format($article->created_at, "j F Y")}}</p>
                            <div class="circle"></div>
                            <p>{{$article->time_read}} min read</p>
                        </div>
                    </div> --}}
                </div>
            </div>
        @empty
            <h4 class="evogria">No Article</h4>
        @endforelse
        <div class="d-flex justify-content-center">{{$articles->links()}}</div>
    </div>
</div>
