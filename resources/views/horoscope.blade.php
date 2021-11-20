<x-app-layout>
    @section('title')
    Horoscopes
    @endsection
    <div class="col-12 main-content">
        <div class="row ">
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
                    <button style="width: 100%" id="submitHoroscope" class="button primary expanded">Get your Chart</button>
                </div>
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

            $.ajax({
                type: "POST",
                url: "/horoscope/natal",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: data,
                
                success: function (response) {
                    console.log(response.data);
                }
            });
        });

        // function delay(callback, ms) {
        //     var timer = 0;
        //     return function() {
        //         var context = this, args = arguments;
        //         clearTimeout(timer);
        //         timer = setTimeout(function () {
        //         callback.apply(context, args);
        //         }, ms || 0);
        //     };
        // }

        // $('#birthplace').keyup(delay(function (e) {
        //     places(this.value);
        // }, 500));

        // function places(place) {
        //     $.ajax({
        //         type: "POST",
        //         url: "/horoscope/places",
        //         headers: {
        //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //         },
        //         data: {"name": place},
                
        //         success: function (response) {
        //             autocomplete(response.data)
        //         }
        //     });
        // }
    </script>
</x-app-layout>