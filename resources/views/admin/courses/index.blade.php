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
        <h3 class="evogria">Courses</h3>
        <h5 class="mt-3">
            <b>Workshop:</b> {{ $workshop->title }}
        </h5>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="/admin/courses/store">
                @csrf
                <input value="{{ $workshop->id }}" name="workshop_id" type="hidden">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ old('title') }}" id="title"
                            name="title">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description" value="{{ old('description') }}" id="description" cols="30"
                            rows="6"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Video</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="video" name="video"
                            accept="video/mp4,video/x-m4v,video/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Learn (in minutes)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="time" name="time" placeholder="ex: 5">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price" name="price"
                            placeholder="ex: 150000">
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
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Video</th>
                        <th>Time to Learn</th>
                        <th>Price</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $course->title }}</td>
                            <td class="tab-article-desc">{!! substr($course->description, 0, 200) !!}</td>
                            <td>
                                <div class="ratio ratio-1x1">
                                    <img src="{{ Storage::url('public/course-image/' . $course->image) }}"
                                        alt="Image" width="100">
                                </div>
                            </td>
                            <td>
                                @if (isset($course->video))
                                    <div class="ratio ratio-1x1">
                                        <video src="{{ Storage::url('public/course-video/' . $course->video) }}">
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $course->time }}</td>
                            <td>{{ $course->price }}</td>
                            <td><a class="btn btn-primary btn-small d-flex align-items-center justify-content-center mb-2"
                                    href="/admin/course/edit/{{ $course->id }}"><i class="fas fa-edit me-1"></i>
                                    Edit</a>
                                <a href="/admin/courses/delete/{{ $course->id }}"
                                    class="btn btn-danger btn-small d-flex align-items-center justify-content-center"><i
                                        class="fa fa-trash me-1" aria-hidden="true"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
