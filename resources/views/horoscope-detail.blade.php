<x-app-layout>
    @section('title')
    Horoscopes - Show
    @endsection

    <div class="horoscope-detail">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="header">
                    <div class="hr-name">
                        {{ $horoscope->data['profile']['name'] }}
                    </div>
                    <div class="hr-desc">
                        <div class="hr-date">
                            <p>{{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->format('j M Y
                                , g:ia')}}
                            </p>
                        </div>
                        <div class="hr-city">
                            <p>{{ $horoscope->data['profile']['cityName'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($horoscope->data['planets'] as $planet)
                    <div class="col-12 col-lg-6">
                        <div class="planet">
                            <p class="planet-degree">{{ $planet['degrees'] }}&#176; {{ $planet['minutes'] }}" {{
                                $planet['seconds'] }}'</p>
                            <div class="planet-name">
                                <span>{{ $planet['planetName'] }}</span>
                            </div>
                            <div class="planet-house">House Position: {{ $planet['housePosition'] }}</div>
                            <p>Sign Name: {{ $planet['signName'] }}</p>
                            <p>Retrogade: {{ $planet['retrograde'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <img class="w-100 hr-chart" src="{{ Storage::url('horoscopes/horoscope_'.$horoscope->link_id.'.svg') }}"
                    alt="{{ $horoscope->data['profile']['name'] }} Wheel">
            </div>
        </div>
    </div>
</x-app-layout>