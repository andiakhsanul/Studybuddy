@extends('Layout.appadmin')

@section('content')
    <main>
        <h1>Users StudyBuddy</h1>
        <div class="analyse">
            <div class="sales">
                <div class="status">
                    <div class="info">
                        <h3 style="text-align: center">Total Akun Users</h3>
                        <h1>{{ $userCount }}</h1>
                    </div>
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36" style="stroke-dasharray: {{ $userCount * 20 }} 200;">
                            </circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $userCount * 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar User</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="addUserButton" class="btn btn-success btn-sm rounded"
                                style="background-color: #1B9C85;">
                                <i class="typcn typcn-plus"></i> Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body border p-3" id="createUserForm"
                                style="display: none; margin-top: 10px; background-color: #fffefe; border-radius: 5px;">
                                <h3 class="card-title">Tambah User Baru</h3>
                                <form id="userForm" action="{{ route('tambahUser') }}" method="POST">
                                    @csrf
                                    <div class="form-group d-flex">
                                        <label for="namaUser" class="mr-2">Nama</label>
                                        <input type="text" class="form-control bold" id="namaUser" name="namaUser"
                                            style="height: 20px;">
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="nis" class="mr-2">NIS</label>
                                        <input type="text" class="form-control bold" id="nis" name="nis"
                                            style="height: 20px;">
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="alamat" class="mr-2">Alamat</label>
                                        <input type="text" class="form-control bold" id="alamat" name="alamat"
                                            style="height: 20px;">
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="email" class="mr-2">Email</label>
                                        <input type="email" class="form-control bold" id="email" name="email"
                                            style="height: 20px;">
                                    </div>
                                    <div class="form-group d-flex">
                                        <label for="password" class="mr-2">Password</label>
                                        <input type="password" class="form-control bold" id="password" name="password"
                                            style="height: 20px;">
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
                                    <th scope="col">Nama User</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Aktifitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="text-align: center;">{{ $user->id }}</td>
                                        <td>{{ $user->NAMA }}</td>
                                        <td>{{ $user->NIS }}</td>
                                        <td>{{ $user->EMAIL }}</td>
                                        <td>{{ $user->Role }}</td>
                                        <td>
                                            <button data-id="{{ $user->id }}" class="btn btn-warning btn-sm editUser"
                                                style="background-color: #FFA500;">
                                                <i class="typcn typcn-pencil"></i> Edit
                                            </button>
                                            <button data-id="{{ $user->id }}" class="btn btn-danger btn-sm deleteUser"
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

        <div class="card-body border p-3" id="editUserFormRow" style="display: none;">
            <form id="editUserForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                <div class="form-group">
                    <label for="edit_namaUser">Nama User</label>
                    <input type="text" class="form-control" name="edit_namaUser" id="edit_namaUser">
                </div>
                <div class="form-group">
                    <label for="edit_nis">NIS</label>
                    <input type="text" class="form-control" name="edit_nis" id="edit_nis">
                </div>
                <div class="form-group">
                    <label for="edit_alamat">Alamat</label>
                    <input type="text" class="form-control" name="edit_alamat" id="edit_alamat">
                </div>
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" class="form-control" name="edit_email" id="edit_email">
                </div>
                <div class="form-group">
                    <label for="edit_password">Password</label>
                    <input type="password" class="form-control" name="edit_password" id="edit_password">
                </div>
                <div class="form-group">
                    <label for="edit_role">Role</label>
                    <input type="text" class="form-control" name="edit_role" id="edit_role">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-success btn-sm mr-2">Simpan</button>
                    <button type="button" id="cancelEditUser" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </form>
        </div>
    </main>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addUserButton').click(function() {
            let form = $('#createUserForm');
            form.toggle();
        });

        $('#userForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#createUserForm').slideUp();

                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Gagal menambahkan user. Silakan coba lagi.');
                }
            });
        });

        $('table').on('click', '.editUser', function() {
            var userId = $(this).data('id');
            var userName = $(this).closest('tr').find('td:nth-child(2)').text();
            var userNis = $(this).closest('tr').find('td:nth-child(3)').text();
            var userAlamat = $(this).closest('tr').find('td:nth-child(4)').text();
            var userEmail = $(this).closest('tr').find('td:nth-child(5)').text();
            var userRole = $(this).closest('tr').find('td:nth-child(6)').text();

            // Log values for debugging
            console.log('userAlamat:', userAlamat);
            console.log('userEmail:', userEmail);
            console.log('userRole:', userRole);

            $('#edit_user_id').val(userId);
            $('#edit_namaUser').val(userName);
            $('#edit_nis').val(userNis);
            $('#edit_alamat').val(userAlamat);
            $('#edit_email').val(userEmail);
            $('#edit_role').val(userRole);

            $(this).hide();
            $(this).closest('tr').after($('#editUserFormRow'));

            $('#editUserFormRow').slideDown();
        });

        $('#cancelEditUser').click(function() {
            $('#editUserFormRow').slideUp(function() {
                $(this).prev('tr').find('.editUser').show();
            });
        });

        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var userId = $('#edit_user_id').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/edit-user/' + userId,
                type: 'PUT',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#editUserFormRow').slideUp(function() {
                        $(this).prev('tr').find('.editUser').show();
                    });

                    if ('NAMA' in response && 'NIS' in response && 'ALAMAT' in response &&
                        'EMAIL' in response && 'Role' in response) {
                        // Update each cell in the row with the new data
                        $('td[data-user-id="' + userId + '"]:nth-child(2)').text(response
                            .NAMA);
                        $('td[data-user-id="' + userId + '"]:nth-child(3)').text(response
                            .NIS);
                        $('td[data-user-id="' + userId + '"]:nth-child(4)').text(response
                            .ALAMAT);
                        $('td[data-user-id="' + userId + '"]:nth-child(5)').text(response
                            .EMAIL);
                        $('td[data-user-id="' + userId + '"]:nth-child(6)').text(response
                            .Role);
                    } else {
                        alert('Error: Unexpected response format');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to edit User. Please check the console for details.');
                }
            });
        });

        $('table').on('click', '.deleteUser', function() {
            var userId = $(this).data('id');
            var clickedButton = $(this); // Simpan referensi ke tombol yang diklik
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (confirm('Anda yakin ingin menghapus user ini?')) {
                $.ajax({
                    url: '/delete-user/' + userId,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.error) {
                            alert('Error: ' + response.error);
                        } else {
                            // Hapus baris dari tabel di sisi klien
                            clickedButton.closest('tr').remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Gagal menghapus user. Silakan coba lagi.');
                    }
                });
            }
        });

    });
</script>
