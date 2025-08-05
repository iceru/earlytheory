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

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="py-12">
        <h3 class="evogria">Update Perfume Altar</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/perfume/update">
                @csrf
                <input type="hidden" name="id" value="{{$perfume->id}}">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{$perfume->title}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            Current Image
                        </div>
                        <div class="col-sm-10 ml-3">
                            <img width="200" src="{{ Storage::url('perfume-image/'. $perfume->image) }}" alt="">
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>

</x-admin-layout>

