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
    <style>
    #id_kota_kab_select,
    #id_kota_kab_label {
        display: none; 
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Kota / Kabupaten</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 25%;">Nama Provinsi</th>
                                                <th scope="col" style="width: 60%;">Nama Kota / Kabupaten</th>
                                                <th scope="col" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_customer
                                                $query = "SELECT tb_kota.*, tb_provinsi.nama_provinsi 
                                                FROM tb_kota
                                                LEFT JOIN tb_provinsi ON tb_provinsi.id_provinsi = tb_kota.id_provinsi
                                                ORDER BY tb_provinsi.nama_provinsi, tb_kota.nama_kota_kab";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);

                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_provinsi'] . "</td>"; 
                                                    echo "<td>" . $row['nama_kota_kab'] . "</td>"; 
                                                    echo "<td>
                                                            <a href='edit_kota.php?id=" . $row['id_kota_kab'] . "' class='btn btn-warning btn-sm mt-2 btn-edit'><i class='bx bx-edit-alt'></i></a>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_kota_kab'] . "'>
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
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Kota / Kabupaten</h5>
            </div>
            <hr class="m-2" />
            <div class="modal-body">
                <!-- Formulir untuk menambah data kota/kab -->
                <form action="proses/proses_kota.php" method="POST">
                    <?php 
                        function generateUUID() {
                            return sprintf('%04x%04x',
                                mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                            );
                        }
                        $uuid = generateUUID(); 
                        $hari = date('d');
                        $bulan = date('m');
                        $tahun = date('y');
                        $ktuuid = "KT$tahun$bulan$uuid$hari"; 
                    ?>
                    <input type="hidden" class="form-control" name="id_kota_kab" id="id" value = "<?php echo $ktuuid ?>">
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
                    </div>
                    <div class="row mb-3 mt-2">
                        <div class="col">
                            <label class="form-label"><strong>Nama Kota / Kabupaten *</strong></label>
                            <input type="text" name="nama_kota_kab" class="form-control capitalize" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-kota">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_kota.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Kota/Kabupaten</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Kota :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-kota" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable
            new DataTable('#ecat');

        // Menangani perubahan pada pilihan provinsi
        $('#id_provinsi_select').selectize();

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
                kotaKabSelect.selectize();
            }).fail(function() {
                // Tangani kesalahan jika ada
                console.error('Gagal mendapatkan data kota/kabupaten.');
            });
        });

        // Inisialisasi DataTable pada halaman pertama load
        new DataTable('#ecat');

    });


        // Function DELETE
        $('#ecat').on('click', '.btn-delete', function() {
            var kotaId = $(this).data('id');
            var namaKota = $(this).closest('tr').find('td:nth-child(3)').text();
            var namaProvinsi = $(this).closest('tr').find('td:nth-child(2)').text();

            // Set ID, nama kota, dan nama provinsi untuk digunakan di tombol "Ya, Hapus"
            $('#modalDeleteBtn').data('id', kotaId);
            $('#modalDeleteBtn').data('kota', namaKota);
            $('#modalDeleteBtn').data('provinsi', namaProvinsi);

            // Set pesan konfirmasi dengan nama kota dan nama provinsi yang akan dihapus
            var modalText = "Apakah anda yakin hapus data '<b>" + namaKota + "</b>' dari provinsi '<b>" + namaProvinsi + "</b>'?";
            $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="kotaIdInput" name="id_kota_kab" value="' + kotaId + '" style="display:none;">');

            $('#modalDelete').on('hidden.bs.modal', function() {});

            $('#modalDelete').modal('show');
        });
    </script>
</body>
</html>