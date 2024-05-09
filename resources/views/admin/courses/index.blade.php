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
                        {{-- <input type="file" class="form-control" id="video" name="video" --}}
                        {{-- accept="video/mp4,video/x-m4v,video/*"> --}}
                        <div id="upload-container" class="text-center">
                            <button id="browseFile" class="btn btn-primary">Browse File</button>
                        </div>
                        <div style="display: none" class="progress mt-3" style="height: 25px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: 75%; height: 100%">
                                75%
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Low Quality Video (480p)</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="lq_video" name="lq_video"
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
                                @if ($course->video)
                                    <div>
                                        <video controls width="200" src="{{ route('course.video', $course->slug) }}">
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

    <script type="text/javascript">
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: '{{ route('admin.courses.video', $course->id) }}',
            query: {
                _token: '{{ csrf_token() }}'
            }, // CSRF token
            fileType: ['mp4'],
            chunkSize: 10 * 1024 *
                1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) { // trigger when file picked
            showProgress();
            resumable.upload() // to actually start uploading.
        });

        resumable.on('fileProgress', function(file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            $('#videoPreview').attr('src', response.path);
            $('.card-footer').show();
        });

        resumable.on('fileError', function(file, response) { // trigger when there is any error
            alert('file uploading error.')
        });


        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    </script>
</x-admin-layout>
