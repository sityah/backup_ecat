<?php include "akses.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php
        date_default_timezone_set('Asia/Jakarta');
    ?>
</head>
<style>
    .capitalize {
        text-transform: capitalize;
    }
</style>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Perusahaan</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 25%;">Nama Perusahaan</th>
                                                <th scope="col" style="width: 35%;">Alamat</th>
                                                <th scope="col" style="width: 10%;">No. Telp</th>
                                                <th scope="col" style="width: 10%;">Email</th>
                                                <th scope="col" style="width: 15%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_provinsi
                                                $query = "SELECT * FROM tb_perusahaan";
                                                $result = mysqli_query($koneksi, $query);

                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_perusahaan'] . "</td>"; 
                                                    echo "<td>" . $row['alamat_perusahaan'] . "</td>"; 
                                                    echo "<td>" . $row['no_telp_perusahaan'] . "</td>"; 
                                                    echo "<td>" . $row['email_perusahaan'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                data-id_perusahaan='" . $row['id_perusahaan'] . "'    
                                                                data-nama_perusahaan='" . $row['nama_perusahaan'] . "'
                                                                data-alamat_perusahaan='" . $row['alamat_perusahaan'] . "'
                                                                data-no_telp_perusahaan='" . $row['no_telp_perusahaan'] . "'
                                                                data-email_perusahaan='" . $row['email_perusahaan'] . "'
                                                                data-updatedby='" . $row['updated_by'] . "'
                                                                data-updated='" . $row['updated_date'] . "'>
                                                                <i class='bx bx-edit-alt'></i>
                                                            </button>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_perusahaan'] . "'>
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                        </td>";
                                                    echo "</tr>";
                                                }

                                                mysqli_close($koneksi);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Input -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Perusahaan</h5>
            </div>
            <hr class="m-4 mt-2" />
            <div class="modal-body">
                <!-- Formulir untuk menambah data provinsi -->
                <form action="proses/proses_perusahaan.php" method="POST">
                <?php 
                  $uuid = generateUUID(); 
                  $hari = date('d');
                  $tahun = date('y');
                  $pruuid = "PR$uuid$hari$tahun";
                ?>
                    <input type="hidden" class="form-control" name="id_perusahaan" id="id" value = "<?php echo $pruuid ?>">
                    <label><strong>Jenis Perusahaan</strong></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_perusahaan" id="inlineRadio1" value="Negeri" required>
                            <label class="form-check-label" for="inlineRadio1">Negeri</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_perusahaan" id="inlineRadio2" value="Swasta" required>
                            <label class="form-check-label" for="inlineRadio2">Swasta</label>
                        </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama Perusahaan *</label>
                            <input type="text" name="nama_perusahaan" class="form-control capitalize" placeholder="Tulis Nama Perusahaan" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Alamat Perusahaan *</label>
                            <textarea class="form-control capitalize" name="alamat_perusahaan" required></textarea>
                        </div>
                    </div>
                    <div id="selectData" class="mb-3">
                        <!-- Provinsi -->
                        <div class="col-sm mb-3">
                            <label class="form-label"><strong>Wilayah / Provinsi *</strong></label>
                            <select class="form-select" id="id_provinsi_select" name="id_provinsi_select" required>
                                <option value="">Pilih Wilayah/Provinsi</option>
                                <?php
                                include "koneksi.php";
                                $query_provinsi = "SELECT * FROM tb_provinsi";
                                $result_provinsi = mysqli_query($koneksi, $query_provinsi);
                                while ($data_provinsi = mysqli_fetch_array($result_provinsi)) {
                                    echo '<option value="' . $data_provinsi['id_provinsi'] . '">' . $data_provinsi['nama_provinsi'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Kota/Kabupaten -->
                        <div class="col-sm mb-3">
                            <label id="id_kota_kab_label" class="form-label"><strong>Kota / Kabupaten *</strong></label>
                            <select name="id_kota_kab_select" id="id_kota_kab_select" class="form-select" required>
                                <option value="">Pilih Kota/Kabupaten</option>
                                <!-- Opsi kota/kabupaten akan diisi melalui JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">No. Telp *</label>
                            <input type="text" name="no_telp_perusahaan" class="form-control" pattern="[0-9]+" minlength="11" maxlength="13" placeholder="Contoh: 0856xxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Email *</label>
                            <input type="text" name="email_perusahaan" class="form-control" pattern=".+@.+" placeholder="name@example.com" required oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-perusahaan">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/vendor/selectize-js/dist/js/selectize.min.js"></script>
    <script>
        $('.normalize2').selectize();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable
            new DataTable('#ecat');

        // Menangani perubahan pada pilihan 
        $('#id_provinsi_select').selectize();
       // $('#id_perusahaan_select').selectize();

        // Fungsi untuk mendapatkan HTML default kota/kabupaten
        function getDefaultKotaKabHtml() {
            return '<option value=""></option>' + defaultProvinsiAData;
        }

        // Simpan data default provinsi A
        var defaultProvinsiAData = $('#id_kota_kab_select').html();

        $('#id_provinsi_select').change(function() {
            var selectedProvinsi = $(this).val();
            var kotaKabSelect = $('#id_kota_kab_select');
            var kotaKabLabel = $('#id_kota_kab_label');

            // Periksa apakah selectize telah diinisialisasi sebelumnya
            if (kotaKabSelect[0].selectize) {
                // Hancurkan instance selectize sebelum inisialisasi baru
                kotaKabSelect[0].selectize.destroy();
            }

            // Reset data kota/kabupaten ke data default jika tidak ada provinsi yang dipilih
            if (!selectedProvinsi) {
                kotaKabSelect.html(getDefaultKotaKabHtml());
                // Inisialisasi atau perbarui selectize setelah mengubah opsi
                kotaKabSelect.hide();
                kotaKabLabel.hide();
                return;
            }

            // Pastikan provinsi yang dipilih tidak kosong
            // Mengirim permintaan ke server untuk mendapatkan data kota/kabupaten
            $.post('get_kota_kabupaten.php', { id_provinsi_select: selectedProvinsi }, function(data) {
                // Memperbarui opsi kota/kabupaten
                kotaKabSelect.html(getDefaultKotaKabHtml() + data);

                kotaKabSelect.show();
                kotaKabLabel.show();

                // Inisialisasi atau perbarui selectize setelah mengubah opsi
                kotaKabSelect.selectize({
                sortField: 'text', 
            });
            }).fail(function() {
                // Tangani kesalahan jika ada
                console.error('Gagal mendapatkan data kota/kabupaten.');
            });
        });

        // Inisialisasi DataTable pada halaman pertama load
        new DataTable('#ecat');
    });
    </script>
    

    <?php
