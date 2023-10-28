<x-app-layout>
    @section('title')
        Account Workshop
    @endsection

    <div class="container account__wrapper">
        <div class="account__bread">
            <a href="{{ route('user.account') }}">Akun</a>
            <span>/</span>
            <span>Kelas & Workshop</span>
        </div>
        <h3 class="account__titlePage">Kelas & Workshop</h3>

        <div class="account-content">
            <div class="account__workshopWrapper">
                @foreach ($ownedWorkshops as $item)
                    <div class="account__workshopItem">
                        <div class="d-flex align-items-center">
                            <div class="account__workshopImage">
                                <img src="{{ Storage::url('workshop-image/' . $item->image) }}" alt="">
                            </div>
                            <h3 class="account__workshopTitle">{{ $item->title }}</h3>
                        </div>
                        <div class="account__workshopButton">
                            <a class="button button-white" href="{{ route('workshop.detail', $item->slug) }}">
                                Pelajari
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    </div>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1960:2012",
                altFormat: 'yy/mm/dd',
                defaultDate: new Date('2000/01/01'),
            });
        });
    </script>
</x-app-layout>
