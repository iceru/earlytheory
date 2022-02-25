<x-app-layout>
    @section('title')
    Birth Chart - Show
    @endsection

    <div class="horoscope-detail">
        <div class="row align-items-center">
            
            <div class="col-12 col-lg-6 image-wrapper text-center">
                <img class="hr-chart" src="{{ Storage::url('horoscopes/horoscope_'.$horoscope->link_id.'.svg') }}"
                    alt="{{ $horoscope->data['profile']['name'] }} Wheel">
            </div>
            <div class="col-12 col-lg-6">
                <div class="header">
                    <div class="hr-name">
                        {{ $horoscope->data['profile']['name'] }}
                    </div>
                    <div class="row birth-date">
                        <div class="col-4">
                            {{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->format('j M Y')}}
                        </div>
                        <div class="col-4">
                            {{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->format('g:i A')}}
                        </div>
                        <div class="col-4">
                            <p>{{ $horoscope->data['profile']['cityName'] }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @foreach (array_slice($horoscope->data['planets'], 0, 2) as $planet)
                    <div class="col-6 col-lg-4">
                        <div class="row planet">
                            <div class="col-4">
                                <img class="w-100" src={{ '/images/planets/'.$planet['planetName'].'.png' }} alt="{{ $planet['planetName'] }}">
                            </div>
                            <div class="col-8">
                                <div class="title">
                                    <div class="planet-name">{{ $planet['planetName'] }}</div>
                                    <div class="planet-degree">{{ $planet['degrees'] }}&#176; {{ $planet['minutes'] }}" {{
                                        $planet['seconds'] }}'</div>
                                </div>
                                <div class="planet-sign">
                                    {{ $planet['signName'] }}
                                </div>
                                <div class="planet-house">House {{ $planet['housePosition'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-6 col-lg-4">
                        <div class="row planet">
                            <div class="col-4">
                                <img class="w-100" src={{ '/images/planets/Ascendant.png' }} alt="Ascendant">
                            </div>
                            <div class="col-8">
                                <div class="title">
                                    <div class="planet-name">Ascendant</div>
                                    <div class="planet-degree">{{ $horoscope->data['ascendant']['degrees'] }}&#176; {{ $horoscope->data['ascendant']['minutes'] }}" {{
                                        $horoscope->data['ascendant']['seconds'] }}'</div>
                                </div>
                                <div class="planet-sign">
                                    {{$horoscope->data['ascendant']['signName']}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="row planet">
                            <div class="col-4">
                                <img class="w-100" src={{ '/images/planets/Midheaven.png' }} alt="Midheaven">
                            </div>
                            <div class="col-8">
                                <div class="title">
                                    <div class="planet-name">Midheaven</div>
                                    <div class="planet-degree">{{ $horoscope->data['midheaven']['degrees'] }}&#176; {{ $horoscope->data['midheaven']['minutes'] }}" {{
                                        $horoscope->data['midheaven']['seconds'] }}'</div>
                                </div>
                                <div class="planet-sign">
                                    {{$horoscope->data['midheaven']['signName']}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach (array_slice($horoscope->data['planets'], 2, 12) as $planet)
                    <div class="col-6 col-lg-4">
                        <div class="row planet">
                            <div class="col-4">
                                <img class="w-100" src={{ '/images/planets/'.$planet['planetName'].'.png' }} alt="{{ $planet['planetName'] }}">
                            </div>
                            <div class="col-8">
                                <div class="title">
                                    <div class="planet-name">{{ $planet['planetName'] }}</div>
                                    <div class="planet-degree">{{ $planet['degrees'] }}&#176; {{ $planet['minutes'] }}" {{
                                        $planet['seconds'] }}'</div>
                                </div>
                                <div class="planet-sign">
                                    {{ $planet['signName'] }}
                                </div>
                                <div class="planet-house">House {{ $planet['housePosition'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 mt-3">
                <h3 class="evogria mb-4 text-center">Table Aspect</h3>
                <div class="table-responsive">
                    <table class="table table-aspect table-bordered border-dark ">
                        <thead>
                            <tr>
                                <th colspan="2">Planet</th>
                                <th>Aspect</th>
                                <th colspan="2">Planet</th>
                                <th>Orb</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horoscope->data['aspects'] as $aspect)
                            <tr>
                                <td class="image"><img src="{{ '/images/planets/'.$aspect['planet1Name'].'.png' }}" alt="{{ $aspect['planet1Name']}}"></td>
                                <td>{{ $aspect['planet1Name']}}</td>
                                <td>{{ $aspect['aspectName'] }}</td>
                                <td class="image"><img src="{{ '/images/planets/'.$aspect['planet2Name'].'.png' }}" alt="{{ $aspect['planet2Name']}}"></td>
                                <td>{{ $aspect['planet2Name']}}</td>
                                <td>{{ $aspect['degrees'] }}&#176; {{ Str::substr($aspect['seconds'], 0, 2) }}'</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var skus = {!! $skus !!};
            $.each($('.addcart'), function (index, item) {
                Object.keys(skus).forEach(function(element) {
                    if (skus[element].product_id == $(item).attr('data-id')) {
                        $(item).attr('data-price', skus[element].price);
                        $(item).attr('data-sku', skus[element].id);
                        $(item).attr('data-values',  skus[element].values);
                        $(item).attr('data-link',  '{!! $horoscope->link_id !!}');
                        // $(item).attr('data-values', element.values);
                    } 
                });
                if(!$(item).attr('data-price')) {
                    $(item).removeClass('primary');
                    $(item).removeClass('addcart');
                    $(item).removeAttr('data-id');
                    $(item).addClass('disabled');
                    $(item).text('STOK HABIS');
                    $(item).attr('disabled', true);
                    $(item).parent().insertAfter($('.product-item-container').last());
                }
            });
            
        });
    </script>
</x-app-layout>