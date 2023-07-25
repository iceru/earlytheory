<x-app-layout>
    @section('title')
        Birth Chart - Show
    @endsection

    @section('additional_header')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
            integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"
            integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
            integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endsection

    <div class="horoscope-detail">
        <div class="row align-items-center mb-3">
            <div class="col-12 col-lg-6 image-wrapper text-center">
                <a class="popup-image" href="{{ Storage::url('horoscopes/horoscope_' . $horoscope->link_id . '.svg') }}">
                    <img class="hr-chart"
                        src="{{ Storage::url('horoscopes/horoscope_' . $horoscope->link_id . '.svg') }}"
                        alt="{{ $horoscope->data['profile']['name'] }} Wheel">
                </a>
            </div>
            <div class="col-12 col-lg-6">
                <div class="header">
                    <div class="hr-name">
                        {{ $horoscope->data['profile']['name'] }}
                        <span><a href="#" class="edit-button" id="edit_button"><i
                                    class="fas fa-edit"></i></a></span>
                    </div>
                    <div class="row birth-date">
                        <div class="col-4">
                            {{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->format('j M
                                                                                                                Y') }}
                        </div>
                        <div class="col-4">
                            {{ \Carbon\Carbon::parse($horoscope->data['profile']['birthdate']['date'])->format('g:i
                                                                                                                A') }}
                        </div>
                        <div class="col-4">
                            <p>{{ $horoscope->data['profile']['cityName'] }}</p>
                        </div>
                    </div>
                    <div class="mt-3 notes">
                        <p>Natal Chart ini menggunakan system [Placidus] sehingga ukuran house tidak sejajar dengan area
                            zodiak. Whole Sign House System coming soon.</p>
                    </div>
                    {{-- <div>
                        <div style="display: inline-flex" class="button primary mt-3" id="edit_button">Edit <i
                                class="fas fa-edit fa-fw ms-2"></i></div>
                    </div> --}}
                    <div class="row form-horoscope-edit mt-3">
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder=""
                                    value="{{ $user ? $user->name : $horoscope->name }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <div>
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder=""
                                    value="{{ $user ? $user->email : $horoscope->email }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <div>
                                <label for="" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" name="birthdate" id="datepicker"
                                    placeholder=""
                                    value="{{ $user ? \Carbon\Carbon::parse($user->birthdate)->toDateString() : '' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div>
                                <label for="" class="form-label">Waktu Lahir</label>
                                <input type="time" class="form-control" name="birthtime" id="birthtime"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="birthplace-wrapper">
                                <label for="" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="birthplace" id="birthplace"
                                    placeholder="" autocomplete="false">
                                <div class="spinner">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                        hidden></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <button style="width: 100%" class="button secondary expanded" id="cancel">Cancel</button>
                        </div>
                        <div class="col-6">
                            <button style="width: 100%" id="edit_horoscope" class="button primary expanded">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"
                                    hidden></span>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-3" id="planets">
            <div class="col-12">
                <div class="row">
                    @foreach (array_slice($horoscope->data['planets'], 0, 2) as $planet)
                        <div class="col-6 col-lg-4 screenshot">
                            <div class="row planet">
                                <div class="col-4">
                                    <img class="w-100" src={{ '/images/planets/' . $planet['planetName'] . '.png' }}
                                        alt="{{ $planet['planetName'] }}">
                                </div>
                                <div class="col-8">
                                    <div class="title">
                                        <div class="planet-name">{{ $planet['planetName'] }}</div>
                                        <div class="planet-degree">{{ $planet['degrees'] }}&#176;
                                            {{ $planet['minutes'] }}"
                                            {{ $planet['seconds'] }}'</div>
                                    </div>
                                    <div class="planet-sign">
                                        {{ $planet['signName'] }}
                                    </div>
                                    <div class="planet-house">House {{ $planet['housePosition'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (isset($horoscope->data['ascendant']))
                        <div class="col-6 col-lg-4 screenshot">
                            <div class="row planet">
                                <div class="col-4">
                                    <img class="w-100" src={{ '/images/planets/Ascendant.png' }} alt="Ascendant">
                                </div>
                                <div class="col-8">
                                    <div class="title">
                                        <div class="planet-name">Ascendant</div>
                                        <div class="planet-degree">
                                            {{ $horoscope->data['ascendant']['degrees'] }}&#176;
                                            {{ $horoscope->data['ascendant']['minutes'] }}"
                                            {{ $horoscope->data['ascendant']['seconds'] }}'</div>
                                    </div>
                                    <div class="planet-sign">
                                        {{ $horoscope->data['ascendant']['signName'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (isset($horoscope->data['midheaven']))
                        <div class="col-6 col-lg-4 screenshot">
                            <div class="row planet">
                                <div class="col-4">
                                    <img class="w-100" src={{ '/images/planets/Midheaven.png' }} alt="Midheaven">
                                </div>
                                <div class="col-8">
                                    <div class="title">
                                        <div class="planet-name">Midheaven</div>
                                        <div class="planet-degree">
                                            {{ $horoscope->data['midheaven']['degrees'] }}&#176;
                                            {{ $horoscope->data['midheaven']['minutes'] }}"
                                            {{ $horoscope->data['midheaven']['seconds'] }}'</div>
                                    </div>
                                    <div class="planet-sign">
                                        {{ $horoscope->data['midheaven']['signName'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach (array_slice($horoscope->data['planets'], 2, 12) as $planet)
                        <div class="col-6 col-lg-4">
                            <div class="row planet">
                                @if ($planet['planetName'])
                                    <div class="col-4">
                                        <img class="w-100"
                                            src={{ '/images/planets/' . str_replace(' ', '', $planet['planetName']) . '.png' }}
                                            alt="{{ $planet['planetName'] }}">
                                    </div>
                                @endif
                                <div class="col-8">
                                    <div class="title">
                                        <div class="planet-name">{{ $planet['planetName'] }}</div>
                                        <div class="planet-degree">{{ $planet['degrees'] }}&#176;
                                            {{ $planet['minutes'] }}"
                                            {{ $planet['seconds'] }}'</div>
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
                                <th>Planet</th>
                                <th>Aspect</th>
                                <th>Planet</th>
                                <th>Orb</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horoscope->data['aspects'] as $aspect)
                                @if (!empty($aspect['planet1Name']))
                                    <tr>
                                        <td>{{ $aspect['planet1Name'] }}</td>
                                        <td>{{ $aspect['aspectName'] }}</td>
                                        <td>{{ $aspect['planet2Name'] }}</td>
                                        <td>{{ $aspect['degrees'] }}&#176;
                                            {{ Str::substr($aspect['seconds'], 0, 2) }}'</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="sliders mt-5">
            @foreach ($sliders as $slider)
                <a href="{{ $slider->link }}">
                    <div class="slider-item">
                        <img src="{{ Storage::url('sliders-image/' . $slider->image) }}" alt="">
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <script>
        var birthplaceLabel;
        var birthplace;

        $('.screenshot').click(function(e) {
            html2canvas(document.getElementById("planets"), {
                allowTaint: true,
                useCORS: true
            }).then(function(canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                anchorTag.download = "Birth Chart.jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
        });

        $(document).ready(function() {
            $('.sliders').slick({
                dots: true
            });

            $('.popup-image').magnificPopup({
                type: 'image'
                // other options
            });
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1960:2012",
                dateFormat: 'yy-mm-dd',
                defaultDate: "-22y"
            });
            $('.form-horoscope-edit').hide();

            $("#birthplace").autocomplete({
                source: function(request, response) {
                    $('.birthplace-wrapper .spinner-border').removeAttr('hidden');
                    $.ajax({
                        type: "POST",
                        url: "/birth-chart/places",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {
                            "name": request.term
                        },

                        success: function(data) {
                            $('.birthplace-wrapper .spinner-border').attr('hidden', true);
                            var results = $.map(data.data, function(item, key) {
                                return {
                                    label: item.name + ', ' + item.admin1_code +
                                        ', ' + item.timezone,
                                    id: item.id
                                }
                            })
                            response(results.slice(0, 10));
                        },
                    });
                },
                focus: function(event, ui) {
                    $('#birthplace').val(ui.item.label);
                    return false;
                },
                select: function(event, ui) {
                    birthplace = ui.item.id
                    birthplaceLabel = ui.item.label;

                    return false;
                },
                minLength: 3
            })
        });
        var user = '{!! $user !!}'

        $('#edit_button').click(function(e) {
            e.preventDefault();
            $(this).hide();
            $('.form-horoscope-edit').show();
            $('.birth-date').hide();
        });

        $('#cancel').click(function(e) {
            e.preventDefault();
            $('.form-horoscope-edit').hide();
            $('#edit_button').show();
            $('.birth-date').show();
        });

        $('#edit_horoscope').click(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var birthdate = $('#datepicker').val();
            var birthtime = $('#birthtime').val();

            if (name === '' || email === '' || birthdate === '' || birthtime === '') {
                Swal.fire({
                    icon: "error",
                    title: "Isi form terlebih dahulu",
                });
                return
            }

            if (!birthplace) {
                Swal.fire({
                    icon: "error",
                    title: "Tempat kelahiran belum diisi dengan benar",
                });
                return
            }

            var data = {
                "name": name,
                "date": birthdate,
                "time": birthtime,
                "place_id": birthplace,
                "email": email,
                "wheelSettings": {
                    "POINTS_TEXT_SIZE": 14,
                    "SYMBOL_SCALE": 1.5,
                    "COLOR_BACKGROUND": "#e7e7e7",

                    "SIGNS_COLOR_ARIES": "#FFF",
                    "SIGNS_COLOR_TAURUS": "#FFF",
                    "SIGNS_COLOR_GEMINI": "#FFF",
                    "SIGNS_COLOR_CANCER": "#FFF",
                    "SIGNS_COLOR_LEO": "#FFF",
                    "SIGNS_COLOR_VIRGO": "#FFF",
                    "SIGNS_COLOR_LIBRA": "#FFF",
                    "SIGNS_COLOR_SCORPIO": "#FFF",
                    "SIGNS_COLOR_SAGITTARIUS": "#FFF",
                    "SIGNS_COLOR_CAPRICORN": "#FFF",
                    "SIGNS_COLOR_AQUARIUS": "#FFF",
                    "SIGNS_COLOR_PISCES": "#FFF",

                    "BACKGROUND_ARIES": "#4A2984",
                    "BACKGROUND_TAURUS": "#4A2984",
                    "BACKGROUND_GEMINI": "#4A2984",
                    "BACKGROUND_CANCER": "#4A2984",
                    "BACKGROUND_LEO": "#4A2984",
                    "BACKGROUND_VIRGO": "#4A2984",
                    "BACKGROUND_LIBRA": "#4A2984",
                    "BACKGROUND_SCORPIO": "#4A2984",
                    "BACKGROUND_SAGITTARIUS": "#4A2984",
                    "BACKGROUND_CAPRICORN": "#4A2984",
                    "BACKGROUND_AQUARIUS": "#4A2984",
                    "BACKGROUND_PISCES": "#4A2984",
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

                success: function(response) {
                    // const obj = JSON.parse(response);
                    const uid = Date.now().toString(36) + Math.random().toString(36).substr(2);
                    // console.log(obj);
                    storeHoroscope(uid, response, name, email)
                },
                always: function() {
                    $(this).prop('disabled', false);
                },
                error: function(err) {
                    alert(err.message);
                }
            });
        });

        function storeHoroscope(id, obj, name, email) {
            userid = '{!! $user ? $user->id : '' !!}'
            userIdStore = userid ? parseInt(userid) : null
            var birthplaceData = {
                id: birthplace,
                label: birthplaceLabel
            }

            var birthplaces = JSON.stringify(birthplaceData);

            const data = {
                user_id: userIdStore,
                link_id: id,
                name: name,
                email: email,
                places: birthplaces,
                data: obj,
            }
            $.ajax({
                type: "POST",
                url: "/birth-chart/store",
                data: data,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    window.location = `/birth-chart/show/${id}`
                },
                error: function(err) {
                    alert(err.message)
                }
            });
        }
    </script>
</x-app-layout>
