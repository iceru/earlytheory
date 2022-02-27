<x-app-layout>
    @section('title')
    Birth Chart - Show
    @endsection

    @section('additional_header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endsection

    <div class="horoscope-detail">
        <div class="row align-items-center mb-5">
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
                    <div>
                        <div style="display: inline-flex" class="button primary mt-3" id="edit_button">Edit <i class="fas fa-edit fa-fw ms-2"></i></div>
                    </div>
                    <div class="row form-horoscope-edit mt-3">
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name_edit" placeholder="" value="{{ $user ? $user->name : "" }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email_edit" placeholder="" value="{{ $user ? $user->email : "" }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <div>
                                <label for="" class="form-label">Tanggal Lahir</label>
                                <input  type="text" class="form-control" name="birthdate" id="datepicker_edit" placeholder="" value="{{ $user ? \Carbon\Carbon::parse($user->birthdate)->toDateString() : "" }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div>
                                <label for="" class="form-label">Waktu Lahir</label>
                                <input  type="time" class="form-control" name="birthtime" id="birthtime_edit" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="birthplace-wrapper">
                                <label for="" class="form-label">Tempat Lahir</label>
                                <input  type="text" class="form-control" name="birthplace" id="birthplace_edit" placeholder="" autocomplete="false">
                                <div class="spinner">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6" >
                            <button style="width: 100%" id="editHoroscope" class="button primary expanded text-uppercase">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" hidden></span>
                                Get your Chart
                            </button>
                        </div>
                        <div class="col-6">
                            <button style="width: 100%" class="button secondary expanded" id="cancel_edit">Cancel</button>
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
                                <img class="w-100" src={{ '/images/planets/'.str_replace(' ', '', $planet['planetName']).'.png' }} alt="{{ $planet['planetName'] }}">
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
                                <td class="image"><img src="{{ '/images/planets/'.str_replace(' ', '', $aspect['planet1Name']).'.png' }}" alt="{{ $aspect['planet1Name']}}"></td>
                                <td>{{ $aspect['planet1Name']}}</td>
                                <td>{{ $aspect['aspectName'] }}</td>
                                <td class="image"><img src="{{ '/images/planets/'.str_replace(' ', '', $aspect['planet2Name']).'.png' }}" alt="{{ $aspect['planet2Name']}}"></td>
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

            $( "#datepicker_edit" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1970:2004",
                dateFormat: 'yy-mm-dd',
            });
            $('.form-horoscope-edit').hide();

            $("#birthplace_edit").autocomplete({
                source: function(request, response) {
                $('.birthplace-wrapper .spinner-border').removeAttr('hidden');
                    $.ajax({
                        type: "POST",
                        url: "/birth-chart/places",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {"name": request.term},
                        
                        success: function (data) {
                            $('.birthplace-wrapper .spinner-border').attr('hidden', true);
                            var results = $.map(data.data, function (item, key) {
                                return {
                                    label: item.name + ', ' + item.admin1_code + ', ' + item.timezone,
                                    id: item.id
                                }
                            })
                            response(results.slice(0, 10));
                        },
                    });
                },
                focus: function(event, ui) {
                    $('#birthplace_edit').val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    birthplaceEdit = ui.item.id
                    return false;
                },
                minLength: 3
            })
        });
        var user = '{!! $user !!}'

        $('#edit_button').click(function (e) { 
            e.preventDefault();
            $(this).hide();
            $('.form-horoscope-edit').show();
            $('.birth-date').hide();
        });

        $('#cancel_edit').click(function (e) { 
            e.preventDefault();
            $('.form-horoscope-edit').hide();
            $('#edit_button').show();
            $('.birth-date').show();
        });

        $('#editHoroscope').click(function (e) { 
            e.preventDefault();
            var nameEdit = $('#name_edit').val();
            var emailEdit = $('#email_edit').val();
            var birthdateEdit = $('#datepicker_edit').val();
            var birthtimeEdit = $('#birthtime_edit').val();

            if(nameEdit === '' || emailEdit === '' || birthdateEdit === '' || birthtimeEdit === '') {
                Swal.fire({
                    icon: "error",
                    title: "Isi form terlebih dahulu",
                });
                return
            }

            if(!birthplaceEdit) {
                Swal.fire({
                    icon: "error",
                    title: "Tempat kelahiran belum diisi dengan benar",
                });
                return
            }

            var data = {
                "name": nameEdit,
                "date": birthdateEdit,
                "time": birthtimeEdit,
                "place_id": birthplaceEdit,
                "email": emailEdit,
                "wheelSettings": {
                    "POINTS_TEXT_SIZE": 14,
                    "SYMBOL_SCALE": 1.5,
                }
            }

            $(this).prop('disabled', true);
            $('.spinner-border').removeAttr('hidden');

            $.ajax({
                type: "POST",
                url: "/birth-chart/natal",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: data,
                
                success: function (response) {
                    const obj = JSON.parse(response);
                    const uid = Date.now().toString(36) + Math.random().toString(36).substr(2);

                    if(user) {
                        storeHoroscope(uid, obj)
                    } else {
                        window.location = `/birth-chart/show/${uid}`
                    }
                    
                    var productid = {!! $horoscope_product->id !!}
                },
                always: function() {
                    $(this).prop('disabled', false);
                },
                error: function(err) {
                    alert(err);
                }
            });
        });

        function storeHoroscope(id, obj) {
            userid = '{!! $user ? $user->id : '' !!}'
            const data = {
                user_id: parseInt(userid),
                link_id: id,
                data: obj
            }
            $.ajax({
                type: "POST",
                url: "/birth-chart/store",
                data: data,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    window.location = `/birth-chart/show/${id}`
                },
                error: function(err) {
                    alert(err)
                }
            });
        }
    </script>
</x-app-layout>