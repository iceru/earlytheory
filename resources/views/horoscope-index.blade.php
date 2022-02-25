<div class="pb-5">
    <div class="row input-horoscope">
    @if (!$user)
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p>Login sekarang untuk mendapatkan fitur autofill form dan hasil Birth Chart dapat langsung diakses pada Page Account. <a href="/login"><strong>Login Disini</strong></a></p> 
        </div>
    </div>
    @endif
    <div class="row form-horoscopes">
        <div class="col-12 col-lg-6 mb-3">
            <div>
                <label for="" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ $user ? $user->name : "" }}">
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-3">
            <div>
                <label for="" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ $user ? $user->email : "" }}">
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-3">
            <div>
                <label for="" class="form-label">Tanggal Lahir</label>
                <input  type="text" class="form-control" name="birthdate" id="datepicker" placeholder="" value="{{ $user ? \Carbon\Carbon::parse($user->birthdate)->toDateString() : "" }}" readonly>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div>
                <label for="" class="form-label">Waktu Lahir</label>
                <input  type="time" class="form-control" name="birthtime" id="birthtime" placeholder="">
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div class="birthplace-wrapper">
                <label for="" class="form-label">Tempat Lahir</label>
                <input  type="text" class="form-control" name="birthplace" id="birthplace" placeholder="" autocomplete="false">
                <div class="spinner">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                </div>
            </div>
        </div>
        <div class="col-12" >
            <button style="width: 100%" id="submitHoroscope" class="button primary expanded text-uppercase">
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" hidden></span>
                Get your Chart
            </button>
        </div>
    </div>
</div>

<div class="results">
    <div class=" row">
        <div class="horoscope-detail">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="header">
                    </div>
                    <div class="row planets">
                    </div>
                </div>
                <div class="col-12 col-lg-6 image-wrapper wheel">
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    var alertList = document.querySelectorAll('.alert');
    alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
    })
    
    var place;
    var birthplace;
    var user = '{!! $user !!}'
    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "1970:2004",
            dateFormat: 'yy-mm-dd',
        });
        history.replaceState('', '', '/');
        $('.results').hide();
        $("#birthplace").autocomplete({
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
                $('#birthplace').val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                birthplace = ui.item.id
                return false;
            },
            minLength: 3
        })
    });

    $('#submitHoroscope').click(function (e) { 
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var birthdate = $('#datepicker').val();
        var birthtime = $('#birthtime').val();

        debugger;

        if(name === '' || email === '' || birthdate === '' || birthtime === '') {
            Swal.fire({
                icon: "error",
                title: "Isi form terlebih dahulu",
            });
            return
        }

        if(!birthplace) {
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

                history.pushState({
                    horoscope: obj,
                }, null, `horoscope/show/${uid}`);

                if(user) {
                    storeHoroscope(uid, obj)
                }

                $('.input-horoscope').hide();
                $('.results').show();
                $('.header').append(`
                    <div class="hr-name">
                        ${obj.profile.name}
                    </div>
                    <div class="hr-desc">
                        <div class="hr-date">
                            <p>${obj.profile.birthdate.date}
                            </p>
                        </div>
                        <div class="hr-city">
                            <p>${obj.profile.cityName}</p>
                        </div>
                    </div>
                `);
            
                obj.planets.forEach(item => {
                    $(".planets").append(`
                        <div class="col-12 col-lg-6">
                            <div class="planet">
                                <p class="planet-degree">${item.degrees}&#176; ${item.minutes}" ${item.seconds}'</p>
                                <div class="planet-name">
                                    <span>${item.planetName}</span>
                                </div>
                                <div class="planet-house">House Position: ${item.housePosition}</div>
                                <p>Sign Name: ${item.signName}</p>
                                ${item.retrograde ? `<p class="planet-retrograde">Retrograde</p>` : ``}
                            </div>
                        </div>
                    `)
                });

                $('.wheel').append(`<img src="${obj.wheel}" class="w-100 hr-chart" alt="Wheel Natal Chart ${obj.profile.name}" />`);

                var productid = {!! $horoscope_product->id !!}
                $('.atc').append(`<div data-id="${productid}" class="button primary my-3 addcart">Ingin Tau Lebih Lanjut? Masukan Ke Keranjang</div>`)
            },
            always: function() {
                $(this).prop('disabled', false);
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
                console.log(response)
            },
            error: function(err) {
                console.log(err)
            }
        });
    }
</script>