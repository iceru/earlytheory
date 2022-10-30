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
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                            id="name" placeholder=""
                            value="{{ $additional && $additional->name ? $additional->name : '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{ $user->birthdate }}" name="birthdate"
                            id="birthdate" placeholder=""
                            value="{{ $additional && $additional->birthdate ? $additional->birthdate : '' }}">
                    </div>
                    <input type="text" value="{{ $sales->id }}" name="salesId" hidden>
                    <div class="row">
                        @foreach ($sales->skus as $item)
                            <div class="col-12 col-lg-6 section mb-5">
                                <div class="additional-section">
                                    <div class="col-12 mb-2">
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
                                            <input type="text" class="form-control" name="birthplace" id="birthplace"
                                                placeholder="" required
                                                value="{{ $additional && $additional->birthplace ? $additional->birthplace : '' }}">
                                        </div>
                                        @if (str_contains(strtolower($item->products->slug), '2023'))
                                            <div class="col-12 mb-3">
                                                <label for="age" class="form-label">Umur Kamu Saat Ini</label>
                                                <input type="text" class="form-control" name="age" id="age"
                                                    placeholder="" required
                                                    value="{{ $additional && $additional->age ? $additional->age : '' }}">
                                            </div>
                                        @endif
                                        @if (!str_contains(strtolower($item->products->slug), 'jam-lahir') && !$cek_jam_lahir)
                                            <div class="col-12 mb-3">
                                                <label for="birthtime" class="form-label">Jam Lahir</label>
                                                <input class="form-control" name="birthtime" id="birthtime"
                                                    placeholder="" type="time" required
                                                    value="{{ $additional && $additional->birthtime ? $additional->birthtime : '' }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="checkbirthtime" class="form-label">Gatau Jam lahir?</label>
                                                <div class="help">
                                                    Ada biaya tambahan untuk mencari tahu jam lahir kamu
                                                    <strong>[+250.000]</strong>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="checkbirthtime" id="checkbirthtime"
                                                            value="checkValue">
                                                        Cari Tahu Jam Lahirku Sekalian
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12 mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                placeholder="" type="tel" value="{{ $user->phone }}" required
                                                value="{{ $additional && $additional->phone ? $additional->phone : '' }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="email" class="form-label">Alamat Email</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="" type="email" value="{{ $user->email }}" required
                                                value="{{ $additional && $additional->email ? $additional->email : '' }}">
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
                                                <input class="form-check-input" type="radio" name="topikasmara"
                                                    id="cocok" checked>
                                                <label class="form-check-label" for="cocok">
                                                    Aku cocok sama orang seperti apa?
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="topikasmara"
                                                    id="sebulan">
                                                <label class="form-check-label" for="sebulan">
                                                    Gimana percintaanku sebulan kedepan?
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="additional-section">
                                    @if ($item->products->additional_question === 'ramal-karir')
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Jabatan Kerja Saat Ini</label>
                                            <div class="help">
                                                <small>Jika belum kerja, tulis 'Belum Kerja'</small>
                                            </div>
                                            <input type="text" class="form-control" name="jabatan" id="jabatan"
                                                placeholder="" required
                                                value="{{ $additional && $additional->jabatan ? $additional->jabatan : '' }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Durasi Kerja Saat Ini</label>
                                            <div class="help">
                                                <small>Tulis 'Sudah kerja Selama 6 Bulan (CTH)" Jika belum kerja, tulis
                                                    "Belum
                                                    Kerja"</small>
                                            </div>
                                            <input type="text" class="form-control" name="durasikerja"
                                                id="durasikerja" placeholder="" required
                                                value="{{ $additional && $additional->durasikerja ? $additional->durasikerja : '' }}">
                                        </div>
                                    @endif

                                    @if ($item->products->additional_question === 'ramal-cinta')
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                            <div class="help">
                                                <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                            </div>
                                            <input type="text" class="form-control" name="durasihub"
                                                id="durasihub" placeholder="" required
                                                value="{{ $additional && $additional->durasihub ? $additional->durasihub : '' }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="orientasi" class="form-label">Orientasi Seksual</label>
                                            <select class="form-select" name="orientasi" id="orientasi">
                                                <option value="straight"
                                                    {{ $additional && $additional->orientasi === 'straight' ? 'selected' : '' }}>
                                                    Straight</option>
                                                <option value="gay"
                                                    {{ $additional && $additional->orientasi === 'gay' ? 'selected' : '' }}>
                                                    Gay</option>
                                                <option value="lesbian"
                                                    {{ $additional && $additional->orientasi === 'lesbian' ? 'selected' : '' }}>
                                                    Lesbian</option>
                                                <option value="queer"
                                                    {{ $additional && $additional->orientasi === 'queer' ? 'selected' : '' }}>
                                                    Queer</option>
                                                <option value="bisexual"
                                                    {{ $additional && $additional->orientasi === 'bisexual' ? 'selected' : '' }}>
                                                    Bisexual</option>
                                                <option value="trans"
                                                    {{ $additional && $additional->orientasi === 'trans' ? 'selected' : '' }}>
                                                    Trans</option>
                                                <option value="non-binary"
                                                    {{ $additional && $additional->orientasi === 'non-binary' ? 'selected' : '' }}>
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
                                            <textarea class="form-control" name="masalahcinta" id="masalahcinta" rows="5" required
                                                value="{{ $additional && $additional->masalahcinta ? $additional->masalahcinta : '' }}"></textarea>
                                        </div>
                                    @endif

                                    @if (str_contains(strtolower($item->products->additional_question), 'ramal'))
                                        <div class="mb-3">
                                            <label for="sisi_samping" class="form-label">Sisi Samping tangan</label>
                                            <div class="row align-items-center">
                                                <div class="col-7 col-lg-10">
                                                    <input type="file" class="form-control" name="sisi_samping"
                                                        id="sisi_samping" placeholder="Sisi Samping Tangan" required
                                                        value="{{ $additional && $additional->sisi_samping ? $additional->sisi_samping : '' }}">
                                                </div>
                                                <div class="col-5 col-lg-2">
                                                    <div class="img">
                                                        <img src="/images/sisi-tangan.jpg" alt=""
                                                            class="w-100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telapak_jari" class="form-label">Telapak + Jari</label>
                                            <div class="row align-items-center">
                                                <div class="col-7 col-lg-10">
                                                    <input type="file" class="form-control" name="telapak_jari"
                                                        id="telapak_jari" placeholder="Telapak + Jari" required
                                                        value="{{ $additional && $additional->telapak_jari ? $additional->telapak_jari : '' }}">
                                                </div>
                                                <div class="col-5 col-lg-2">
                                                    <div class="img">
                                                        <img src="/images/tangan-jari.jpg" alt=""
                                                            class="w-100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telapak_close" class="form-label">Telapak Close Up</label>
                                            <div class="row align-items-center">
                                                <div class="col-7 col-lg-10">
                                                    <input type="file" class="form-control" name="telapak_close"
                                                        id="telapak_close" placeholder="Telapak + Jari" required
                                                        value="{{ $additional && $additional->telapak_close ? $additional->telapak_close : '' }}">
                                                </div>
                                                <div class="col-5 col-lg-2">
                                                    <div class="img">
                                                        <img src="/images/tangan-close.jpg" alt=""
                                                            class="w-100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="muka" class="form-label">Foto Muka Terkini</label>
                                            <div class="row align-items-center">
                                                <div class="col-7 col-lg-10">
                                                    <input type="file" class="form-control" name="muka"
                                                        id="muka" placeholder="Telapak + Jari" required
                                                        value="{{ $additional && $additional->muka ? $additional->muka : '' }}">
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

        let check = false;

        $(`[name="checkbirthtime"]`).change(function() {
            $(`[name="checkbirthtime"]`).prop('checked', !check);
            check = !check;
        });
    </script>
</x-app-layout>
