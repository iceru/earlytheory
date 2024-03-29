<x-admin-layout>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    @endsection

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

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="py-12">
        <h3 class="evogria">Tags</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/tags/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tag Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="inputName">
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
                        <th>Tag Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$tag->tag_name}}</td>
                        <td><a class="btn btn-primary btn-small align-items-center justify-content-center me-2"
                            href="/admin/tags/edit/{{$tag->id}}"><i class="fas fa-edit me-1"></i> Edit</a>
                        <a href="/admin/tags/edit/{{$tag->id}}"
                            class="btn btn-danger btn-small align-items-center justify-content-center"><i
                                class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a></td>
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
        } );
    </script>
    @endsection
</x-admin-layout>

