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
                        <a href="" class="button secondary">
                            @if ($coIndex === 1)
                                Workshop
                            @else
                                Sebelumnya
                            @endif
                        </a>
                    </div>
                    <div>
                        <a href="" class="button primary">
                            Selanjutnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
