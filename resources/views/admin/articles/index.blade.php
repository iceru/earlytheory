<x-admin-layout>
    @if (count($errors) > 0)
        <div class="alert alert-danger mt-3">
            <strong>Sorry !</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Articles</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/articles/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="inputImage" name="inputImage" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle" name="inputTitle">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Article Content</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inputDesc" id="inputDesc" cols="30" rows="6"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputAuthor" name="inputAuthor">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Read (in Minutes)</label>
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
                        <input class="form-control" name="inputTags" id="inputTags"></input>
                        <div class="form-text">(Separate with space, ex: tag1 tag2 tag3)</div>
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12 table-overflow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
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
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>
                                <div class="ratio ratio-1x1">
                                    <img src="{{ Storage::url('public/article-image/' . $article->image) }}"
                                        alt="Image" width="100">
                                </div>
                            </td>
                            <td>{{ $article->title }}</td>
                            <td class="tab-article-desc">{!! substr($article->description, 0, 200) !!}</td>
                            <td>{{ $article->author }}</td>
                            <td>{{ $article->time_read }}</td>
                            <td style="color: {{ $article->accent_color }}">{{ $article->accent_color }}</td>
                            <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                    href="/admin/articles/edit/{{ $article->id }}"><i class="fas fa-edit me-1"></i>
                                    Edit</a>
                                <a href="/admin/articles/delete/{{ $article->id }}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                        class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @section('js')
        <script>
            $(document).ready(function() {
                $('#table').DataTable();

                function split(val) {
                    return val.split(/ /);
                }

                function extractLast(term) {
                    return split(term).pop();
                }

                $('#inputTags').autocomplete({
                    source: function(request, response) {
                        // delegate back to autocomplete, but extract the last term
                        response($.ui.autocomplete.filter(
                            {!! json_encode($autocomplete) !!}, extractLast(request.term)));
                    },
                    select: function(event, ui) {
                        var terms = split(this.value);
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(" ");
                        return false;
                    }
                });
            });
        </script>
    @endsection
</x-admin-layout>
