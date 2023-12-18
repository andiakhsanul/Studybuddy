@extends('Layout.appUser')

@section('content')
    <div class="row pt-4">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header text-center bg-primary">
                    <h4 class="text-white">Catatan Harian {{ $namaUser }}</h4>
                </div>
                <div class="card-body">
                    {{-- List Catatan --}}
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-primary" style="margin-right: 10px;">List Catatan :</h5>
                        <button id="buatCatatanButton"
                            class="btn btn-success btn-hover btn-sm ml-2 mb-0 me-2 d-flex align-items-center" type="button"
                            style="margin-right: 10px;">
                            <i class="bx bx-plus" style="margin-right: 5px;"></i> Buat Catatan
                        </button>
                    </div>
                    <hr>

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
                                                {{-- Menampilkan Tugas --}}
                                                @php
                                                    $globalIteration = 0;
                                                @endphp

                                                @foreach ($tugas as $tugass)
                                                    @php
                                                        $globalIteration++;
                                                    @endphp
                                                    @if ($tugass->jadwalharian_id == $catatan->id)
                                                        <div class="tugas-item" data-tugas-id="{{ $tugass->id }}">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="deskripsi-tugas">
                                                                    Tugas {{ $globalIteration }} |
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
                                                                    {{ date('l, j-n-Y H:i', strtotime($tugass->TENGGAT_WAKTU)) }}
                                                                    |
                                                                </span>
                                                                <span class="status">
                                                                    Status Tugas :
                                                                    @if ($tugass->STATUS == 1)
                                                                        {{ 'Selesai | ' }}
                                                                    @else
                                                                        {{ 'Belum Selesai | ' }}
                                                                    @endif
                                                                </span>
                                                                <span class="skala-prioritas">
                                                                    Skala Prioritas:
                                                                    {{ $tugass->Skala_Prioritas == 1 ? 'Penting' : 'Kurang Penting' }}
                                                                    |
                                                                </span>
                                                            </p>
                                                        </div>

                                                        {{-- Form Edit Tugas --}}
                                                        <div class="card mt-3 edit-tugas-form" style="display: none;"
                                                            data-catatan-id="{{ $catatan->id }}"
                                                            data-tugas-id="{{ $tugass->id }}">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Form Edit Tugas</h5>
                                                                <form id="editForm" class="dynamic-form"
                                                                    data-tugas-id="{{ $tugass->id }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <!-- Form edit untuk deskripsi, tenggat_waktu, status, dll. -->
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="mb-3 d-flex justify-content-between align-items-center">
                                                                                <label for="DESK_TUGAS"
                                                                                    class="form-label">Deskripsi
                                                                                    Tugas:</label>
                                                                            </div>
                                                                            <textarea name="DESK_TUGAS" class="form-control" required></textarea>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="TENGGAT_WAKTU"
                                                                                    class="form-label">Waktu
                                                                                    Pengumpulan:</label>
                                                                                <input type="datetime-local"
                                                                                    name="TENGGAT_WAKTU"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="STATUS"
                                                                                    class="form-label">Status
                                                                                    Tugas:</label>
                                                                                <select name="STATUS"
                                                                                    class="form-control" required>
                                                                                    <option value="0">Belum Selesai
                                                                                    </option>
                                                                                    <option value="1">Selesai</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-4">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="d-flex justify-content-center gap-2">
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
                                                <div class="mb-3">
                                                    <label for="kategori" class="form-label">Kategori :</label>
                                                    <select name="kategori" id="kategori" class="form-select" required>
                                                        <option value="" selected disabled>Pilih Kategori</option>
                                                        @foreach ($kategoris as $kategori)
                                                            <option value="{{ $kategori->id }}"
                                                                {{ $catatan->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                {{ $kategori->Nama_Kategori }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    btnDelete.show();
                } else {
                    btn.html("<i class='bx bx-minus'></i> Batal");
                    btn.removeClass('btn-success').addClass('btn-danger');
                    btnDelete.hide();
                }

                form.slideToggle();
            });
        });

        // Update kategori pada catatan
        $(document).ready(function() {
            $('select[name="kategoriSelect"]').change(function() {
                let catatanId = $(this).data('catatan-id');
                let kategoriId = $(this).val();
                let updateKategoriUrl = "{{ url('catatan') }}/" + catatanId + "/update-kategori";

                $.ajax({
                    url: updateKategoriUrl,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        kategori_id: kategoriId
                    },
                    success: function(response) {
                        setTimeout(function() {
                            location.reload();
                        }, 200);
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
    </script>

    <script>
        // script untuk menambahkan form tugas
        $(document).ready(function() {
            let formCounter = 0;

            $(document).on('click', '.buatListTugasButton', function() {
                let catatanId = $(this).data('catatan-id');
                let addTugasSection = $('#addTugas[data-catatan-id="' + catatanId + '"]');
                let tugasRow = addTugasSection.find('#tugasRow');

                formCounter++;

                let formId = 'formTugas' + formCounter;

                let newTugasForm = `
                <form id="${formId}" class="dynamic-form" action="{{ route('storeTugas') }}" method="POST">
                    @csrf
                    <!-- Form input untuk deskripsi, tenggat_waktu, status, dll. -->

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <label for="DESK_TUGAS" class="form-label">Deskripsi Tugas:</label>
                                <button class="hapusTugasButton btn btn-danger ml-2" type="button" data-catatan-id="${catatanId}">Hapus</button>
                            </div>
                            <textarea name="DESK_TUGAS" class="form-control" required></textarea>
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
                                    <option value="1">Penting</option>
                                    <option value="0">Kurang Penting</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="jadwalharian_id" value="${catatanId}">
                    <input type="hidden" name="usersId" value="{{ $usersId }}">
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

        // delete tugas
        $(document).ready(function() {
            $(document).on('click', '.btn-delete-tugas', function() {
                let tugasId = $(this).data('tugas-id');
                let deleteUrl = "{{ route('deleteTugas', ':id') }}".replace(':id', tugasId);

                if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
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

        // edit tugas
        $(document).ready(function() {
            // show edit specifik
            $('.btn-edit-tugas').on('click', function() {
                var tugasId = $(this).data('tugas-id');
                var catatanId = $(this).closest('.col-md-6').data('catatan-id');

                // Hide all other edit forms
                $('.edit-tugas-form').hide();

                // Show the edit form for the clicked task
                $('.edit-tugas-form[data-catatan-id="' + catatanId + '"][data-tugas-id="' + tugasId + '"]')
                    .show();
            });

            // Cancel edit
            $('.btn-cancel-edit').on('click', function() {
                $(this).closest('.edit-tugas-form').hide();
            });

            $('.submit-button').on('click', function() {
                var form = $(this).closest('form.dynamic-form');
                var tugasId = form.data('tugas-id');

                $.ajax({
                    type: 'PUT',
                    url: '/tugas/' + tugasId,
                    data: form.serialize(),
                    success: function(response) {
                        console.log(response);
                        form.hide();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
