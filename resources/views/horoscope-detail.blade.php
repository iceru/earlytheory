<x-app-layout>
    @section('title')
    Horoscopes - Show
    @endsection

    <div class="horoscope-detail">
        <div class="row">
            <div class="col-12 col-lg-5">
                <div class="header">
                    <div class="hr-name">
                        {{ $horoscope->data['profile']['name'] }}
                    </div>
                    <div class="hr-date">
                        <i class="fas fa-birthday-cake fa-fw"></i>
                        <p>{{
                            \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->toFormattedDateString()
                            }}</p>
                    </div>
                    <div class="hr-date">
                        <i class="fas fa-clock fa-fw"></i>
                        <p>{{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->toTimeString()}}
                        </p>
                    </div>
                    <div class="hr-city">
                        <p>{{ $horoscope->data['profile']['cityName'] }}</p>
                    </div>
                </div>

                <div class="row">
                    @foreach ($horoscope->data['planets'] as $planet)
                    <div class="planet col-12 col-lg-6">
                        <p class="planet-degree">{{ $planet['degrees'] }}&#176; {{ $planet['minutes'] }}" {{ $planet['seconds'] }}'</p>
                        <div class="planet-name">
                            <span>{{ $planet['planetName'] }}</span>
                        </div>
                        <div class="planet-house">House Position: {{ $planet['housePosition'] }}</div>
                        <p>Sign Name: {{ $planet['signName'] }}</p>
                        <p>Retrogade: {{ $planet['retrograde'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <img class="w-100 hr-chart" src="{{ Storage::url('horoscopes/horoscope_'.$horoscope->link_id.'.svg') }}"
                    alt="{{ $horoscope->data['profile']['name'] }} Wheel">
            </div>
        </div>
    </div>
</x-app-layout>