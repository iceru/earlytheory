<x-app-layout>
    @section('title')
        My Birth Chart
    @endsection

    <div class="container account">
        <div class="row">
            <div class="col-12 mb-5">
                <h3 class="evogria text-page">My Birth Chart</h3>
            </div>
            @include('layouts.account-navigation')

            <div class="col-12 col-md-9">
                @foreach ($horoscopes as $item)
                    <div class="account-horoscope">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="name">{{ $item->data['profile']['name'] }}</h5>
                                <p class="date">{{ \Carbon\Carbon::parse($item->data['profile']['birthdate']['date'])->format('j M Y
                                    , g:ia')}}
                                </p>
                                <p class="city">{{ $item->data['profile']['cityName'] }}</p>
                                <p class="mt-3">{{ $item->created_at }}</p>
                            </div>
                            <div class="detail">
                                <a href="/birth-chart/show/{{ $item->link_id }}">
                                    <div class="button primary">More Detail <i class="fa fa-arrow-right ms-2" aria-hidden="true"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>