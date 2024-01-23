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
        <h3 class="evogria">Update Course</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.courses.update', $course->id) }}">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $course->title }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description" id="description" cols="30" rows="6">{{ $course->description }}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <div class="mb-2">
                            <img width="150" src="{{ Storage::url('course-image/' . $course->image) }}"
                                alt="">
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    @if ($course->video)
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="mb-2">
                                <video width="400" src="{{ route('course.video', $course->slug) }}" controls>
                            </div>
                        </div>
                    @endif
                    <label class="col-sm-2 col-form-label">Video</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="video" name="video"
                            accept="video/mp4,video/x-m4v,video/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    @if ($course->lq_video)
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="mb-2">
                                <video width="400" src="{{ route('course.video.lq', $course->slug) }}" controls>
                            </div>
                        </div>
                    @endif
                    <label class="col-sm-2 col-form-label">Low Quality Video (480p)</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="lq_video" name="lq_video"
                            accept="video/mp4,video/x-m4v,video/*">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Time to Learn</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="time" name="time"
                            value="{{ $course->time }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ $course->price }}">
                    </div>
                </div>
                <button type="submit" class="button primary">Update</button>
            </form>
        </div>
    </div>
</x-admin-layout>
