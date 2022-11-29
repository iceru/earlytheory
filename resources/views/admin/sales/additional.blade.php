<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    @endsection

    <div class="py-12">
        <h3 class="evogria">Detail Additional of Sales #{{ $additional->sales_id }}</h3>
    </div>

    <div class="py-12 my-4">
    </div>

    <div class="row additional-admin">
        <div class="col-12 section">
            <div class="mb-1 row">
                <label class="col-sm-3 col-form-label fw-bolder">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control-plaintext" value="{{ $additional->name }}" readonly>
                </div>
            </div>
            @if ($additional->birthdate)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Tanggal Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext"
                            value="{{ \Carbon\Carbon::parse($additional->birthdate)->toFormattedDateString() }}"
                            readonly>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 section">
            <div class="title">
                @foreach ($skus as $item)
                    @if (!str_contains($item->products->title, 'Ramal'))
                        <div class="item">
                            {{ $item->products->title }}
                        </div>
                    @endif
                @endforeach
            </div>
            @if ($additional->birthplace)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Tempat Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext" value="{{ $additional->birthplace }}"
                            readonly>
                    </div>
                </div>
            @endif
            @if ($additional->birthtime)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Waktu Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext" value="{{ $additional->birthtime }}"
                            readonly>
                    </div>
                </div>
            @endif
            @if ($additional->address)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Tempat Tinggal Saat Ini</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value=" {{ $additional->address }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->age)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Umur</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->age }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->checkbirthtime)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Tambahan Cari Tahu Jam Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->checkbirthtime ? 'Ya' : 'Tidak' }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->topikasmara)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Topik Asmara</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value=" {{ $additional->topikasmara === 'cocok' ? ' Aku cocok sama orang seperti apa?' : ' Gimana percintaanku sebulan kedepan?' }}"
                            readonly>
                    </div>
                </div>
            @endif
            <div class="mb-1 row">
                <label class="col-sm-3 col-form-label fw-bolder">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control-plaintext" value="{{ $additional->email }}" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-sm-3 col-form-label fw-bolder">Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control-plaintext" value="{{ $additional->phone }}" readonly>
                </div>
            </div>

        </div>
        <div class="col-12 section">
            <div class="title">
                @foreach ($skus as $item)
                    @if (str_contains($item->products->title, 'Ramal'))
                        <div class="item">
                            {{ $item->products->title }}
                        </div>
                    @endif
                @endforeach
            </div>
            @if ($additional->jabatan)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Jabatan Kamu Saat Ini</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->jabatan }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->durasikerja)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Durasi Kerja Saat Ini</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->durasikerja }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->durasihub)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Durasi Hubungan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->durasihub }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->orientasi)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Orientasi Seksual</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->orientasi }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->masalahcinta)
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Ceritakan Masalah Cintamu</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control-plaintext text-capitalize"
                            value="{{ $additional->masalahcinta }}" readonly>
                    </div>
                </div>
            @endif
            @if ($additional->sisi_samping)
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Sisi Samping Tangan</label>
                    <div class="col-sm-9">
                        <img width=150 src="{{ Storage::url('additional-image/' . $additional->sisi_samping) }}"
                            alt="Sisi Samping Tangan">
                    </div>
                </div>
            @endif
            @if ($additional->telapak_jari)
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Telapak + Jari</label>
                    <div class="col-sm-9">
                        <img width=150 src="{{ Storage::url('additional-image/' . $additional->telapak_jari) }}"
                            alt="Telapak + Jari">
                    </div>
                </div>
            @endif
            @if ($additional->telapak_close)
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Telapak Close Up</label>
                    <div class="col-sm-9">
                        <img width=150 src="{{ Storage::url('additional-image/' . $additional->telapak_close) }}"
                            alt="Telapak Close Up">
                    </div>
                </div>
            @endif
            @if ($additional->muka)
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-bolder">Foto Muka Terkini</label>
                    <div class="col-sm-9">
                        <img width=150 src="{{ Storage::url('additional-image/' . $additional->muka) }}"
                            alt="Telapak + Jari">
                    </div>
                </div>
            @endif

        </div>

    </div>
    @section('js')
        <script>
            $(document).ready(function() {
                $('#table').DataTable();
            });
        </script>
    @endsection
</x-admin-layout>
