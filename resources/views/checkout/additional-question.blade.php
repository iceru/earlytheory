<x-app-layout>
    @section('title')
    Checkout - {{ $sales->sales_no }}
    @endsection
    <div class="col-12 checkout additional-question">
        <div class="row">
            <div class="col-12 title-page">
                <h1>Additional Question</h1>
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
                <strong>Maaf!</strong> Terdapat kesalahan dalam input data.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/checkout/{{ $sales->sales_no }}/add-additional" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name" placeholder="" required value="{{ $additional && $additional->name ? $additional->name : '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" value="{{ $user->birthdate }}" name="birthdate" id="birthdate" placeholder="" required readonly style="background-color: white" value="{{ $additional && $additional->birthdate ? \Carbon\Carbon::parse($additional->birthdate)->toFormattedDateString() : '' }}">
                            <div class="logoCalendar">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>


                    </div>
                    <div class="col-12 mb-3" hidden>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="" type="tel" value="{{ $user->phone }}">
                    </div>
                    <div class="col-12 mb-3" hidden>
                        <input type="email" class="form-control" name="email" id="email" placeholder="" type="email" value="{{ $user->email }}">
                    </div>
                    <input type="text" value="{{ $sales->id }}" name="salesId" hidden>
                    <div class="row">
                        @foreach ($sales->skus as $item)
                        <div class="col-12 col-lg-6 section mb-5">
                            <div class="additional-section">
                                <div class="col-12 mb-3">
                                    <div class="title">
                                        {{ $item->products->title }}
                                    </div>
                                </div>
                                @if ($item->products->additional_question === 'astrologi')
                                <div class="col-12 mb-3">
                                    <label for="birthplace" class="form-label">Tempat Lahir</label>
                                    <div class="help">
                                        <small>Cantumkan Kota + Kabupaten + Kode Pos</small>
                                    </div>
                                    <input type="text" class="form-control" name="birthplace" id="birthplace" placeholder="" required value="{{ $additional && $additional->birthplace ? $additional->birthplace : '' }}">
                                </div>
                                @if (
                                !str_contains(strtolower($item->products->slug), 'prediksi') &&
                                !str_contains(strtolower($item->products->slug), 'jam-lahir'))
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Tempat Tinggal Sekarang
                                    </label>
                                    <div class="help">
                                        <small>Cantumkan Kota + Kabupaten + Kode Pos</small>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="" required value="{{ $additional && $additional->address ? $additional->address : '' }}">
                                </div>
                                @endif

                                @if (str_contains(strtolower($item->products->slug), 'prediksi'))
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Tempat Tinggal Sekarang (sampai
                                        tahun depan)
                                    </label>
                                    <div class="help">
                                        <small> Cantumkan Kota + Kabupaten + Kode Pos</small>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="" required value="{{ $additional && $additional->address ? $additional->address : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="age" class="form-label">Umur Kamu Saat Ini</label>
                                    <input type="number" class="form-control" name="age" id="age" placeholder="" required value="{{ $additional && $additional->age ? $additional->age : '' }}">
                                </div>
                                @endif
                                @if (!str_contains(strtolower($item->products->slug), 'jam-lahir') && !$cek_jam_lahir)
                                <div class="col-12 mb-3">
                                    <label for="birthtime" class="form-label">Jam Lahir</label>
                                    <input class="form-control" name="birthtime" id="birthtime" class="birthtime" placeholder="" type="time" required value="{{ $additional && $additional->birthtime ? $additional->birthtime : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="checkbirthtime" class="form-label">Gatau Jam
                                        lahir?</label>
                                    <div class="help">
                                        Ada biaya tambahan untuk mencari tahu jam lahir kamu
                                        <strong>[+250.000]</strong>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="checkbirthtime" id="checkbirthtime" value="checkValue">
                                            Cari Tahu Jam Lahirku Sekalian
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-12 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" minlength="8" class="form-control" name="phone" id="phone" placeholder="" type="tel" value="{{ $user->phone }}" required value="{{ $additional && $additional->phone ? $additional->phone : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="" type="email" value="{{ $user->email }}" required value="{{ $additional && $additional->email ? $additional->email : '' }}">
                                </div>
                                @if (str_contains(strtolower($item->products->slug), 'jam-lahir'))
                                <div class="note">
                                    Setelah order dibuat, astrologer kami akan menghubungi
                                    kamu untuk menghitung jam lahir
                                </div>
                                @endif
                                @if (str_contains(strtolower($item->products->slug), 'asmara'))
                                <div class="form-label">
                                    Pilih Satu Topik
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topikasmara" id="cocok" value="cocok" checked>
                                    <label class="form-check-label" for="cocok">
                                        Aku cocok sama orang seperti apa?
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topikasmara" id="sebulan" value="sebulan">
                                    <label class="form-check-label" for="sebulan">
                                        Gimana percintaanku sebulan kedepan?
                                    </label>
                                </div>
                                @endif
                                @endif
                                @if ($item->products->additional_question === 'ramal-karir')
                                <div class="col-12 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan Kerja Saat Ini</label>
                                    <div class="help">
                                        <small>Jika belum kerja, tulis 'Belum Kerja'</small>
                                    </div>
                                    <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="" required value="{{ $additional && $additional->jabatan ? $additional->jabatan : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="jabatan" class="form-label">Durasi Kerja Saat Ini</label>
                                    <div class="help">
                                        <small>Tulis 'Sudah kerja Selama 6 Bulan (CTH)" Jika belum kerja, tulis
                                            "Belum
                                            Kerja"</small>
                                    </div>
                                    <input type="text" class="form-control" name="durasikerja" id="durasikerja" placeholder="" required value="{{ $additional && $additional->durasikerja ? $additional->durasikerja : '' }}">
                                </div>
                                @endif

                                @if ($item->products->additional_question === 'ramal-cinta')
                                <div class="col-12 mb-3">
                                    <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                    <div class="help">
                                        <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                    </div>
                                    <input type="text" class="form-control" name="durasihub" id="durasihub" placeholder="" required value="{{ $additional && $additional->durasihub ? $additional->durasihub : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="orientasi" class="form-label">Orientasi Seksual</label>
                                    <select class="form-select" name="orientasi" id="orientasi">
                                        <option value="straight" {{ $additional && $additional->orientasi === 'straight' ? 'selected' : '' }}>
                                            Straight</option>
                                        <option value="gay" {{ $additional && $additional->orientasi === 'gay' ? 'selected' : '' }}>
                                            Gay</option>
                                        <option value="lesbian" {{ $additional && $additional->orientasi === 'lesbian' ? 'selected' : '' }}>
                                            Lesbian</option>
                                        <option value="queer" {{ $additional && $additional->orientasi === 'queer' ? 'selected' : '' }}>
                                            Queer</option>
                                        <option value="bisexual" {{ $additional && $additional->orientasi === 'bisexual' ? 'selected' : '' }}>
                                            Bisexual</option>
                                        <option value="trans" {{ $additional && $additional->orientasi === 'trans' ? 'selected' : '' }}>
                                            Trans</option>
                                        <option value="non-binary" {{ $additional && $additional->orientasi === 'non-binary' ? 'selected' : '' }}>
                                            Non-binary</option>
                                    </select>
                                </div>
                                <div class="col-12
                                                    mb-3">
                                    <label for="masalahcinta" class="form-label">Ceritakan Masalah
                                        Cintamu</label>
                                    <div class="help">
                                        <small>Cerita Secara Singkat, Padat dan Jelas</small>
                                    </div>
                                    <textarea class="form-control" name="masalahcinta" id="masalahcinta" rows="5" required value="{{ $additional && $additional->masalahcinta ? $additional->masalahcinta : '' }}"></textarea>
                                </div>
                                @endif

                                @if (str_contains(strtolower($item->products->additional_question), 'ramal'))
                                <div class="mb-3">
                                    <label for="sisi_samping" class="form-label">Sisi Samping tangan</label>
                                    <div class="row align-items-center">
                                        <div class="col-7 col-lg-10">
                                            <input type="file" class="form-control" name="sisi_samping" id="sisi_samping" placeholder="Sisi Samping Tangan" required value="{{ $additional && $additional->sisi_samping ? $additional->sisi_samping : '' }}">
                                        </div>
                                        <div class="col-5 col-lg-2">
                                            <div class="img">
                                                <img src="/images/sisi-tangan.jpg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telapak_jari" class="form-label">Telapak + Jari</label>
                                    <div class="row align-items-center">
                                        <div class="col-7 col-lg-10">
                                            <input type="file" class="form-control" name="telapak_jari" id="telapak_jari" placeholder="Telapak + Jari" required value="{{ $additional && $additional->telapak_jari ? $additional->telapak_jari : '' }}">
                                        </div>
                                        <div class="col-5 col-lg-2">
                                            <div class="img">
                                                <img src="/images/tangan-jari.jpg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telapak_close" class="form-label">Telapak Close Up</label>
                                    <div class="row align-items-center">
                                        <div class="col-7 col-lg-10">
                                            <input type="file" class="form-control" name="telapak_close" id="telapak_close" placeholder="Telapak + Jari" required value="{{ $additional && $additional->telapak_close ? $additional->telapak_close : '' }}">
                                        </div>
                                        <div class="col-5 col-lg-2">
                                            <div class="img">
                                                <img src="/images/tangan-close.jpg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="muka" class="form-label">Foto Muka Terkini</label>
                                    <div class="row align-items-center">
                                        <div class="col-7 col-lg-10">
                                            <input type="file" class="form-control" name="muka" id="muka" placeholder="Telapak + Jari" required value="{{ $additional && $additional->muka ? $additional->muka : '' }}">
                                        </div>
                                        <div class="col-5 col-lg-2">
                                            <div class="img">
                                                <img src="/images/muka.jpg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if ($item->products->additional_question === 'tarot')
                                <div class="form-group col-12 mb-3">
                                    <label for="inputRelationship" class="form-label">Status
                                        Relationship</label>
                                    <select class="form-select" name="inputRelationship" id="inputRelationship" required>
                                        <option selected disabled value="">Select</option>
                                        <option value="single" @if (old('inputRelationship')=='single' || $sales->relationship == 'single') {{ 'selected' }} @endif>
                                            Single</option>
                                        <option value="pacaran" @if (old('inputRelationship')=='pacaran' || $sales->relationship == 'pacaran') {{ 'selected' }} @endif>
                                            Pacaran</option>
                                        <option value="menikah" @if (old('inputRelationship')=='menikah' || $sales->relationship == 'menikah') {{ 'selected' }} @endif>
                                            Menikah</option>
                                        <option value="divorced" @if (old('inputRelationship')=='divorced' || $sales->relationship == 'divorced') {{ 'selected' }} @endif>
                                            Divorced</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label for="inputPekerjaan" class="form-label">Status Pekerjaan</label>
                                    <select class="form-select" name="inputPekerjaan" id="inputPekerjaan" required>
                                        <option selected disabled value="">Select</option>
                                        <option value="unemployed" @if (old('inputPekerjaan')=='unemployed' || $sales->job == 'unemployed') {{ 'selected' }} @endif>
                                            Unemployed
                                        </option>
                                        <option value="employed" @if (old('inputPekerjaan')=='employed' || $sales->job == 'employed') {{ 'selected' }} @endif>
                                            Employed</option>
                                        <option value="business" @if (old('inputPekerjaan')=='business' || $sales->job == 'business') {{ 'selected' }} @endif>
                                            Business</option>
                                        <option value="student" @if (old('inputPekerjaan')=='student' || $sales->job == 'student') {{ 'selected' }} @endif>
                                            Student</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label for="inputGender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" name="inputGender" id="inputGender" required>
                                        <option selected disabled value="">Select</option>
                                        <option value="laki-laki" @if (old('inputGender')=='laki-laki' || $sales->gender == 'laki-laki') {{ 'selected' }} @endif>
                                            Laki-Laki
                                        </option>
                                        <option value="perempuan" @if (old('inputGender')=='perempuan' || $sales->gender == 'perempuan') {{ 'selected' }} @endif>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                                @if (str_contains(strtolower($item->products->slug), 'di-mata'))
                                <div class="col-12 mb-3">
                                    <label for="kepribadian" class="form-label">Jelaskan kepribadianmu
                                        menurut dirimu sendiri
                                    </label>
                                    <textarea class="form-control" name="kepribadian" id="kepribadian" rows="5" required></textarea>
                                </div>
                                @endif
                                @if (str_contains(strtolower($item->products->slug), 'kontrak'))
                                <div class="col-12 mb-3">
                                    <label for="nama_orang" class="form-label">Nama Orang Ini</label>
                                    <input type="text" minlength="8" class="form-control" name="nama_orang" id="nama_orang" placeholder="" type="text" required value="{{ $additional && $additional->nama_orang ? $additional->nama_orang : '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="siapa_dia" class="form-label">Siapa dia</label>
                                    <select class="form-select" name="siapa_dia" id="siapa_dia">
                                        <option value="pacar/pasangan" {{ $additional && $additional->siapa_dia === 'pacar/pasangan' ? 'selected' : '' }}>
                                            Pacar / Pasangan</option>
                                        <option value="gebetan/crush" {{ $additional && $additional->siapa_dia === 'gebetan/crush' ? 'selected' : '' }}>
                                            Gebetan / Crush</option>
                                        <option value="teman/sahabat" {{ $additional && $additional->siapa_dia === 'teman/sahabat' ? 'selected' : '' }}>
                                            Teman / Sahabat</option>
                                        <option value="orang-tua" {{ $additional && $additional->siapa_dia === 'orang-tua' ? 'selected' : '' }}>
                                            Orang Tua</option>
                                        <option value="saudara" {{ $additional && $additional->siapa_dia === 'saudara' ? 'selected' : '' }}>
                                            Saudara</option>
                                        <option value="sekedar-kenal" {{ $additional && $additional->siapa_dia === 'sekedar-kenal' ? 'selected' : '' }}>
                                            Sekedar Kenal</option>
                                    </select>
                                </div>
                                @endif

                                <div class="col-12 mb-3">
                                    @if (str_contains(strtolower($item->products->slug), 'kontrak'))
                                    <label for="muka" class="form-label">Foto Muka Orang Ini</label>
                                    @else
                                    <label for="muka" class="form-label">Foto Muka Terkini</label>
                                    @endif
                                    <div class="row align-items-center">
                                        <div class="col-7 col-lg-10">
                                            <input type="file" class="form-control" name="muka" id="muka" placeholder="Telapak + Jari" required value="{{ $additional && $additional->muka ? $additional->muka : '' }}">
                                        </div>
                                        <div class="col-5 col-lg-2">
                                            <div class="img">
                                                <img src="/images/muka.jpg" alt="" class="w-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="col-12 mt-4">
                            <button type="submit" class="button secondary w-100">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const name = [
            'birthplace',
            'age',
            'birthtime',
            'phone,',
            'email'
        ]
        name.forEach(element => {
            $(`[name="${element}"]`).blur(function() {
                $(`[name="${element}"]`).val($(this).val());
            });
        });

        $("#birthdate").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2012",
            altFormat: 'yy/mm/dd',
            defaultDate: new Date('2000/01/01'),
        });

        let check = false;

        $(`[name="checkbirthtime"]`).change(function() {
            $(`[name="checkbirthtime"]`).prop('checked', !check);
            check = !check;

            if (check) {
                $('[name="birthtime"]').removeAttr('required');
                $('[name="birthtime"]').hide();
            } else {
                $('[name="birthtime"]').prop('required', true);
                $('[name="birthtime"]').show();
            }
        });
    </script>
</x-app-layout>