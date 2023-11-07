@extends('Layout.appUser')

@section('content')
    <div class="row pt-4">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header text-center bg-primary">
                    <h4 class="text-white">Catatan Harian {{ $namaUser }}</h4>
                </div>
                {{-- Filter Catatan User --}}
                <div class="card-body">
                    <h5 class="card-title text-primary">Search Catatan :</h5>
                    <form action="{{ route('filterCatatan') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="kategoriFilter" class="form-label text-primary">Kategori :</label>
                                    <select name="kategoriFilter" id="kategoriFilter" class="form-select text-primary">
                                        <option value="" selected>Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->Nama_Kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="prioritasFilter" class="form-label text-primary">Prioritas Tugas:</label>
                                    <select name="prioritasFilter" id="prioritasFilter" class="form-select text-primary">
                                        <option value="" class="text-primary" selected>Semua Prioritas</option>
                                        <option value="rendah" class="text-primary">Rendah</option>
                                        <option value="sedang" class="text-primary">Sedang</option>
                                        <option value="tinggi" class="text-primary">Tinggi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="statusFilter" class="form-label text-primary">Status Tugas :</label>
                                    <select name="statusFilter" id="statusFilter" class="form-select text-primary">
                                        <option value="" class="text-primary" selected>Semua Status</option>
                                        <option value="selesai" class="text-primary">Selesai</option>
                                        <option value="belum selesai" class="text-primary">Belum Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </form>
                </div>

                <div class="card-body">
                    <h5 class="card-title text-primary">List Catatan :</h5>
                    <hr>
                    <button id="buatCatatanButton" class="btn btn-success btn-hover mb-4" type="button">
                        <i class="bx bx-plus"></i> Buat Catatan
                    </button>

                    {{-- Form Catatan --}}
                    <div id="isiContentSection" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Buat Catatan Harian</h5>
                                <form action="{{ route('storeCatatan') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="kegiatan" class="form-label">Judul Catatan :</label>
                                        <input type="text" name="kegiatan" id="kegiatan" class="form-control" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="hari" class="form-label">Hari :</label>
                                            <input type="date" name="hari" id="hari" class="form-control"
                                                required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori :</label>
                                            <select name="kategori" id="kategori" class="form-select" required>
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->Nama_Kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- Menampilkan Form catatan dan tugas --}}
                    <div class="row pt-4">
                        @foreach ($jadwalharian as $catatan)
                            <div class="col-md-6 mb-3" data-catatan-id="{{ $catatan->id }}">
                                <div class="card p-1 bg-primary">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center gap-1">
                                            <div class="flex-grow-1 tugas-item">
                                                {{-- Menampilkan Catatan --}}
                                                @php
                                                    $formattedDate = \Carbon\Carbon::parse($catatan->HARI)->isoFormat('dddd, D MMMM YYYY', 'Do MMMM YYYY', 'id');
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h5 class="card-text text-primary">{{ $catatan->KEGIATAN }}<span
                                                                class=" text-black">
                                                                <h6 class="card-text">{{ $formattedDate }}</h6>
                                                            </span></h5>
                                                        <div class="mt-2 d-flex align-items-center">
                                                            <label for="kategoriSelect" class="mb-0">Kategori :</label>
                                                            <select name="kategoriSelect" class="form-select"
                                                                data-catatan-id="{{ $catatan->id }}">
                                                                <option value="" selected>Pilih Kategori</option>
                                                                @foreach ($kategoris as $kategori)
                                                                    <option value="{{ $kategori->id }}"
                                                                        {{ $kategori->id == $catatan->kategori_id ? 'selected' : '' }}>
                                                                        {{ $kategori->Nama_Kategori }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="btn btn-primary btn-hover btn-edit" type="button"
                                                            data-catatan-id="{{ $catatan->id }}">
                                                            <i class="bx bx-pencil"></i>
                                                        </button>
                                                        <button class="buatListTugasButton btn btn-success btn-hover"
                                                            type="button" data-catatan-id="{{ $catatan->id }}">
                                                            <i class="bx bx-plus"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-hover btn-delete" type="button"
                                                            data-catatan-id="{{ $catatan->id }}">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr class="hr-blue" style="border-color: blue;">
                                                @foreach ($tugas as $tugass)
                                                    @if ($tugass->jadwalharian_id == $catatan->id)
                                                        {{-- Menampilkan Tugas --}}
                                                        <div class="tugas-item" data-tugas-id="{{ $tugass->id }}">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="deskripsi-tugas">
                                                                    Tugas {{ $loop->iteration }} |
                                                                    {{ $tugass->DESK_TUGAS }}
                                                                </p>
                                                                <div class="button-container">
                                                                    <button
                                                                        class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                                        type="button"
                                                                        data-tugas-id="{{ $tugass->id }}">Edit</button>
                                                                    <button
                                                                        class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                                        type="button"
                                                                        data-tugas-id="{{ $tugass->id }}">Hapus</button>
                                                                </div>
                                                            </div>
                                                            <p class="informasi-tambahan">
                                                                <span class="tanggal">
                                                                    {{ date('l, j n Y H:i', strtotime($tugass->TENGGAT_WAKTU)) }}
                                                                    |
                                                                </span>
                                                                <span class="status">
                                                                    @if ($tugass->STATUS == 1)
                                                                        {{ 'selesai' }}
                                                                    @else
                                                                        {{ 'belum selesai' }}
                                                                    @endif |
                                                                </span>
                                                                <span class="skala-prioritas">
                                                                    Skala Prioritas:
                                                                    {{ $tugass->Skala_Prioritas == 1 ? 'Penting' : 'Tidak Penting' }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Form Edit Catatan --}}
                                    <div class="card mt-4" style="display: none;">
                                        <div class="card-body">
                                            <h5 class="card-title">Form Edit Catatan Harian</h5>
                                            <form action="{{ route('updateCatatan', $catatan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="hari" class="form-label">Hari:</label>
                                                    <input type="date" name="hari" id="hari"
                                                        class="form-control"
                                                        value="{{ $date = explode(' ', $catatan->HARI)[0] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kegiatan" class="form-label">Kegiatan:</label>
                                                    <input type="text" name="kegiatan" id="kegiatan"
                                                        class="form-control" value="{{ $catatan->KEGIATAN }}" required>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-center gap-2 ">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-cancel-edit">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Form Tambah Tugas --}}
                                    <div id="addTugas" style="display: none;" data-catatan-id="{{ $catatan->id }}">
                                        <div class="card mt-4">
                                            <div class="card-body">

                                                <div id="tugasRow"></div>

                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="submit-button btn btn-primary"
                                                                value="submit" id="submitAllForms">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Form Edit Tugas --}}
                                    <div class="card mt-3" style="display: none;">
                                        <div class="card-body">
                                            <h5 class="card-title">Form Edit Tugas</h5>
                                            <form id="editForm" class="dynamic-form">
                                                @csrf
                                                @method('PUT')
                                                <!-- Form edit untuk deskripsi, tenggat_waktu, status, dll. -->
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <label for="DESK_TUGAS" class="form-label">Deskripsi
                                                                Tugas:</label>
                                                        </div>
                                                        <textarea name="DESK_TUGAS" class="form-control" required></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="TENGGAT_WAKTU" class="form-label">Waktu
                                                                Pengumpulan:</label>
                                                            <input type="datetime-local" name="TENGGAT_WAKTU"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="STATUS" class="form-label">Status Tugas:</label>
                                                            <select name="STATUS" class="form-control" required>
                                                                <option value="0">Belum Selesai</option>
                                                                <option value="1">Selesai</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button type="button" class="submit-button btn btn-primary"
                                                                id="submitAllForms">Simpan</button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-cancel-edit">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Versi Statiknya --}}
    {{-- <div class="row pt-4">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header text-center bg-primary">
                    <h4 class="text-white">Catatan Harian John Doe</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-primary">Search Catatan :</h5>
                    <form action="/filterCatatan" method="POST">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="kategoriFilter" class="form-label text-primary">Kategori :</label>
                                    <select name="kategoriFilter" id="kategoriFilter" class="form-select text-primary">
                                        <option value="" selected>Semua Kategori</option>
                                        <option value="1">Kategori 1</option>
                                        <option value="2">Kategori 2</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="prioritasFilter" class="form-label text-primary">Prioritas Tugas:</label>
                                    <select name="prioritasFilter" id="prioritasFilter" class="form-select">
                                        <option value="" selected>Semua Prioritas</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="tinggi">Tinggi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="statusFilter" class="form-label text-primary">Status Tugas :</label>
                                    <select name="statusFilter" id="statusFilter" class="form-select">
                                        <option value="" selected>Semua Status</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="belum selesai">Belum Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </form>
                </div>
                <div class="card-body">
                    <h5 class="card-title">List Catatan :</h5>
                    <hr>
                    <button id="buatCatatanButton" class="btn btn-success btn-hover mb-4" type="button">
                        <i class="bx bx-plus"></i> Buat Catatan
                    </button>
                    <div id="isiContentSection" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Buat Catatan Harian</h5>
                                <form action="/storeCatatan" method="POST">
                                    <div class="mb-3">
                                        <label for="kegiatan" class="form-label">Judul Catatan :</label>
                                        <input type="text" name="kegiatan" id="kegiatan" class="form-control"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="hari" class="form-label">Hari :</label>
                                            <input type="date" name="hari" id="hari" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori :</label>
                                            <select name="kategori" id="kategori" class="form-select" required>
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                <option value="1">Kategori 1</option>
                                                <option value="2">Kategori 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card p-1 bg-primary">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center gap-1">
                                        <div class="flex-grow-1 tugas-item">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5 class="card-text">Sample Task 1
                                                        <span>
                                                            <h6 class="card-text">Monday, 25 October 2023</h6>
                                                        </span>
                                                    </h5>
                                                    <div class="mt-2 d-flex align-items-center">
                                                        <label for="kategoriSelect" class="mb-0">Kategori :</label>
                                                        <select name="kategoriSelect" class="form-select">
                                                            <option value="" selected>Pilih Kategori</option>
                                                            <option value="1">Kategori 1</option>
                                                            <option value="2">Kategori 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-hover btn-edit" type="button">
                                                        <i class="bx bx-pencil"></i>
                                                    </button>
                                                    <button class="buatListTugasButton btn btn-success btn-hover"
                                                        type="button">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-hover btn-delete" type="button">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <hr class="hr-blue" style="border-color: blue;">
                                            <div class="tugas-item" data-tugas-id="1">
                                                <div class="d-flex justify-content-between">
                                                    <p class="deskripsi-tugas">Tugas 1 | Sample Task 1</p>
                                                    <div class="button-container">
                                                        <button class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                            type="button">Edit</button>
                                                        <button class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                            type="button">Hapus</button>
                                                    </div>
                                                </div>
                                                <p class="informasi-tambahan">
                                                    <span class="tanggal">
                                                        Monday, 25 October 2023 12:00 |
                                                    </span>
                                                    <span class="status">
                                                        Status: belum selesai
                                                    </span>
                                                    <span class="skala-prioritas">
                                                        | Skala Prioritas: Penting
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="tugas-item" data-tugas-id="1">
                                                <div class="d-flex justify-content-between">
                                                    <p class="deskripsi-tugas">Tugas 1 | Sample Task 1</p>
                                                    <div class="button-container">
                                                        <button class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                            type="button">Edit</button>
                                                        <button class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                            type="button">Hapus</button>
                                                    </div>
                                                </div>
                                                <p class="informasi-tambahan">
                                                    <span class="tanggal">
                                                        Monday, 25 October 2023 12:00 |
                                                    </span>
                                                    <span class="status">
                                                        Status: belum selesai
                                                    </span>
                                                    <span class="skala-prioritas">
                                                        | Skala Prioritas: Penting
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="card mt-4" style="display: none;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Form Edit Catatan Harian</h5>
                                                    <form action="/updateCatatan/1" method="POST">
                                                        <div class="mb-3">
                                                            <label for="hari" class="form-label">Hari:</label>
                                                            <input type="date" name="hari" id="hari"
                                                                class="form-control" value="2023-10-25" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kegiatan" class="form-label">Kegiatan:</label>
                                                            <input type="text" name="kegiatan" id="kegiatan"
                                                                class="form-control" value="Sample Task 1" required>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-md-12">
                                                                <div class="d-flex justify-content-center gap-2 ">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-cancel-edit">Batal
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="addTugas" style="display: none;">
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <form action="/storeTugas" method="POST">
                                                            <div id="tugasRow"></div>
                                                            <div class="row mt-4">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="button"
                                                                            class="submit-button btn btn-primary"
                                                                            value="submit"
                                                                            id="submitAllForms">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mt-3" style="display: none;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Form Edit Tugas</h5>
                                                    <form id="editForm" class="dynamic-form">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="mb-3 d-flex justify-content-between align-items-center">
                                                                    <label for="DESK_TUGAS" class="form-label">Deskripsi
                                                                        Tugas:</label>
                                                                </div>
                                                                <textarea name="DESK_TUGAS" class="form-control" required></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="TENGGAT_WAKTU" class="form-label">Waktu
                                                                        Pengumpulan:</label>
                                                                    <input type="datetime-local" name="TENGGAT_WAKTU"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="STATUS" class="form-label">Status
                                                                        Tugas:</label>
                                                                    <select name="STATUS" class="form-control" required>
                                                                        <option value="0">Belum Selesai</option>
                                                                        <option value="1">Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-md-12">
                                                                <div class="d-flex justify-content-center gap-2">
                                                                    <button type="button"
                                                                        class="submit-button btn btn-primary"
                                                                        id="submitAllForms">Simpan</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-cancel-edit">Batal</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card p-1 bg-primary">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center gap-1">
                                        <div class="flex-grow-1 tugas-item">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5 class="card-text">Sample Task 1
                                                        <span>
                                                            <h6 class="card-text">Monday, 25 October 2023</h6>
                                                        </span>
                                                    </h5>
                                                    <div class="mt-2 d-flex align-items-center">
                                                        <label for="kategoriSelect" class="mb-0">Kategori :</label>
                                                        <select name="kategoriSelect" class="form-select">
                                                            <option value="" selected>Pilih Kategori</option>
                                                            <option value="1">Kategori 1</option>
                                                            <option value="2">Kategori 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-hover btn-edit" type="button">
                                                        <i class="bx bx-pencil"></i>
                                                    </button>
                                                    <button class="buatListTugasButton btn btn-success btn-hover"
                                                        type="button">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-hover btn-delete" type="button">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <hr class="hr-blue" style="border-color: blue;">
                                            <div class="tugas-item" data-tugas-id="1">
                                                <div class="d-flex justify-content-between">
                                                    <p class="deskripsi-tugas">Tugas 1 | Sample Task 1</p>
                                                    <div class="button-container">
                                                        <button class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                            type="button">Edit</button>
                                                        <button class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                            type="button">Hapus</button>
                                                    </div>
                                                </div>
                                                <p class="informasi-tambahan">
                                                    <span class="tanggal">
                                                        Monday, 25 October 2023 12:00 |
                                                    </span>
                                                    <span class="status">
                                                        Status: belum selesai
                                                    </span>
                                                    <span class="skala-prioritas">
                                                        | Skala Prioritas: Penting
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="tugas-item" data-tugas-id="1">
                                                <div class="d-flex justify-content-between">
                                                    <p class="deskripsi-tugas">Tugas 1 | Sample Task 1</p>
                                                    <div class="button-container">
                                                        <button class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                            type="button">Edit</button>
                                                        <button class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                            type="button">Hapus</button>
                                                    </div>
                                                </div>
                                                <p class="informasi-tambahan">
                                                    <span class="tanggal">
                                                        Monday, 25 October 2023 12:00 |
                                                    </span>
                                                    <span class="status">
                                                        Status: belum selesai
                                                    </span>
                                                    <span class="skala-prioritas">
                                                        | Skala Prioritas: Penting
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="tugas-item" data-tugas-id="1">
                                                <div class="d-flex justify-content-between">
                                                    <p class="deskripsi-tugas">Tugas 1 | Sample Task 1</p>
                                                    <div class="button-container">
                                                        <button class="btn btn-warning btn-sm btn-hover btn-edit-tugas"
                                                            type="button">Edit</button>
                                                        <button class="btn btn-danger btn-sm btn-hover btn-delete-tugas"
                                                            type="button">Hapus</button>
                                                    </div>
                                                </div>
                                                <p class="informasi-tambahan">
                                                    <span class="tanggal">
                                                        Monday, 25 October 2023 12:00 |
                                                    </span>
                                                    <span class="status">
                                                        Status: belum selesai
                                                    </span>
                                                    <span class="skala-prioritas">
                                                        | Skala Prioritas: Penting
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="card mt-4" style="display: none;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Form Edit Catatan Harian</h5>
                                                    <form action="/updateCatatan/1" method="POST">
                                                        <div class="mb-3">
                                                            <label for="hari" class="form-label">Hari:</label>
                                                            <input type="date" name="hari" id="hari"
                                                                class="form-control" value="2023-10-25" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kegiatan" class="form-label">Kegiatan:</label>
                                                            <input type="text" name="kegiatan" id="kegiatan"
                                                                class="form-control" value="Sample Task 1" required>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-md-12">
                                                                <div class="d-flex justify-content-center gap-2 ">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-cancel-edit">Batal
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="addTugas" style="display: none;">
                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <form action="/storeTugas" method="POST">
                                                            <div id="tugasRow"></div>
                                                            <div class="row mt-4">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="button"
                                                                            class="submit-button btn btn-primary"
                                                                            value="submit"
                                                                            id="submitAllForms">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mt-3" style="display: none;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Form Edit Tugas</h5>
                                                    <form id="editForm" class="dynamic-form">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="mb-3 d-flex justify-content-between align-items-center">
                                                                    <label for="DESK_TUGAS" class="form-label">Deskripsi
                                                                        Tugas:</label>
                                                                </div>
                                                                <textarea name="DESK_TUGAS" class="form-control" required></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="TENGGAT_WAKTU" class="form-label">Waktu
                                                                        Pengumpulan:</label>
                                                                    <input type="datetime-local" name="TENGGAT_WAKTU"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="STATUS" class="form-label">Status
                                                                        Tugas:</label>
                                                                    <select name="STATUS" class="form-control" required>
                                                                        <option value="0">Belum Selesai</option>
                                                                        <option value="1">Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-md-12">
                                                                <div class="d-flex justify-content-center gap-2">
                                                                    <button type="button"
                                                                        class="submit-button btn btn-primary"
                                                                        id="submitAllForms">Simpan</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-cancel-edit">Batal</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script>
        // script Menampilkan Form Buat catatan
        $(document).ready(function() {
            $('#buatCatatanButton').click(function() {
                let btn = $('#buatCatatanButton');
                let form = $('#isiContentSection');
                let btnDelete = $('.btn-delete');

                if (form.is(':visible')) {
                    btn.html("<i class='bx bx-plus'></i> Buat Catatan");
                    btn.removeClass('btn-danger').addClass('btn-success');
                    btnDelete.show(); // Menampilkan tombol hapus catatan
                } else {
                    btn.html("<i class='bx bx-minus'></i> Batal");
                    btn.removeClass('btn-success').addClass('btn-danger');
                    btnDelete.hide(); // Menyembunyikan tombol hapus catatan
                }

                form.slideToggle();
            });
        });

        // Update kategori pada
        $(document).ready(function() {
            $('select[name="kategoriSelect"]').change(function() {
                let catatanId = $(this).data('catatan-id');
                let kategoriId = $(this).val();
                let updateKategoriUrl = "{{ route('updateKategori', ':id') }}".replace(':id', catatanId);

                $.ajax({
                    url: updateKategoriUrl,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        kategori_id: kategoriId
                    },
                    success: function(response) {
                        showNotification(response.message, 'success');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        showNotification('Terjadi kesalahan saat mengupdate kategori.',
                            'danger');
                    }
                });
            });
        });

        // script untuk menghapus catatan dan tugas
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                let catatanId = $(this).data('catatan-id');
                let deleteUrl = "{{ route('deleteCatatan', ':id') }}".replace(':id', catatanId);

                // Konfirmasi dialog sebelum menghapus catatan
                if (confirm('Apakah Anda yakin ingin menghapus catatan ini beserta tugas yang terkait?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Menghapus div kolom yang sesuai dengan catatan yang dihapus
                            $('.col-md-6[data-catatan-id="' + catatanId + '"]').remove();
                            showNotification(response.message, 'success');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            showNotification('Terjadi kesalahan saat menghapus catatan.',
                                'danger');
                        }
                    });
                }
            });
        });

        // script untuk edit catatan
        $(document).ready(function() {
            // Menampilkan form edit catatan
            $(document).on('click', '.btn-edit', function() {
                let card = $(this).closest('.card');
                let form = card.next('.card');

                form.show();
            });

            // Menyembunyikan form edit catatan dan menampilkan card
            $(document).on('click', '.btn-cancel-edit', function() {
                let form = $(this).closest('.card');
                let card = form.prev('.card');

                form.hide();
                card.show();
            });
        });

        // script untuk menambahkan form tugas
        $(document).ready(function() {
            let formCounter = 0;

            $(document).on('click', '.buatListTugasButton', function() {
                let catatanId = $(this).data('catatan-id');
                let addTugasSection = $('#addTugas[data-catatan-id="' + catatanId + '"]');
                let tugasRow = addTugasSection.find('#tugasRow');

                // Increment the formCounter for unique form ID
                formCounter++;

                // Generate unique form ID
                let formId = 'formTugas' + formCounter;

                // Variabel untuk Buat form tugas baru
                let newTugasForm = `
                <form id="${formId}" class="dynamic-form" action="{{ route('storeTugas') }}" method="POST">
                    @csrf
                    <!-- Form input untuk deskripsi, tenggat_waktu, status, dll. -->

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <label for="DESK_TUGAS" class="form-label">Nama Tugas :</label>
                                <button class="hapusTugasButton btn btn-danger ml-2" type="button" data-catatan-id="${catatanId}">Hapus</button>
                            </div>
                            <input name="DESK_TUGAS" class="form-control" required></input>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="TENGGAT_WAKTU" class="form-label">Waktu Pengumpulan:</label>
                                <input type="datetime-local" name="TENGGAT_WAKTU" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="STATUS" class="form-label">Status Tugas:</label>
                                <select name="STATUS" class="form-control" required>
                                    <option value="0">Belum Selesai</option>
                                    <option value="1">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Skala_Prioritas" class="form-label">Skala Prioritas:</label>
                                <select name="Skala_Prioritas" class="form-control" required>
                                    <option value="0">Tidak Penting</option>
                                    <option value="1">Penting</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="jadwalharian_id" value="${catatanId}">
                    <input type="hidden" name="mahasiswaId" value="{{ $usersId }}">
                </form>
            `;

                tugasRow.prepend(newTugasForm);
                addTugasSection.show();
            });

            $(document).on('click', '.hapusTugasButton', function() {
                let catatanId = $(this).data('catatan-id');
                $(this).closest('form').remove();

                formCounter--;
                if (formCounter === 0) {
                    $('#addTugas[data-catatan-id="' + catatanId + '"]').hide();
                }
            });

            $(document).on('click', '#submitAllForms', function() {
                let forms = $('.dynamic-form');

                // iterasi/refresh dan pengiriman form menggunakan AJAX
                forms.each(function() {
                    let form = $(this);

                    console.log(form)

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            form.serialize()
                        },
                        error: function(xhr) {
                            xhr
                        }
                    });
                });

                location.reload();
            });
        });

        // script untuk menghapus div dan isi database form tugas spesifik
        $(document).ready(function() {
            $(document).on('click', '.btn-delete-tugas', function() {
                let tugasId = $(this).data('tugas-id');
                let deleteUrl = "{{ route('deleteTugas', ':id') }}".replace(':id', tugasId);

                // Konfirmasi dialog sebelum menghapus tugas
                if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Menghapus div tugas yang sesuai dengan tugas yang dihapus
                            $('.tugas-item[data-tugas-id="' + tugasId + '"]').remove();
                            showNotification(response.message, 'success');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            showNotification('Terjadi kesalahan saat menghapus tugas.',
                                'danger');
                        }
                    });
                }
            });
        });

        // script untuk memunculkan form edit tugas dan update tabel tugas spesifik
        $(document).ready(function() {
            // Ketika tombol "Edit" di klik, tampilkan form edit dan isi data tugas yang sesuai
            $(document).on('click', '.btn-edit-tugas', function() {
                let tugasId = $(this).data('tugas-id'); // Ambil ID tugas dari atribut data-tugas-id
                let form = $('.card.mt-3');

                // Ambil data tugas dari paragraf dan isikan ke dalam form
                let deskripsi = $(this).parent().find('.deskripsi-tugas').text();
                let tenggatWaktu = $(this).parent().find('.tenggat-waktu').text();
                let status = $(this).parent().find('.status-tugas').text();

                form.find('textarea[name="DESK_TUGAS"]').val(deskripsi);
                form.find('input[name="TENGGAT_WAKTU"]').val(tenggatWaktu);
                form.find('select[name="STATUS"]').val(status === 'selesai' ? 1 : 0);

                // Tampilkan form edit
                form.show();
            });

            // Ketika tombol "Cancel" pada form edit di klik, sembunyikan form edit
            $(document).on('click', '.btn-cancel-edit', function() {
                let form = $('.card.mt-3');
                form.hide();
            });

            // Submit form (with AJAX request)
            $(document).on('click', '.submit-button', function() {
                let form = $('#editForm');
                let data = form.serialize();
                let tugasId =
                    '{{ $tugass->id ?? null }}'; // Use null as default if $tugass->id is not defined

                if (tugasId === null) {
                    // Handle case where tugasId is not defined or the user has no tasks
                    console.log('Tugas ID is not defined');

                    return;
                }

                $.ajax({
                    url: '/tugas/' + tugasId,
                    type: 'PUT', // Menggunakan metode PUT karena ingin mengupdate data
                    data: data,
                    success: function(response) {
                        // Handle success response, misalnya memberikan pesan sukses atau mengambil data terbaru
                        console.log(response);
                    },
                    error: function(error) {
                        // Handle error response, misalnya memberikan pesan error atau menangani kesalahan lainnya
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
