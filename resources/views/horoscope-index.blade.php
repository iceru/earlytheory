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
    // var alertList = document.querySelectorAll('.alert');
    // alertList.forEach(function (alert) {
    //     new bootstrap.Alert(alert)
    // })
    
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
                "COLOR_BACKGROUND": "#4A2984",
                "POINTS_COLOR": "#FFF",
                "SIGNS_COLOR": "#FFF"
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

                // history.pushState({
                //     horoscope: obj,
                // }, null, `/birth-chart/show/${uid}`);
                
                storeHoroscope(uid, obj)

                // const birth = new Date(obj.profile.birthdate.date);
                // const birthDateText = birth.toLocaleDateString([], { day: 'numeric', month: 'short', year: 'numeric'}).replace(/\//g, ' ');;
                // const birthTimeText = birth.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})
                // $('.input-horoscope').hide();
                // $('.results').show();
                // $('.header-horoscope').append(`
                //     <div class="col-12 col-lg-6 image-wrapper text-center">
                //         <img class="hr-chart" src="${obj.wheel}"
                //             alt="${obj.profile.name} Wheel">
                //     </div>
                //     <div class="col-12 col-lg-6">
                //         <div class="header">
                //             <div class="hr-name">
                //                 ${obj.profile.name}
                //             </div>
                //             <div class="row birth-date">
                //                 <div class="col-4">
                //                     ${birthDateText}
                //                 </div>
                //                 <div class="col-4">
                //                     ${birthTimeText}
                //                 </div>
                //                 <div class="col-4">
                //                     <p>${obj.profile.cityName}</p>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // `);
            
                // obj.planets.slice(0,2).forEach(item => {
                //     $(".planets").append(`
                //         <div class="col-6 col-lg-4">
                //             <div class="row planet">
                //                 <div class="col-4">
                //                     <img class="w-100" src="/images/planets/${item.planetName}.png" alt="${item.planetName}">
                //                 </div>
                //                 <div class="col-8">
                //                     <div class="title">
                //                         <div class="planet-name">${item.planetName}</div>
                //                         <div class="planet-degree">${item.degrees} &#176; ${item.minutes}" 
                //                             ${item.seconds}'</div>
                //                     </div>
                //                     <div class="planet-sign">
                //                         ${item.signName}
                //                     </div>
                //                     <div class="planet-house">House ${item.housePosition}</div>
                //                 </div>
                //             </div>
                //         </div>
                //     `)
                // });
                // $('.planets').append(`
                //     <div class="col-6 col-lg-4">
                //         <div class="row planet">
                //             <div class="col-4">
                //                 <img class="w-100" src='/images/planets/Ascendant.png' alt="Ascendant">
                //             </div>
                //             <div class="col-8">
                //                 <div class="title">
                //                     <div class="planet-name">Ascendant</div>
                //                     <div class="planet-degree">${obj.ascendant.degrees} &#176; ${obj.ascendant.minutes}" 
                //                         ${obj.ascendant.seconds}'</div>
                //                 </div>
                //                 <div class="planet-sign">
                //                     ${obj.ascendant.signName}
                //                 </div>
                //                 <div class="planet-house">House ${obj.ascendant.housePosition}</div>
                //             </div>
                //         </div>
                //     </div>
                //     <div class="col-6 col-lg-4">
                //         <div class="row planet">
                //             <div class="col-4">
                //                 <img class="w-100" src='/images/planets/Midheaven.png' alt="Midheaven">
                //             </div>
                //             <div class="col-8">
                //                 <div class="title">
                //                     <div class="planet-name">Midheaven</div>
                //                     <div class="planet-degree">${obj.midheaven.degrees} &#176; ${obj.midheaven.minutes}" 
                //                         ${obj.midheaven.seconds}'</div>
                //                 </div>
                //                 <div class="planet-sign">
                //                     ${obj.midheaven.signName}
                //                 </div>
                //                 <div class="planet-house">House ${obj.midheaven.housePosition}</div>
                //             </div>
                //         </div>
                //     </div>
                // `)
                // obj.planets.slice(2,12).forEach(item => {
                //     $(".planets").append(`
                //         <div class="col-6 col-lg-4">
                //             <div class="row planet">
                //                 <div class="col-4">
                //                     <img class="w-100" src=/images/planets/${item.planetName}.png alt="${item.planetName}">
                //                 </div>
                //                 <div class="col-8">
                //                     <div class="title">
                //                         <div class="planet-name">${item.planetName}</div>
                //                         <div class="planet-degree">${item.degrees} &#176; ${item.minutes}" 
                //                             ${item.seconds}'</div>
                //                     </div>
                //                     <div class="planet-sign">
                //                         ${item.signName}
                //                     </div>
                //                     <div class="planet-house">House ${item.housePosition}</div>
                //                 </div>
                //             </div>
                //         </div>
                //     `)
                // });

                // obj.aspects.forEach(item => {
                //     $('.aspects').append(`
                //         <tr>
                //             <td class="image"><img src="/images/planets/${item.planet1Name}.png" alt="${item.planet1Name}"></td>
                //             <td>${item.planet1Name}</td>
                //             <td>${item.aspectName}</td>
                //             <td class="image"><img src="/images/planets/${item.planet2Name}.png" alt="${item.planet2Name}"></td>
                //             <td>${item.planet2Name}</td>
                //             <td>${item.degrees}&#176; ${item.seconds.slice(0,2)}'</td>
                //         </tr>
                //     `)
                // });

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
            data: obj,
            name: name,
            email: email,
            places: birthplace
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