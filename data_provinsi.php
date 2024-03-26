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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Provinsi</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter" style="display: none;">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 80%;">Nama Provinsi</th>
                                                <th scope="col" style="width: 15%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_provinsi
                                                $query = "SELECT * FROM tb_provinsi
                                                ORDER BY FIELD(nama_provinsi, 'Aceh', 'Sumatera Utara', 'Sumatera Selatan', 'Sumatera Barat', 'Bengkulu', 'Riau', 'Kepulauan Riau', 'Jambi', 'Lampung', 'Kepulauan Bangka Belitung', 'Kalimantan Barat', 'Kalimantan Timur', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Utara', 'Banten', 'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Bali', 'Nusa Tenggara Timur', 'Nusa Tenggara Barat', 'Gorontalo', 'Sulawesi Barat', 'Sulawesi Tengah', 'Sulawesi Utara', 'Sulawesi Tenggara', 'Sulawesi Selatan', 'Maluku Utara', 'Maluku', 'Papua Barat', 'Papua', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya');
                                                ";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);
                                                


                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_provinsi'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                data-id='" . $row['id_provinsi'] . "'    
                                                                data-provinsi='" . $row['nama_provinsi'] . "'
                                                                data-updatedby='" . $row['updated_by'] . "'
                                                                data-updated='" . $row['updated_date'] . "'>
                                                                <i class='bx bx-edit-alt'></i>
                                                            </button>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_provinsi'] . "'>
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
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Provinsi</h5>
            </div>
            <div class="modal-body">
                <!-- Formulir untuk menambah data provinsi -->
                <form action="proses/proses_provinsi.php" method="POST">
                    <?php 
                        function generateUUID() {
                            return sprintf('%04x%04x',
                                mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                            );
                        }
                        $uuid = generateUUID(); 
                        $hari = date('d');
                        $tahun = date('y');
                        $prvuuid = "PRV$tahun$uuid$hari"; 
                    ?>
                    <input type="hidden" class="form-control" name="id_provinsi" id="id" value = "<?php echo $prvuuid ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama Provinsi *</label>
                            <input type="text" name="nama_provinsi" class="form-control capitalize" pattern="[A-Za-z]+" placeholder="Tulis Nama Provinsi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-provinsi">Save changes</button>
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

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_provinsi.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Provinsi</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Provinsi :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-provinsi" id="modalDeleteBtn">Ya, Hapus</button>
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

            $('#addProvinsiForm').on('submit', function(event) {
        event.preventDefault();

        // Mengambil data formulir
        var formData = $("#addProvinsiForm").serialize();

        $('#modalCenter').modal('hide');
        });

        // Plugins Search Select
        $('.normalize').selectize();


        // Function DELETE
            $(document).on('click', '.btn-delete', function() {
            var provinsiId = $(this).data('id');
            var namaProvinsi = $(this).closest('tr').find('td:nth-child(2)').text();

            // Set ID dan nama provinsi untuk digunakan di tombol "Ya, Hapus"
            $('#modalDeleteBtn').data('id', provinsiId);
            $('#modalDeleteBtn').data('provinsi', namaProvinsi);

            // Set pesan konfirmasi dengan nama instansi yang akan dihapus
            var modalText = "Apakah anda yakin hapus data Provinsi '<b>" + namaProvinsi + "</b>'?";
            $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="provinsiIdInput" name="id_provinsi" value="' + provinsiId + '" style="display:none;">');

            $('#modalDelete').on('hidden.bs.modal', function() {
            });

            $('#modalDelete').modal('show');
            });


            $('#modalDeleteBtn').on('click', function () {
                var provinsiId = $(this).data('id');
                var namaProvinsi = $(this).data('provinsi');

                $('#modalDelete').modal('hide');

                // Lakukan operasi hapus di sini menggunakan customerId 
                // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
                console.log("Menghapus data dengan ID:", provinsiId);
                console.log("Instansi yang dihapus:", namaProvinsi);
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
                    <h5 class="modal-title" id="modalEditTitle">Edit Data Provinsi</h5>
                </div>
                <form action="proses/proses_provinsi.php" method="POST">
                    <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_provinsi" name="id_provinsi" class="form-control" value="<?php echo $data_lama['id_provinsi']; ?>" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Provinsi</label>
                                <input type="text" id="namaProvinsi" name="nama_provinsi" class="form-control capitalize" pattern="[A-Za-z]+" required>
                            </div>
                        </div>
                        <input type="text" name="update" class="form-control" value="<?php echo date('d/m/y h:i:s') ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-provinsi">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Handler Tombol Edit
    $('.btn-edit').on('click', function () {
        // Mendapatkan data dari tombol yang ditekan
        var id = $(this).data('id');
        var provinsi = $(this).data('provinsi');
        var updatedby = $(this).data('updatedby');
        var updated = $(this).data('updated');

        // Set values for the edit form
        $('#id_provinsi').val(id);
        $('#namaProvinsi').val(provinsi);

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });
    $('.normalize').selectize();
        </script>


