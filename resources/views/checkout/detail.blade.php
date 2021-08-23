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
                <div class="form-payment col-12 mb-3">
                   <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputName">Nama Lengkap</label>
                        <input class="form-control" type="text" value="{{ old('inputName', optional($user)->name) }}" name="inputName" required>
                    </div>
                    <input type="text" name="salesId" value="{{$sales->id}}" hidden>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="inputEmail" value="{{ old('inputEmail', optional($user)->email) }}" class="form-control" required>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputPhone">Nomor Telepon</label>
                        <input type="tel" class="form-control" value="{{ old('inputPhone', optional($user)->phone) }}" name="inputPhone" required>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputBirthdate">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{ old('inputBirthdate', optional($user)->birthdate) }}" name="inputBirthdate" id="datepicker" required autocomplete="off">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label for="inputRelationship">Status Relationship</label>
                        <select class="form-select" name="inputRelationship" id="inputRelationship">
                            <option selected disabled>Select</option>
                            <option value="single"  @if (old('inputRelationship') == "single" || $user->relationship == "single") {{ 'selected' }} @endif>Single</option>
                            <option value="pacaran"  @if (old('inputRelationship') == "pacaran" || $user->relationship == "pacaran") {{ 'selected' }} @endif>Pacaran</option>
                            <option value="menikah" @if (old('inputRelationship') == "menikah" || $user->relationship == "menikah") {{ 'selected' }} @endif>Menikah</option>
                            <option value="divorced" @if (old('inputRelationship') == "divorced" || $user->relationship == "divorced") {{ 'selected' }} @endif>Divorced</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-lg-6">
                      <label for="inputPekerjaan">Status Pekerjaan</label>
                      <select class="form-select" name="inputPekerjaan" id="inputPekerjaan">
                            <option selected disabled>Select</option>
                            <option value="unemployed" @if (old('inputPekerjaan') == "unemployed" || $user->job == "unemployed") {{ 'selected' }} @endif>Unemployed</option>
                            <option value="employed" @if (old('inputPekerjaan') == "employed" || $user->job == "employed") {{ 'selected' }} @endif>Employed</option>
                            <option value="business" @if (old('inputPekerjaan') == "business" || $user->job == "business") {{ 'selected' }} @endif>Business</option>
                            <option value="student"  @if (old('inputPekerjaan') == "student" || $user->job == "student") {{ 'selected' }} @endif>Student</option>
                      </select>
                    </div>
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
                                    <p>idr {{number_format($item->price)}}</p>
                                </div>
                               <div class="row g-0">
                                {{-- <h5 class="primary-color mb-3">Jabarkan Pertanyaanmu Disini</h5> --}}
                                <div class="col-4 col-lg-3 product-image">
                                    @foreach ((array)json_decode($item->image) as $image)
                                        <img src="{{Storage::url('product-image/'.$image)}}" alt="">
                                    @endforeach
                                </div>
                                <div class="col-8 col-lg-9 ps-2" @if ($item->duration != "0") hidden @endif>
                                    <textarea name="question[]" id="question" placeholder="Jabarkan Pertanyaanmu Disini..">{{$item->pivot->question == ' ' ? '' : $item->pivot->question}}</textarea>
                                </div>
                               </div>
                            </div>
                        </div>
                        @endforeach
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
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:2021",
                altFormat: 'yy/mm/dd',
            });
        });
    </script>
</x-app-layout>
