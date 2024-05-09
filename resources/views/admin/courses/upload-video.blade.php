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
        <a href="{{ route('admin.courses.edit', $course->id) }}" class="mb-3 d-flex align-items-center">
            <i class="fas fa-chevron-left me-2"></i>
            <div>
                Go Back
            </div>
        </a>
        <h3 class="evogria">Update Video</h3>
    </div>

    <div class="py-12 my-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @csrf
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Video</label>
                <div class="col-sm-10">
                    {{-- <input type="file" class="form-control" id="video" name="video"
                            accept="video/mp4,video/x-m4v,video/*"> --}}
                    <div id="upload-container">
                        <button id="browseFile" type="button" class="btn btn-primary">Browse File</button>
                    </div>
                    <div style="display: none" class="progress mt-3" style="height: 25px">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">
                            75%
                        </div>
                    </div>
                    <div class="py-2 video-preview" style="{{ $course->video ? '' : 'display: none' }}">
                        <video id="videoPreview" src="{{ route('course.video', $course->slug) }}" controls
                            style="width: 100%; height: auto"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
<script>
    $(document).ready(function() {
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: "{{ route('admin.courses.video', $course->id) }}",
            query: {
                _token: '{{ csrf_token() }}'
            }, // CSRF token
            fileType: ['mp4'],
            chunkSize: 10 * 1024 * 1024,
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
            setTimeout(() => {
                window.location.reload();
            }, 1000);
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
    });
</script>
