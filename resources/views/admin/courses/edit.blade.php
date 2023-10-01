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
        <h3 class="evogria">Update Workshop</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/workshops/update">
                @csrf
                <input type="hidden" name="id" value="{{ $workshop->id }}">

                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $workshop->title }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="desc" id="desc" cols="30" rows="6">{{ $workshop->description }}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Learn</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="time" name="time"
                            value="{{ $workshop->time }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Discount on Full Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="discount" name="discount"
                            value="{{ $workshop->disount }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Video</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Accent Color</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" data-jscolor="" id="accent" name="accent"
                            value="{{ $workshop->accent }}">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>


    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js"
            integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g=="
            crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {

                function split(val) {
                    return val.split(/ /);
                }

                function extractLast(term) {
                    return split(term).pop();
                }

                $('#updateTags').autocomplete({
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
            })
        </script>
    @endsection
</x-admin-layout>