function generateUUID() {
    // Generate 16 bytes of random data
    $data = random_bytes(16);

    // Set the version (4) and variant (0100)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert the binary data to a hexadecimal string
    $uuid = vsprintf('%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
}

?>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_perusahaan.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Perusahaan</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Perusahaan :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-perusahaan" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function () {
        $('table').each(function () {
            new DataTable($(this)[0]);
        });

            $('#addPerusahaanForm').on('submit', function(event) {
        event.preventDefault();

        // Mengambil data formulir
        var formData = $("#addPerusahaanForm").serialize();

        $('#modalCenter').modal('hide');
        });

        // Plugins Search Select
        $('.normalize').selectize();


        // Function DELETE
        $(document).on('click', '.btn-delete', function() {
        var perusahaanId = $(this).data('id');
        var namaPerusahaan = $(this).closest('tr').find('td:nth-child(2)').text();

        // Set ID dan nama provinsi untuk digunakan di tombol "Ya, Hapus"
        $('#modalDeleteBtn').data('id', perusahaanId);
        $('#modalDeleteBtn').data('perusahaan', namaPerusahaan);

        // Set pesan konfirmasi dengan nama instansi yang akan dihapus
        var modalText = "Apakah anda yakin hapus data Perusahaan '<b>" + namaPerusahaan + "</b>'?";
        $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="perusahaanIdInput" name="id_perusahaan" value="' + perusahaanId + '" style="display:none;">');

        $('#modalDelete').on('hidden.bs.modal', function() {
        });

        $('#modalDelete').modal('show');
        });


        $('#modalDeleteBtn').on('click', function () {
            var perusahaanId = $(this).data('id');
            var namaPerusahaan = $(this).data('perusahaan');

            $('#modalDelete').modal('hide');

            // Lakukan operasi hapus di sini menggunakan customerId 
            // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
            console.log("Menghapus data dengan ID:", perusahaanId);
            console.log("Instansi yang dihapus:", namaPerusahaan);
        });
    });
    </script>
</body>
</html>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTitle">Edit Data Perusahaan</h5>
                </div>
                <form action="proses/proses_perusahaan.php" method="POST">
                    <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_perusahaan" name="id_perusahaan" class="form-control" value="<?php echo $data_lama['id_perusahaan']; ?>" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text" id="nama" name="nama_perusahaan" class="form-control capitalize" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Alamat Perusahaan</label>
                                <input type="text" id="alamat" name="alamat_perusahaan" class="form-control capitalize" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">No. Telp</label>
                                <input type="text" id="no_telp" name="no_telp_perusahaan" class="form-control" pattern="[0-9]+" minlength="11" maxlength="13" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" id="email" name="email_perusahaan" class="form-control" pattern=".+@.+" required oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        <input type="text" name="updated" class="form-control" value="<?php echo date('d/m/y h:i:s') ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-perusahaan">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Handler Tombol Edit
    $('.btn-edit').on('click', function () {
        // Mendapatkan data dari tombol yang ditekan
        var id_perusahaan = $(this).data('id_perusahaan');
        var nama_perusahaan = $(this).data('nama_perusahaan');
        var alamat_perusahaan = $(this).data('alamat_perusahaan');
        var no_telp_perusahaan = $(this).data('no_telp_perusahaan');
        var email_perusahaan = $(this).data('email_perusahaan');
        var updatedby = $(this).data('updatedby');
        var updated = $(this).data('updated');

        // Set values for the edit form
        $('#id_perusahaan').val(id_perusahaan);
        $('#nama').val(nama_perusahaan);
        $('#alamat').val(alamat_perusahaan);
        $('#no_telp').val(no_telp_perusahaan);
        $('#email').val(email_perusahaan);

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });
    $('.normalize').selectize();
        </script>


