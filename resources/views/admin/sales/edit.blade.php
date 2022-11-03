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
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <h3 class="evogria">Update Sales</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="/admin/sales/update">
                @csrf
                <input type="hidden" name="id" value="{{ $sales->id }}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateName" name="updateName"
                            value="{{ $sales->user->name }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="updateEmail" name="updateEmail"
                            value="{{ $sales->user->email }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updatePhone" name="updatePhone"
                            value="{{ $sales->user->phone }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Birth Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="updateBirthdate" name="updateBirthdate"
                            value="{{ $sales->user->birthdate }}">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.5/jscolor.min.js"
        integrity="sha512-YxdM5kmpjM5ap4Q437qwxlKzBgJApGNw+zmchVHSNs3LgSoLhQIIUNNrR5SmKIpoQ18mp4y+aDAo9m/zBQ408g=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#updateBirthdate").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1970:2012",
                altFormat: 'yy/mm/dd',
            });
        });
    </script>
</x-admin-layout>
