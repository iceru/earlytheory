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
                    <div class="course__video">
                        <video src="{{ Storage::url('course-image/' . $course->video) }}" alt="">
                    </div>
                @else
                    <div class="course__image">
                        <img src="{{ Storage::url('course-image/' . $course->image) }}" alt="">
                    </div>
                @endif
                <p>Bab {{ $coIndex }}</p>
                <h1 class="course__title">
                    {{ $course->title }}
                </h1>
                <p class="course__time">{{ $course->time }} Menit</p>
            </div>
            <div class="course__description">
                <p>{!! $course->description !!}</p>
            </div>

            <div>

            </div>
        </div>
    </div>
</x-app-layout>
