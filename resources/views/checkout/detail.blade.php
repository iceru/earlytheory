<x-app-layout>
    @section('title')
    Checkout - {{$sales->sales_no}}
    @endsection
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Detail</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle active"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Sorry !</strong> Terdapat kesalahan dalam input data.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/checkout/{{$sales->sales_no}}/question/add" method="post">
                @csrf
                @if($is_product > 0) 
                <div class="col-12">
                    <div class=" mb-3 pb-2 border-bottom border-dark">
                        <h5 class="evogria">Shipping Address</h5>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 col-lg-6 select-address mb-3">
                            @include('checkout.select-address')
                        </div>
                        <div class="col-12 col-lg-6" style="margin-top: 24px">
                            <a class="button primary inline" href="#" id="newAddress"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i> Add New Address</a>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div id="new" hidden>
                                <div class="form-payment col-12">
                                    <div class="row">
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="inputAddress">Alamat</label>
                                            <input class="form-control" type="text" value="{{ old('address')}}"
                                                name="address" placeholder="Alamat Lengkap">
                                        </div>
                                        <input type="text" name="salesNo" value="{{$sales->sales_no}}" hidden>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="province">Provinsi</label>
                                            <select class="form-select" aria-label="Select Province" name="province"
                                                id="prov">
                                                <option selected disabled>Pilih Provinsi</option>
                                                @foreach ($provinces as $prov)
                                                <option value="{{$prov->province_id}}">{{$prov->province}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="city">Kota / Kabupaten</label>
                                            <select class="form-select" aria-label="Select City" name="city"
                                                id="city">
                                                <option value="" selected disabled>Pilih Provinsi Terlebih Dahulu
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="zip">Kode Pos</label>
                                            <input class="form-control" type="text" value="{{ old('zip')}}"
                                                name="zip">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-grid gap-2">
                                    <div class="d-flex">
                                        <a class="button primary me-3" id="add_address">Add
                                            Address</a>
                                        <a class="button secondary" id="cancel_new_adr">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="loading load-shipping" hidden>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div id="shipping" hidden>
                        @csrf
                        <div class="form-payment col-12 mb-3">
                            <input type="text" name="inputAddress" id="inputAddress" hidden>
                            <div class="row">
                                <div class="form-group mb-0 col-12 col-lg-6">
                                    <label for="inputShipping">Shipping Method</label>
                                    <select class="form-select" aria-label="Select Shipping" name="inputShipping"
                                        id="ship">
                                        <option value="" selected disabled>Pilih Provinsi & Kota/Kab Terlebih Dahulu
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($is_service > 0 || empty($sales->user->phone) || empty($sales->user->birthdate)) 
                <div class="col-12">
                    <div class=" mb-3 pb-2 border-bottom border-dark">
                        <h5 class="evogria">Personal Information</h5>
                    </div>
                </div>
                @endif
                <div class="form-payment col-12 mb-3">
                    <div class="row">
                        @if (empty($sales->user->phone))
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputPhone">Phone Number</label>
                            <input class="form-control" type="text" id="inputPhone" name="inputPhone">
                        </div>
                        @endif
                        @if (empty($sales->user->birthdate))
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputBirthdate">Birthdate</label>
                            <input class="form-control" type="text" id="datepicker" name="inputBirthdate">
                        </div>
                        @endif
                        @if($is_service > 0) 
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputRelationship">Status Relationship</label>
                            <select class="form-select" name="inputRelationship" id="inputRelationship">
                                <option selected disabled>Select</option>
                                <option value="single" @if (old('inputRelationship')=="single" || $sales->relationship
                                    == "single") {{ 'selected' }} @endif>Single</option>
                                <option value="pacaran" @if (old('inputRelationship')=="pacaran" || $sales->relationship
                                    == "pacaran") {{ 'selected' }} @endif>Pacaran</option>
                                <option value="menikah" @if (old('inputRelationship')=="menikah" || $sales->relationship
                                    == "menikah") {{ 'selected' }} @endif>Menikah</option>
                                <option value="divorced" @if (old('inputRelationship')=="divorced" || $sales->
                                    relationship == "divorced") {{ 'selected' }} @endif>Divorced</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputPekerjaan">Status Pekerjaan</label>
                            <select class="form-select" name="inputPekerjaan" id="inputPekerjaan">
                                <option selected disabled>Select</option>
                                <option value="unemployed" @if (old('inputPekerjaan')=="unemployed" || $sales->job ==
                                    "unemployed") {{ 'selected' }} @endif>Unemployed</option>
                                <option value="employed" @if (old('inputPekerjaan')=="employed" || $sales->job ==
                                    "employed") {{ 'selected' }} @endif>Employed</option>
                                <option value="business" @if (old('inputPekerjaan')=="business" || $sales->job ==
                                    "business") {{ 'selected' }} @endif>Business</option>
                                <option value="student" @if (old('inputPekerjaan')=="student" || $sales->job ==
                                    "student") {{ 'selected' }} @endif>Student</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class=" mb-3 pb-2 border-bottom border-dark">
                        <h5 class="evogria">Products</h5>
                    </div>
                </div>
                <div class="products col-12">
                    <div class="row">
                        @foreach ($sales->products as $item)
                        <input type="text" name="id[]" value="{{$item->id}}" hidden>
                        <div class=" col-12 col-lg-6 ">
                            <div class="product-item-container row">
                                <div class="product-title col-12">
                                    <h4>{{$item->title}}</h4>
                                </div>
                                <div class="product-price col-12">
                                    <p>IDR {{number_format($item->price)}}</p>
                                </div>
                                <div class="row g-0">
                                    {{-- <h5 class="primary-color mb-3">Jabarkan Pertanyaanmu Disini</h5> --}}
                                    <div class="col-4 col-lg-3 ">
                                        <div class="product-image">
                                            @foreach ((array)json_decode($item->image) as $image)
                                            <div class="ratio ratio-1x1">
                                                <img src="{{Storage::url('product-image/'.$image)}}" alt="">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-8 col-lg-9 ps-2">
                                        <textarea name="question[]" id="question"
                                            placeholder="Jabarkan Pertanyaanmu Disini.." @if ($item->duration != "0" || $item->category == 'product') hidden @endif>{{$item->pivot->question == ' ' ? '' : $item->pivot->question}}</textarea>

                                        @if ($item->duration != "0" || $item->category == 'product')
                                        <p>{!! $item->description_short !!}</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 d-grid gap-2">
                    <button type="submit" class="button secondary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.product-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
            });
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                altFormat: 'yy/mm/dd',
            });
        });

        var origVal = $('#addressForm').html();
        
        $('#newAddress').on('click', function (event) {
            event.preventDefault();
            $('#new').removeAttr('hidden');
            $(this).parent().attr('hidden', 'hidden');
        });

        $('#cancel_new_adr').on('click', function (event) {
            event.preventDefault();
            $('#new').attr('hidden', 'hidden');
            $('#newAddress').parent().removeAttr('hidden');
        });

        $("#prov").on('change', function () {
            var prov_id=$(this).val();
            var cityopt="";
            console.log(prov_id);
            $.ajax({
                type:'get',
                url:'{!! URL::to('checkout/findCityShipping') !!}',
                data:{'id':prov_id},
                success:function(data) {
                    cityopt += '<option value="" selected disabled>Pilih Kota / Kabupaten</option>';
                    for (var i=0; i<data.length; i++) {
                        cityopt += '<option value="'+data[i].city_id+'">'+data[i].type+' '+data[i].city_name+'</option>';
                    }
                    $('#city').html(cityopt);
                }
            })
        });

        $('#add_address').click(function (e) { 
            e.preventDefault();
            var address = $("input[name=address]").val();
            var city = $("select[name=city] :selected").val();
            var province = $("select[name=province] :selected").val();
            var zip = $("input[name=zip]").val();
            $.ajax({
                type:'POST',
                url:"{!! URL::to('address/add-checkout') !!}",
                data:{address: address, city: city, province: province, zip: zip},
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data) {
                    $('#new').attr('hidden', 'hidden');
                    $('#newAddress').parent().removeAttr('hidden');
                    const Toast = Swal.mixin({
                        toast:true,
                        position: 'top',
                        showConfirmButton:false,
                        timer: 4000,
                        timerProgressBar: true,
                    })

                    if($.isEmptyObject(data.error)){
                        Toast.fire({
                            icon: 'success',
                            title: data.success
                        })
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: data.error
                        })
                    }

                    updateAddress();
                }, fail:function(data) {
                    console.log(data);
                }
            })
        });

        function updateAddress() {
            $('.load-address').removeAttr('hidden');
            $('.form-payment').attr('hidden', 'hidden');

            $.ajax({
                type: 'GET',
                url: "{{ route('address.update-address') }}",
            }).done(function(data){
                $('.select-address').html(data.html);
            }).always(function() {
                $('.form-payment').removeAttr('hidden');
                $('.load-address').attr('hidden', 'hidden');
                $('#shipping').attr('hidden', 'hidden');
            })
        }

        $(".select-address").on('change', '#addressSelect', function () {
            $('#shipping').attr('hidden', 'hidden');
            $('.load-shipping').removeAttr('hidden');
            var addressSelect=$('#addressSelect').val();
            var shipopt="";

            $.ajax({
                type:'get',
                url:'{!! URL::to('checkout/checkShippingCost') !!}',
                data:{'id':addressSelect}
            }).done(function(data) {
                console.log(data);
                $('#shipping').removeAttr('hidden');
                shipopt += '<option value="" selected disabled>Select Shipping</option>';
                for (var i=0; i<data.length; i++) {
                    shipopt += '<option value="'+data[i].cost[0].value+'-'+data[i].courier+' '+data[i].service+'">'+data[i].courier+' '+data[i].service+' / '+data[i].cost[0].etd+' Day(s) : Rp '+data[i].cost[0].value+'</option>';
                }
                $('#inputAddress').val(addressSelect);
                $('#ship').html(shipopt);
            }).always(function() {
                $('.load-shipping').attr('hidden', 'hidden');
            })
        });
    </script>
</x-app-layout>