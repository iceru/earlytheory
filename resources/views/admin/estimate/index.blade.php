<x-admin-layout>

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
            <form method="POST" action="/admin/estimate/store">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Estimate</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="estimate" name="estimate" min="0">
                    </div>
                </div>
                <button type="submit" class="button primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Estimates</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimate as $est)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $est->title }}</td>
                            <td>{{ $est->estimate }}</td>

                            <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                    href="/admin/estimate/edit/{{ $est->id }}"><i class="fas fa-edit me-1"></i>
                                    Edit</a>
                                <a href="/admin/estimate/delete/{{ $est->id }}"
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
            });
        </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    @endsection

</x-admin-layout>
