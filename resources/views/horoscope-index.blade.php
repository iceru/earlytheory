<div class="pb-5">
    <div class="row input-horoscope">
    @if (!$user)
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p>Login sekarang untuk menyimpan hasil Birth Chart ke akun anda. <a href="/login"><strong>Login Disini</strong></a></p> 
        </div>
    </div>
    @endif
    <div class="form-horoscopes">
        <div class="row">
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
</div>
{{-- 
<div class="results">
    <div class=" row">
        <div class="horoscope-detail">
            <div class="row align-items-center header-horoscope mb-5">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row planets"></div>
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
                            <tbody class="aspects">
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div> --}}
</div>



<script>
    var birthplace;
    var birthplaceLabel;

    var user = '{!! $user !!}'
    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "1970:2004",
            dateFormat: 'yy-mm-dd',
            defaultDate: "-22y"
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
                        console.log(results.slice(0, 10));
                    },
                });
            },
            focus: function(event, ui) {
                $('#birthplace').val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                birthplace = ui.item.id;
                birthplaceLabel = ui.item.label;
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
            
            success: function (response) {
                // const obj = JSON.parse(response);
                const uid = Date.now().toString(36) + Math.random().toString(36).substr(2);
                
                storeHoroscope(uid, response, name, email)
            },
            always: function() {
                $(this).prop('disabled', false);
            },
            error: function(err) {
                alert('There is an Error: '+err.message);
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
            success: function (response) {
                window.location = `/birth-chart/show/${id}`
            },
            error: function(err) {
                alert('There is an Error: '+err.message)
            }
        });
    }
</script>