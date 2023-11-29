@extends('Layout.appadmin')

@section('content')
    <main>
        <h1>Kategori Catatan</h1>
        <div class="analyse">
            <div class="searches">
                <div class="status">
                    <div class="info">
                        <h3>Kategori Catatan</h3>
                    </div>
                </div>
                <div class="status" style="margin-top: 30%; margin-left:18%; margin-bottom:10%">
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36"
                                style="stroke-dasharray: {{ $kategoriCount * 20 }} 200;"></circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $kategoriCount * 2 }}</p>
                        </div>
                    </div>
                </div>
                <h1 style="text-align: center">{{ $kategoriCount }}</h1>
            </div>
            <div class="searches">
                <div class="kategori-usage">
                    <h3>Kategori Penggunaan</h3>
                    <ul>
                        @foreach ($kategoriUsage as $usage)
                            <li>
                                Kategori {{ $usage->nama_kategori }}: {{ $usage->total }} kali dipakai
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="chart-container">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Kategori</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="addKategoriButton" class="btn btn-success btn-sm rounded"
                                style="background-color: #1B9C85;">
                                <i class="typcn typcn-plus"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body border p-3" id="createKategoriForm"
                                style="display: none; margin-top: 10px; background-color: #fffefe; border-radius: 5px;">
                                <h3 class="card-title">Tambah Kategori Baru</h3>
                                <form id="kategoriForm" action="{{ route('tambahKategori') }}" method="POST">
                                    @csrf
                                    <div class="form-group d-flex">
                                        <label for="namaKategori" class="mr-2">Nama Kategori</label>
                                        <input type="text" class="form-control bold" id="namaKategori"
                                            name="namaKategori" style="height: 20px;">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm ml-4"
                                        style="width: auto;">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-3" style="max-width: 100%;">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="text-align: center;">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $kat)
                                    <tr>
                                        <td style="text-align: center;">{{ $kat->id }}</td>
                                        <td>{{ $kat->Nama_Kategori }}</td>
                                        <td>
                                            <button data-id="{{ $kat->id }}"
                                                class="btn btn-warning btn-sm editKategori"
                                                style="background-color: #FFA500;">
                                                <i class="typcn typcn-pencil"></i> Edit
                                            </button>
                                            <button data-id="{{ $kat->id }}"
                                                class="btn btn-danger btn-sm deleteKategori"
                                                style="background-color: #FF0060;">>
                                                <i class="typcn typcn-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body border p-3" id="editKategoriFormRow" style="display: none;">
            <form id="editKategoriForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="edit_kategori_id" id="edit_kategori_id" value="">
                <div class="form-group">
                    <label for="edit_namaKategori">Nama Kategori</label>
                    <input type="text" class="form-control" name="edit_namaKategori" id="edit_namaKategori">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-success btn-sm mr-2">Simpan</button>
                    <button type="button" id="cancelEditKategori" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </form>
        </div>
    </main>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addKategoriButton').click(function() {
            let form = $('#createKategoriForm');
            form.toggle();
        });

        $('#kategoriForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#createKategoriForm').slideUp();

                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Gagal menambahkan kategori. Silakan coba lagi.');
                }
            });
        });

        $('table').on('click', '.editKategori', function() {
            var kategoriId = $(this).data('id');
            var kategoriName = $(this).closest('tr').find('td:nth-child(2)').text();

            $('#edit_kategori_id').val(kategoriId);
            $('#edit_namaKategori').val(kategoriName);

            $(this).hide();
            $(this).closest('tr').after($('#editKategoriFormRow'));

            $('#editKategoriFormRow').slideDown();
        });

        $('#cancelEditKategori').click(function() {
            $('#editKategoriFormRow').slideUp(function() {
                $(this).prev('tr').find('.editKategori').show();
            });
        });

        $('#editKategoriForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var kategoriId = $('#edit_kategori_id').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/edit-kategori/' + kategoriId,
                type: 'PUT',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#editKategoriFormRow').slideUp(function() {
                        $(this).prev('tr').find('.editKategori').show();
                    });

                    if ('Nama_Kategori' in response) {
                        // Update the cell in the row with the new data
                        $('td[data-kategori-id="' + kategoriId + '"]:nth-child(2)').text(
                            response.Nama_Kategori);
                            location.reload();
                    } else {
                        alert('Error: Unexpected response format');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to edit Kategori. Please check the console for details.');
                }
            });
        });

        $('table').on('click', '.deleteKategori', function() {
            var kategoriId = $(this).data('id');
            var clickedButton = $(this); // Save a reference to the clicked button
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/delete-kategori/' + kategoriId,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.error) {
                            alert('Error: ' + response.error);
                        } else {
                            // Remove the row from the table on the client side
                            clickedButton.closest('tr').remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Failed to delete category. Please try again.');
                    }
                });
            }
        });
    });
</script>
