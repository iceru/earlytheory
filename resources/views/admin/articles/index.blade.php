<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Article Admin
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/articles/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="inputTitle">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inputDesc" id="inputDesc" cols="30" rows="2"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputAuthor" name="inputAuthor">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Read</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputTime" name="inputTime" min="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Accent Color</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" data-jscolor="" id="inputAccent" name="inputAccent">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inputTags" id="inputTags" cols="30" rows="2"></textarea>
                        <div class="form-text">(Separate with space, ex: tag1 tag2 tag3)</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Time to Read</th>
                        <th>Accent Color</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->description}}</td>
                        <td>{{$article->author}}</td>
                        <td>{{$article->time_read}}</td>
                        <td style="color: {{$article->accent_color}}">{{$article->accent_color}}</td>
                        <td><a href="/admin/articles/edit/{{$article->id}}">Edit</a> | 
                            <a href="/admin/articles/delete/{{$article->id}}">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js" integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g==" crossorigin="anonymous"></script>
</x-admin-layout>

