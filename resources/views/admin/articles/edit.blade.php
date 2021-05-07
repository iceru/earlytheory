<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h3 class="evogria">Update Article</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/articles/update">
                @csrf
                <input type="hidden" name="id" value="{{$article->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="updateImage" name="updateImage" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateTitle" name="updateTitle" value="{{$article->title}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="updateDesc" id="updateDesc" cols="30" rows="2">{{$article->description}}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateAuthor" name="updateAuthor" value="{{$article->author}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Read</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="updateTime" name="updateTime" min="0" value="{{$article->time_read}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Accent Color</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" data-jscolor="" id="updateAccent" name="updateAccent" value="{{$article->accent_color}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="updateTags" id="updateTags" cols="30" rows="2">@foreach ($article->tags as $tag){{$tag->tag_name}} @endforeach</textarea>
                        <div class="form-text">(Separate with space, ex: tag1 tag2 tag3)</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>
</x-admin-layout>

