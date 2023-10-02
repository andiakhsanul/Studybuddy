// Sidebar User
document.addEventListener("DOMContentLoaded", function () {
    var navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            var target = this.getAttribute("href");

            navLinks.forEach(function (link) {
                link.classList.remove("active");
            });
            this.classList.add("active");

            if (target) {
                document.querySelector(".main-content").innerHTML =
                    "Loading..."; // Menampilkan pesan loading (opsional)
                setTimeout(function () {
                    window.location.href = target; // Mengarahkan ke halaman tujuan setelah jeda waktu (opsional)
                }, 500); // Ubah angka 500 sesuai kebutuhan waktu jeda (opsional)
            }
        });
    });
});

// Isi Form Buat Catatan
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("buatCatatanButton")
        .addEventListener("click", function () {
            document.getElementById("isiContentSection").style.display =
                "block";
        });
});

// script Menampilkan Form Buat catatan
$(document).ready(function () {
    $("#buatCatatanButton").click(function () {
        let btn = $("#buatCatatanButton");
        let form = $("#isiContentSection");
        let btnDelete = $(".btn-delete");

        if (form.is(":visible")) {
            btn.html("<i class='bx bx-plus'></i> Buat Catatan");
            btn.removeClass("btn-danger").addClass("btn-success");
            btnDelete.show(); // Menampilkan tombol hapus catatan
        } else {
            btn.html("<i class='bx bx-minus'></i> Batal");
            btn.removeClass("btn-success").addClass("btn-danger");
            btnDelete.hide(); // Menyembunyikan tombol hapus catatan
        }

        form.slideToggle();
    });
});

// script untuk menghapus catatan dan tugas
$(document).ready(function () {
    $(document).on("click", ".btn-delete", function () {
        let catatanId = $(this).data("catatan-id");
        let deleteUrl = "{{ route('deleteCatatan', ':id') }}".replace(
            ":id",
            catatanId
        );

        // Konfirmasi dialog sebelum menghapus catatan
        if (
            confirm(
                "Apakah Anda yakin ingin menghapus catatan ini beserta tugas yang terkait?"
            )
        ) {
            $.ajax({
                url: deleteUrl,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    // Menghapus div kolom yang sesuai dengan catatan yang dihapus
                    $(
                        '.col-md-6[data-catatan-id="' + catatanId + '"]'
                    ).remove();
                    showNotification(response.message, "success");
                },
                error: function (xhr) {
                    console.log(xhr);
                    showNotification(
                        "Terjadi kesalahan saat menghapus catatan.",
                        "danger"
                    );
                },
            });
        }
    });
});

// script untuk edit catatan
$(document).ready(function () {
    // Menampilkan form edit catatan
    $(document).on("click", ".btn-edit", function () {
        let card = $(this).closest(".card");
        let form = card.next(".card");

        form.show();
    });

    // Menyembunyikan form edit catatan dan menampilkan card
    $(document).on("click", ".btn-cancel-edit", function () {
        let form = $(this).closest(".card");
        let card = form.prev(".card");

        form.hide();
        card.show();
    });
});

// script untuk menambahkan form tugas
$(document).ready(function () {
    let formCounter = 0;

    $(document).on("click", ".buatListTugasButton", function () {
        let catatanId = $(this).data("catatan-id");
        let addTugasSection = $(
            '#addTugas[data-catatan-id="' + catatanId + '"]'
        );
        let tugasRow = addTugasSection.find("#tugasRow");

        // Increment the formCounter for unique form ID
        formCounter++;

        // Generate unique form ID
        let formId = "formTugas" + formCounter;

        // Variabel untuk Buat form tugas baru
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
                    </div>
                    <input type="hidden" name="jadwalharian_id" value="${catatanId}">
                    <input type="hidden" name="usersId" value="{{ $usersId }}">
                </form>
            `;

        tugasRow.prepend(newTugasForm);
        addTugasSection.show();
    });

    $(document).on("click", ".hapusTugasButton", function () {
        let catatanId = $(this).data("catatan-id");
        $(this).closest("form").remove();

        formCounter--;
        if (formCounter === 0) {
            $('#addTugas[data-catatan-id="' + catatanId + '"]').hide();
        }
    });

    $(document).on("click", "#submitAllForms", function () {
        let forms = $(".dynamic-form");

        // iterasi/refresh dan pengiriman form menggunakan AJAX
        forms.each(function () {
            let form = $(this);

            console.log(form);

            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: form.serialize(),
                success: function (response) {
                    form.serialize();
                },
                error: function (xhr) {
                    xhr;
                },
            });
        });

        location.reload();
    });
});

// script untuk menghapus div dan isi database form tugas spesifik
$(document).ready(function () {
    $(document).on("click", ".btn-delete-tugas", function () {
        let tugasId = $(this).data("tugas-id");
        let deleteUrl = "{{ route('deleteTugas', ':id') }}".replace(
            ":id",
            tugasId
        );

        // Konfirmasi dialog sebelum menghapus tugas
        if (confirm("Apakah Anda yakin ingin menghapus tugas ini?")) {
            $.ajax({
                url: deleteUrl,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    // Menghapus div tugas yang sesuai dengan tugas yang dihapus
                    $('.tugas-item[data-tugas-id="' + tugasId + '"]').remove();
                    showNotification(response.message, "success");
                },
                error: function (xhr) {
                    console.log(xhr);
                    showNotification(
                        "Terjadi kesalahan saat menghapus tugas.",
                        "danger"
                    );
                },
            });
        }
    });
});

// script untuk memunculkan form edit tugas dan update tabel tugas spesifik
$(document).ready(function () {
    // Ketika tombol "Edit" di klik, tampilkan form edit dan isi data tugas yang sesuai
    $(document).on("click", ".btn-edit-tugas", function () {
        let tugasId = $(this).data("tugas-id"); // Ambil ID tugas dari atribut data-tugas-id
        let form = $(".card.mt-3");

        // Ambil data tugas dari paragraf dan isikan ke dalam form
        let deskripsi = $(this).parent().find(".deskripsi-tugas").text();
        let tenggatWaktu = $(this).parent().find(".tenggat-waktu").text();
        let status = $(this).parent().find(".status-tugas").text();

        form.find('textarea[name="DESK_TUGAS"]').val(deskripsi);
        form.find('input[name="TENGGAT_WAKTU"]').val(tenggatWaktu);
        form.find('select[name="STATUS"]').val(status === "selesai" ? 1 : 0);

        // Tampilkan form edit
        form.show();
    });

    // Ketika tombol "Cancel" pada form edit di klik, sembunyikan form edit
    $(document).on("click", ".btn-cancel-edit", function () {
        let form = $(".card.mt-3");
        form.hide();
    });

    // Submit form (with AJAX request)
    $(document).on("click", ".submit-button", function () {
        let form = $("#editForm");
        let data = form.serialize();
        let tugasId = "{{ $tugass->id ?? null }}"; // Use null as default if $tugass->id is not defined

        if (tugasId === null) {
            // Handle case where tugasId is not defined or the user has no tasks
            console.log("Tugas ID is not defined");

            return;
        }

        $.ajax({
            url: "/tugas/" + tugasId,
            type: "PUT", // Menggunakan metode PUT karena ingin mengupdate data
            data: data,
            success: function (response) {
                // Handle success response, misalnya memberikan pesan sukses atau mengambil data terbaru
                console.log(response);
            },
            error: function (error) {
                // Handle error response, misalnya memberikan pesan error atau menangani kesalahan lainnya
                console.error(error);
            },
        });
    });
});
