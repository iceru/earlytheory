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

            <form action="/checkout/{{ $sales->sales_no }}/question/additional" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                            id="name" placeholder="">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{ $user->birthdate }}" name="birthdate"
                            id="birthdate" placeholder="">
                    </div>
                    <div class="row">
                        @foreach ($sales->skus as $item)
                            <div class="col-12 col-lg-6 section">
                                <div class="additional-section">
                                    @if ($item->products->additional_question === 'astrologi')
                                        <div class="col-12 mb-3">
                                            <label for="birthplace" class="form-label">Tempat Lahir</label>
                                            <div class="help">
                                                <small>Cantumkan Kota + Kabupaten + Kode Pos</small>
                                            </div>
                                            <input type="text" class="form-control" name="birthplace" id="birthplace"
                                                placeholder="">
                                        </div>
                                        @if (str_contains(strtolower($item->products->slug), '2023'))
                                            <div class="col-12 mb-3">
                                                <label for="age" class="form-label">Umur Kamu Saat Ini</label>
                                                <input type="text" class="form-control" name="age" id="age"
                                                    placeholder="">
                                            </div>
                                        @endif
                                        <div class="col-12 mb-3">
                                            <label for="birthtime" class="form-label">Jam Lahir</label>
                                            <input type="text" class="form-control" name="birthtime" id="birthtime"
                                                placeholder="" type="time">
                                        </div>
                                        @if (!str_contains(strtolower($item->products->slug), 'cari-tahu'))
                                            <div class="col-12 mb-3">
                                                <label for="checkbirthtime" class="form-label">Gatau Jam lahir?</label>
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
                                                placeholder="" type="tel" value="{{ $user->phone }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="email" class="form-label">Alamat Email</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="" type="email" value="{{ $user->email }}">
                                        </div>
                                        @if (str_contains(strtolower($item->products->slug), 'cari-tahu'))
                                            <div class="note">
                                                Setelah order dibuat, astrologer kami akan menghubungi
                                                kamu untuk menghitung jam lahir
                                            </div>
                                        @endif
                                        @if (str_contains(strtolower($item->products->slug), 'asmara'))
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
                                                placeholder="">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Durasi Kerja Saat Ini</label>
                                            <div class="help">
                                                <small>Tulis 'Sudah kerja Selama 6 Bulan (CTH)" Jika belum kerja, tulis
                                                    "Belum
                                                    Kerja"</small>
                                            </div>
                                            <input type="text" class="form-control" name="durasikerja"
                                                id="durasikerja" placeholder="">
                                        </div>
                                    @endif

                                    @if ($item->products->additional_question === 'ramal-cinta')
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                            <div class="help">
                                                <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                            </div>
                                            <input type="text" class="form-control" name="durasihub"
                                                id="durasihub" placeholder="">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Orientasi Seksual</label>
                                            <div class="form-group">
                                                <label for="orientasi"></label>
                                                <select class="form-control" name="orientasi" id="orientasi">
                                                    <option value="straight">Straight</option>
                                                    <option value="gay">Gay</option>
                                                    <option value="lesbian">Lesbian</option>
                                                    <option value="queer">Queer</option>
                                                    <option value="bisexual">Bisexual</option>
                                                    <option value="trans">Trans</option>
                                                    <option value="non-binary">Non-binary</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                            <div class="help">
                                                <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                            </div>
                                            <input type="text" class="form-control" name="jabatan" id="jabatan"
                                                placeholder="">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="jabatan" class="form-label">Ceritakan Masalah Cintamu</label>
                                            <div class="help">
                                                <small>Cerita Secara Singkat, Padat dan Jelas</small>
                                            </div>
                                            <textarea class="form-control" name="" id="" rows="5"></textarea>
                                        </div>
                                    @endif

                                    @if (str_contains(strtolower($item->products->additional_question), 'ramal'))
                                        <div class="mb-3">
                                            <label for="sisi-samping" class="form-label">Sisi Samping tangan</label>
                                            <input type="file" class="form-control" name="sisi-samping"
                                                id="sisi-samping" placeholder="Sisi Samping Tangan">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 mt-4">
                            <button type="button" class="button secondary w-100">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
