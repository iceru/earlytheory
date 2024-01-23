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
        <h3 class="evogria">Estimates</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/estimate/update">
                @csrf
                <input type="text" name="id" value="{{ $estimate->id }}" hidden>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $estimate->title }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Estimate</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="estimate" name="estimate" min="0"
                            value="{{ $estimate->estimate }}">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js"
        integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g=="
        crossorigin="anonymous"></script>
</x-admin-layout>
