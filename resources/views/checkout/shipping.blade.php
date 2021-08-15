<x-app-layout>
    @section('title')
        Checkout - {{$sales->sales_no}}
    @endsection
    <div class="col-12 checkout">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Shipping</h1>
            </div>
            <div class="col-12 indicator">
                <div class="circle"></div>
                <div class="line"></div>
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
            <form action="/checkout/{{$sales->sales_no}}/shipping/add" method="post">
                @csrf
                <div class="form-payment col-12 mb-3">
                   <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputAddress">Alamat</label>
                        <input class="form-control" type="text" value="{{ old('inputAddress')}}" name="inputAddress" required>
                    </div>
                    <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputProvince">Provinsi</label>
                        <select class="form-select" aria-label="Select Province" name="inputProvince" id="prov">
                            <option selected disabled>Pilih Provinsi</option>
                            @foreach ($provinces as $prov)
                            <option value="{{$prov->province_id}}">{{$prov->province}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputCity">Kota / Kabupaten</label>
                        <select class="form-select" aria-label="Select City" name="inputCity" id="city">
                            <option value="" selected disabled>Pilih Provinsi Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputZip">Kode Pos</label>
                        <input class="form-control" type="text" value="{{ old('inputZip')}}" name="inputZip" required>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputShipping">Shipping</label>
                        <select class="form-select" aria-label="Select Shipping" name="inputShipping" id="ship">
                            <option value="" selected disabled>Pilih Provinsi & Kota/Kab Terlebih Dahulu</option>
                        </select>
                    </div>
                   </div>
                </div>
                <div class="col-12 d-grid gap-2">
                    {{-- <a class="button secondary" href="/checkout/summary">
                        Go to Summary
                    </a> --}}
                    <button type="submit" class="button secondary">Konfirmasi</button>
                </div>
            </form>
    </div>

    <script>

        $(document).ready(function(){
            $('.product-image').slick({
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
            });
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

        
        $("#city").on('change', function () {
            var city_id=$(this).val();
            var shipopt="";
            $.ajax({
                type:'get',
                url:'{!! URL::to('checkout/checkShippingCost') !!}',
                data:{'id':city_id},
                success:function(data) {
                    console.log('success');
                    console.log(data);
                    shipopt += '<option value="" selected disabled>Select Shipping</option>';
                    for (var i=0; i<data.length; i++) {
                        shipopt += '<option value="'+data[i].cost[0].value+'-JNE '+data[i].service+'">JNE '+data[i].service+' ('+data[i].cost[0].etd+' Days) : Rp '+data[i].cost[0].value+'</option>';
                    }
                    $('#ship').html(shipopt);
                }
            })
        });
    </script>
</x-app-layout>
