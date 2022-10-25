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
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                            id="name" placeholder="">
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{ $user->birthdate }}" name="birthdate"
                            id="birthdate" placeholder="">
                    </div>
                    @foreach ($sales->skus as $item)
                        @if ($item->products->additional_question === 'ramal-karir')
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan Kerja Saat Ini</label>
                                <div class="help">
                                    <small>Jika belum kerja, tulis 'Belum Kerja'</small>
                                </div>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="">
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Durasi Kerja Saat Ini</label>
                                <div class="help">
                                    <small>Tulis 'Sudah kerja Selama 6 Bulan (CTH)" Jika belum kerja, tulis "Belum
                                        Kerja"</small>
                                </div>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="">
                            </div>
                        @endif

                        @if ($item->products->additional_question === 'ramal-cinta')
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                <div class="help">
                                    <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                </div>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="">
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
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
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Durasi Hubungan</label>
                                <div class="help">
                                    <small>Cth: 'Sudah Pacaran / Single Selama 6 Bulan'</small>
                                </div>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="">
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jabatan" class="form-label">Ceritakan Masalah Cintamu</label>
                                <div class="help">
                                    <small>Cerita Secara Singkat, Padat dan Jelas</small>
                                </div>
                                <textarea class="form-control" name="" id="" rows="5"></textarea>
                            </div>
                        @endif
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
