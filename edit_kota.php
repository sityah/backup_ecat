<?php include "akses.php"; ?>

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
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                        <main id="main" class="main">
                            <section>
                                <?php
                                include "koneksi.php";
                                $id = $_GET['id'];
                                $query = "SELECT tb_kota.*, tb_provinsi.nama_provinsi FROM tb_kota
                                    LEFT JOIN tb_provinsi ON tb_kota.id_provinsi = tb_provinsi.id_provinsi
                                    WHERE id_kota_kab = '$id'";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_array($result);
                                $provinsi_id = $data['id_provinsi'];
                                ?>

                                <!-- Trigger modal automatically using JavaScript -->
                                <script>
                                    $(document).ready(function() {
                                        $('#editKotaModal').modal('show');
                                    });
                                </script>

                                <!-- Modal -->
                                <div class="modal fade" id="editKotaModal" tabindex="-1" aria-labelledby="editKotaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editKotaModalLabel">Form Edit Kota / Kabupaten</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="proses/proses_kota.php" method="POST">
                                                    <input type="hidden" name="id_kota_kab" value="<?php echo $data['id_kota_kab']; ?>">
                                                    <div class="form-group">
                                                        <label for="namaKota" class="form-label">Nama Kota</label>
                                                        <input type="text" class="form-control capitalize" id="namaKota" name="nama_kota_kab" pattern="[A-Za-z]+" value="<?php echo $data['nama_kota_kab']; ?>">
                                                    </div>
                                                    <div id="selectData" class="mt-3">
                                                        <!-- Provinsi -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Wilayah / Provinsi</label>
                                                            <select class="form-select" id="selectProvinsi" name="selectProvinsi">
                                                                <option value="<?php echo $data['id_provinsi']; ?>"><?php echo $data['nama_provinsi']; ?></option>
                                                                <?php
                                                                include "koneksi.php";
                                                                $provinsi_query = "SELECT * FROM tb_provinsi";
                                                                $result_provinsi = $koneksi->query($provinsi_query);
                                                                while ($data_provinsi = mysqli_fetch_array($result_provinsi)) {
                                                                ?>
                                                                    <option value="<?php echo $data_provinsi['id_provinsi']; ?>" <?php echo ($data_provinsi['id_provinsi'] == $provinsi_id) ? 'selected' : ''; ?>>
                                                                        <?php echo $data_provinsi['nama_provinsi']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id']; ?>">

                                                    <div class="text-center mt-3">
                                                        <button type="submit" name="edit-kota" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan </button>
                                                        <button type="button" class="btn btn-secondary m-2" id="closeModalBtn2" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </main><!-- End #main -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rbs5eIv6iRN6d4MSowPEwMZZI/ZbNQ1ciusxWqI2gRqXYs2gB4hjQ8I/KJf1Dt4" crossorigin="anonymous"></script>

    <?php include "page/script.php"; ?>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
    // Inisialisasi Selectize pada elemen input
    var selectizeProvinsi = $('#selectProvinsi').selectize();

    // Menghubungkan Selectize dengan elemen <select> yang sesungguhnya
    var selectProvinsi = selectizeProvinsi[0].selectize;

    // Set nilai awal untuk selectProvinsi
    selectProvinsi.setValue('<?php echo $provinsi_id; ?>');

    // Manual trigger perubahan untuk memicu pemilihan kota
    selectProvinsi.on('change', function(){
        var selectedProvinsi = selectProvinsi.getValue();
        
    });

    // Pilih Provinsi secara otomatis untuk memicu perubahan
    selectProvinsi.trigger('change');

    // Tambahkan event handler untuk tombol "Close"
    $('#closeModalBtn').on('click', function() {
            // Arahkan pengguna ke halaman data_kota.php
            window.location.href = 'data_kota.php';
        });

    // Tambahkan event handler untuk tombol "Close"
    $('#closeModalBtn2').on('click', function() {
            // Arahkan pengguna ke halaman data_kota.php
            window.location.href = 'data_kota.php';
        });

    // Tambahkan event listener untuk mendeteksi klik pada luar modal
    $('#editKotaModal').on('click', function (e) {
            if (e.target === this) {
                // Arahkan pengguna ke halaman data_kota.php jika area luar modal diklik
                window.location.href = 'data_kota.php';
            }
        });
    });
</script>
