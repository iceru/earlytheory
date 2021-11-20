<x-app-layout>
    @section('title')
    Horoscopes
    @endsection
    <div class="col-12 main-content">
        <div class="row input-horoscope">
            <div class="col-12 text-center mb-5">
                <h2 class="evogria">Horoscopes</h2>
            </div>
            <div class="row form-horoscopes">
                <div class="col-12 col-lg-6 mb-3">
                    <div>
                        <label for="" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="">
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <div>
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="">
                    </div>
                </div>
                <div class="col-12 col-lg-4 mb-3">
                    <div>
                        <label for="" class="form-label">Birth Date</label>
                        <input  type="text" class="form-control" name="birthdate" id="datepicker" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mb-4">
                    <div>
                        <label for="" class="form-label">Birth Time</label>
                        <input  type="time" class="form-control" name="birthtime" id="birthtime" placeholder="">
                    </div>
                </div>
                <div class="col-12 col-lg-4 mb-4">
                    <div>
                        <label for="" class="form-label">Birth Place</label>
                        <input  type="text" class="form-control" name="birthplace" id="birthplace" placeholder="">
                    </div>
                </div>
                <div class="col-12" >
                    <button style="width: 100%" id="submitHoroscope" class="button primary expanded">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Get your Chart
                    </button>
                </div>
            </div>
        </div>

        <div class="results row">
            <div class="col-12 col-lg-5">
                <div class="identity mb-5">
                </div>
                <div class="row planets">
                </div>
            </div>
            <div class="col-12 col-lg-7 wheel">
            </div>
        </div>
    </div>

    <script>
        var place;
        var birthplace;
        $(document).ready(function(){
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                dateFormat: 'yy-mm-dd',
            });
            $('results').hide();
            $("#birthplace").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        url: "/horoscope/places",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {"name": request.term},
                        
                        success: function (data) {
                            console.log(data.data);
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

            var data = {
                "name": name,
                "date": birthdate,
                "time": birthtime,
                "place_id": birthplace,
                "email": email,
            }

            $(this).prop('disabled', true);
            $('.spinner-border').removeAttr('hidden');

            $.ajax({
                type: "POST",
                url: "/horoscope/natal",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: data,
                
                success: function (response) {
                    console.log(response);
                    history.pushState({
                        horoscope: response,
                    }, null, `natal/${response.intro.id}`)
                    $('.input-horoscope').hide();
                    $('.results').show();
                    $('.identity').append(`
                        <h5 class="skylar primary-color mb-1">Nama: ${response.profile.name}</h5>
                        <p>Tempat Lahir: ${response.profile.cityName}</p>
                        <p>Tanggal Lahir: ${response.profile.birthdate.date.slice(0,16)}</p>
                    `);
                   
                    response.planets.forEach(item => {
                        $(".planets").append(`
                            <div class="col-12 col-lg-6 mb-4">
                                <h3 class="skylar primary-color">${item.planetName}</h5>
                                <h5 class="primary-color">House Position: ${item.housePosition}</h5>
                                <p>${item.degrees}&#176; ${item.minutes}" ${item.seconds}'</p>
                                <p>Sign Name: ${item.signName}</p>
                                <p>Retrogade: ${item.retrograde}</p>
                            </div>
                        `)
                    });

                    $('.wheel').append(`<img src="${response.wheel}" class="w-100" alt="Wheel Natal Chart ${response.profile.name}" />`);
                },
                always: function() {
                    $(this).prop('disabled', false);
                }
            });
        });
    </script>
</x-app-layout>