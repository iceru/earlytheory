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
                        @if (empty($sales->phone))
                            <div class="form-group col-12 col-lg-6">
                                <label for="inputPhone">Phone Number</label>
                                <input class="form-control" type="text" id="inputPhone" name="inputPhone">
                            </div>
                        @endif
                        @if (empty($sales->birthdate))
                            <div class="form-group col-12 col-lg-6">
                                <label for="inputBirthdate">Birthdate</label>
                                <input class="form-control" type="text" id="datepicker" name="inputBirthdate">
                            </div>
                        @endif
                        <div class="form-group col-12 col-lg-6">
                            <label for="inputRelationship">Status Relationship</label>
                            <select class="form-select" name="inputRelationship" id="inputRelationship">
                                <option selected disabled>Select</option>
                                <option value="single"  @if (old('inputRelationship') == "single" || $sales->user->relationship == "single") {{ 'selected' }} @endif>Single</option>
                                <option value="pacaran"  @if (old('inputRelationship') == "pacaran" || $sales->user->relationship == "pacaran") {{ 'selected' }} @endif>Pacaran</option>
                                <option value="menikah" @if (old('inputRelationship') == "menikah" || $sales->user->relationship == "menikah") {{ 'selected' }} @endif>Menikah</option>
                                <option value="divorced" @if (old('inputRelationship') == "divorced" || $sales->user->relationship == "divorced") {{ 'selected' }} @endif>Divorced</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-lg-6">
                        <label for="inputPekerjaan">Status Pekerjaan</label>
                        <select class="form-select" name="inputPekerjaan" id="inputPekerjaan">
                                <option selected disabled>Select</option>
                                <option value="unemployed" @if (old('inputPekerjaan') == "unemployed" || $sales->user->job == "unemployed") {{ 'selected' }} @endif>Unemployed</option>
                                <option value="employed" @if (old('inputPekerjaan') == "employed" || $sales->user->job == "employed") {{ 'selected' }} @endif>Employed</option>
                                <option value="business" @if (old('inputPekerjaan') == "business" || $sales->user->job == "business") {{ 'selected' }} @endif>Business</option>
                                <option value="student"  @if (old('inputPekerjaan') == "student" || $sales->user->job == "student") {{ 'selected' }} @endif>Student</option>
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
                                    <textarea name="question[]" id="question" placeholder="Jabarkan Pertanyaanmu Disini.."  @if ($item->duration != "0" || $item->category == 'product') hidden @endif>{{$item->pivot->question == ' ' ? '' : $item->pivot->question}}</textarea>

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
