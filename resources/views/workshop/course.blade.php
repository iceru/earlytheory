<x-app-layout>
    @section('title')
        Course - {{ $course->title }}
    @endsection

    <div class="course__container container">
        <section class="header-page">
            <div>
                <img width="50" src="/images/Favicon.png" alt="">
            </div>
            <div>
                {{ $workshop->title }}
            </div>
        </section>

        <div class="course__wrapper">

            <div>
                @if ($course->video)
                    <div class="course__video" oncontextmenu="return false;">
                        <video controlsList="nodownload" controls alt="" id="video"
                            src="{{ route('course.video', $course->slug) }}" />
                    </div>
                    <div class="course__video-quality">
                        <div>Video Quality</div>
                        <select class='qualitypick' autocomplete='off'>
                            <option value="720p">720p</option>
                            <option value="480p">480p</option>
                        </select>
                    </div>
                @else
                    <div class="course__image">
                        <img src="{{ Storage::url('course-image/' . $course->image) }}" alt="">
                    </div>
                @endif
            </div>
            <div>
                <p class="course__bab">Bab {{ $coIndex }}</p>
                <h1 class="course__title">
                    {{ $course->title }}
                </h1>
                <p class="course__time">{{ $course->time }} Menit</p>
                <div class="course__description">
                    <p>{!! $course->description !!}</p>
                </div>

                <div class="course__nav">
                    <div>
                        <a href="{{ $prevCourse ? route('course', $prevCourse->slug) : route('workshop.detail', $workshop->slug) }}"
                            class="button secondary">
                            <i class="fa fa-long-arrow-alt-left me-2"></i>
                            @if ($coIndex === 1)
                                Workshop
                            @else
                                {{ $prevCourse->title }}
                            @endif
                        </a>
                    </div>
                    <div>
                        @if ($enableNext && count($workshop->course) > $coIndex - 1)
                            <a href="{{ route('course', $nextCourse->slug) }}" class="button primary">
                                {{ $nextCourse->title }}
                                <i class="fa fa-long-arrow-alt-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.qualitypick').change(function() {
                debugger;
                const video = $('#video')[0];
                const currTime = video.currentTime;

                if ($(this).val() === '480p') {
                    video.src = "{!! route('course.video.lq', $course->slug) !!}"
                } else {
                    video.src = "{!! route('course.video', $course->slug) !!}"
                }
                video.load();

                video.currentTime = currTime;
            })
        })
    </script>
</x-app-layout>
