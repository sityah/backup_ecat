<?php include "akses.php" ?>
<?php 
    function generateUUID() {
        return sprintf('%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    $uuid1 = generateUUID(); 
    $hari1 = date('d');
    $bulan1 = date('m');
    $tahun1 = date('y');
    $spkuuid1 = "SPK$tahun1$bulan1$uuid1$hari1"; 
?>
<?php 
$uuid2 = generateUUID(); 
$hari2 = date('d');
$bulan2 = date('m');
$tahun2 = date('y');
$spkuuid2 = "SPKPL$tahun2$bulan2$uuid2$hari2"; 
?>

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
                        <!-- FORM SPK E-CATALOG -->
                        <div id="ecatalogForm" class="card shadow p-2">
                            <form action="proses/proses_spk_ecat.php" method="POST">
                            <div class="card-body" style="margin-top: -20px;">
                            <div class="card-header text-center">
                                <h5 style="margin-bottom: 30px;"><strong>FORM SPK E-CATALOG</strong></h5>
                                <hr style="margin-bottom: 0px;">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <input type="hidden" class="form-control" name="id_spk_ecat" id="id_spk_ecat" value="<?php echo $spkuuid1; ?>">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label for="jenisTransaksi"><strong>Jenis Transaksi</strong></label>
                                        <div class="form-check form-check-inline" style="margin-left: 20px;">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi" id="inlineRadioEcatalog" value="E-Catalog" required>
                                            <label class="form-check-label" for="inlineRadioEcatalog">E-Catalog</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi" id="inlineRadioLangsung" value="Langsung" required>
                                            <label class="form-check-label" for="inlineRadioLangsung">Penunjukkan Langsung</label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="no_spk" class="form-label">No. SPK *</label>
                                        <input type="text" class="form-control bg-light" id="no_spk" name="no_spk_ecat" readonly>
                                    </div>
                                    <div class="mt-3">
                                        <label for="tgl_spk" class="form-label">Tanggal SPK *</label>
                                        <input type="text" class="form-control bg-light" id="inputTglspk" name="tgl_spk_ecat" readonly>
                                    </div>
                                    <div class="mt-3">
                                        <label for="order_via" class="form-label">ID Paket *</label>
                                        <input type="text" class="form-control" id="no_paket" name="no_paket" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="sales" class="form-label">Nama Paket *</label>
                                        <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Nama Sales *</label>
                                        <input type="hidden" class="form-control" id="id_sales" name="id_sales">
                                        <input type="text" name="nama_sales" class="form-control bg-light" data-bs-toggle="modal" data-bs-target="#pilihSales" readonly required>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <div class="mb-2 row">
                                        <label for="" class="col-sm-3 col-form-label">Tanggal Pesanan *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="tgl_pesanan_ecat" name="tgl_pesanan_ecat" required>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Fee Marketing (%) *</label>
                                        <input type="text" class="form-control" id="fee_marketing" name="fee_marketing" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Satuan Kerja *</label>
                                        <input type="hidden" class="form-control" id="id_perusahaan_ecat" name="id_perusahaan">
                                        <input type="text" name="nama_perusahaan" class="form-control bg-light" data-bs-toggle="modal" data-bs-target="#pilihSatker" readonly required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Wilayah Kerja *</label>
                                        <input type="hidden" class="form-control" id="id_provinsi" name="id_provinsi">
                                        <input type="text" class="form-control bg-light" id="nama_provinsi" name="nama_provinsi"readonly required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Alamat Satuan Kerja *</label>
                                        <textarea class="form-control bg-light" name="alamat_perusahaan" id="alamat_perusahaan" readonly required></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="alamat" class="form-label">Notes</label>
                                        <textarea type="text" class="form-control" id="notes" name="notes" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                    <a href="data_spk.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                </div>
                            </div>
                            </div>
                            </form>
                        </div>

                        <!-- FORM SPK PENUNJUKKAN LANGSUNG -->
                        <div id="langsungForm" class="card shadow p-2" style="display: none;">
                            <form action="proses/proses_spk_pl.php" method="POST">
                            <div class="card-body" style="margin-top: -20px;">
                            <div class="card-header text-center">
                                <h5 style="margin-bottom: 30px;"><strong>FORM SPK PENUNJUKKAN LANGSUNG</strong></h5>
                                <hr style="margin-bottom: 0px;">
                            </div>
                                <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <input type="hidden" class="form-control" name="id_spk_pl" id="id_spk_pl" value="<?php echo $spkuuid2; ?>">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label for="jenisTransaksi"><strong>Jenis Transaksi</strong></label>
                                        <div class="form-check form-check-inline" style="margin-left: 20px;">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi" id="inlineRadioEcatalogForm" value="E-Catalog" required>
                                            <label class="form-check-label" for="inlineRadioEcatalogForm">E-Catalog</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi" id="inlineRadioLangsungForm" value="Langsung" required>
                                            <label class="form-check-label" for="inlineRadioLangsungForm">Penunjukkan Langsung</label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">No. SPK *</label>
                                        <input type="text" class="form-control bg-light" id="no_spk_pl" name="no_spk_pl" readonly required>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Tanggal SPK *</label>
                                        <input type="text" class="form-control bg-light" id="inputTglspkPL" name="tgl_spk_pl" readonly>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">NO. PO *</label>
                                        <input type="text" class="form-control" id="no_po" name="no_po" required>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Tanggal PO *</label>
                                        <input type="date" class="form-control" id="inputTglPO" name="tgl_po" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="Pelanggan" class="form-label">Satuan Kerja *</label>
                                        <input type="hidden" class="form-control" id="id_perusahaan_pl" name="id_perusahaan">
                                        <input type="text" name="nama_perusahaan" class="form-control bg-light" data-bs-toggle="modal" data-bs-target="#pilihPerusahaan" readonly required>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Tanggal Pesanan *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"  id="tgl_pesanan_pl" name="tgl_pesanan_pl" required>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Wilayah PO *</label>
                                        <input type="hidden" class="form-control" id="id_provinsi" name="id_provinsi">
                                        <input type="text" class="form-control bg-light" id="nama_provinsi" name="nama_provinsi" readonly required>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Alamat PO *</label>
                                        <textarea class="form-control bg-light" name="alamat_perusahaan" id="alamat_perusahaan" readonly required></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Nama Sales *</label>
                                        <select class="form-select normalize" name="id_sales" required>
                                            <option value="">Pilih Sales</option>
                                            <?php
                                            include "koneksi.php";
                                            $query_sales = "SELECT id_sales, nama_sales FROM tb_sales_ecat WHERE status_sales = 'Aktif'";
                                            $result_sales = mysqli_query($koneksi, $query_sales);

                                            while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                                                echo "<option value='" . $row_sales['id_sales'] . "'>" . $row_sales['nama_sales'] . "</option>";
                                            }
                                            mysqli_close($koneksi);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Fee Marketing (%) *</label>
                                        <input type="text" class="form-control" id="fee_marketing" name="fee_marketing" required>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Notes</label>
                                        <textarea type="text" class="form-control" id="notes" name="notes" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                    <a href="data_spk_pl.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        </div>
                        </section>
                    </main><!-- End #main -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        $('.normalize').selectize();
    </script> -->
    <!-- JAVASCRIPT U/ TGL_SPK -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mendapatkan elemen input tanggal SPK form pertama
            var inputTglspk = document.getElementById('inputTglspk');

            // Mendapatkan elemen input tanggal SPK form kedua
            var inputTglspkPL = document.getElementById('inputTglspkPL');

            // Mendapatkan tanggal sekarang
            var currentDate = new Date();

            // Mendapatkan tanggal dalam format (dd/mm/yyyy, 00:00)
            var formattedDate = ("0" + currentDate.getDate()).slice(-2) + "/" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "/" + currentDate.getFullYear() + ", " + ("0" + currentDate.getHours()).slice(-2) + ":" + ("0" + currentDate.getMinutes()).slice(-2);

            // Mengatur nilai input tanggal SPK form pertama dan form kedua menjadi tanggal sekarang
            inputTglspk.value = formattedDate;
            inputTglspkPL.value = formattedDate;
        });
    </script>
    <!-- JAVASCRIPT U/ NO_SPK_ECAT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var inputNoSPK = document.getElementById('no_spk');

        // Fetch nomor terakhir dari server
        fetch('get_latest_spk_number.php')
            .then(response => response.text())
            .then(lastSPKNumber => {
                // Mengubah nomor urut terakhir menjadi integer
                var latestSPKNumber = parseInt(lastSPKNumber) || 0;

                var currentDate = new Date();
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;

                // Menghasilkan nomor SPK yang unik dengan nomor urut terakhir + 1
                var newSPKNumber = latestSPKNumber + 1;

                // Format nomor SPK baru hanya dengan mengganti angka di bagian depan
                var formattedNoSPK = ("000" + newSPKNumber).slice(-3) + "/SPK/ECAT/" + getRomanNumeral(currentMonth) + "/" + currentYear;

                // Menetapkan nilai nomor SPK pada input form
                inputNoSPK.value = formattedNoSPK;
            })
            .catch(error => console.error('Error fetching latest SPK number:', error));
        });

        function getRomanNumeral(num) {
            var romanNumerals = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
            return romanNumerals[num];
        }
    </script>

    <!-- JAVASCRIPT U/ NO_SPK_PL -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Mendapatkan elemen input nomor SPK pada form E-Catalog
        var inputNoSPK_PL = document.getElementById('no_spk_pl');

        // Mengambil nomor terakhir dari server
        fetch('get_latest_spk_number_pl.php')
            .then(response => response.text())
            .then(lastSPKNumberPL => {
                // Mengubah nomor urut terakhir menjadi integer
                var latestSPKNumberPL = parseInt(lastSPKNumberPL) || 1;

                // Mendapatkan tanggal sekarang
                var currentDate = new Date();
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;

                // Menghasilkan nomor SPK PL yang unik dengan nomor urut terakhir + 1
                var newSPKNumberPL = latestSPKNumberPL + 1;

                // Format nomor SPK PL baru hanya dengan mengganti angka di bagian depan
                var formattedNoSPK_PL = ("000" + newSPKNumberPL).slice(-3) + "/SPK/ECAT/PL/" + getRomanNumeral(currentMonth) + "/" + currentYear;

                // Menetapkan nilai nomor SPK PL pada input form
                inputNoSPK_PL.value = formattedNoSPK_PL;
            })
            .catch(error => console.error('Error fetching latest SPK number for PL:', error));
        });

        function getRomanNumeral(num) {
            var romanNumerals = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
            return romanNumerals[num];
        }
    </script>

    <?php include "page/script.php"; ?>

    <!-- JAVASCRIPT U/ MENAMPILKAN FORM BERDASARKAN RADIO BUTTON -->
    <script>
        $(document).ready(function () {
            // Set tampilan awal sebagai Form SPK E-Catalog
            showEcatalogForm();

            // Handler untuk mengubah tampilan saat radio button diubah
            $('input[name="jenis_transaksi"]').change(function () {
                if ($(this).val() === "E-Catalog") {
                    showEcatalogForm();
                } else {
                    showLangsungForm();
                }
            });

            // Fungsi untuk menampilkan Form SPK E-Catalog
            function showEcatalogForm() {
                $('#ecatalogForm').show();
                $('#langsungForm').hide();
                // Aktifkan radio button E-Catalog
                $('#inlineRadioEcatalog').prop('checked', true);
                // Nonaktifkan radio button Penunjukkan Langsung
                $('#inlineRadioLangsungForm').prop('checked', false);
            }

            // Fungsi untuk menampilkan Form SPK Penunjukkan Langsung
            function showLangsungForm() {
                $('#ecatalogForm').hide();
                $('#langsungForm').show();
                // Aktifkan radio button Penunjukkan Langsung
                $('#inlineRadioLangsungForm').prop('checked', true);
                // Nonaktifkan radio button E-Catalog
                $('#inlineRadioEcatalog').prop('checked', false);
            }
        });
    </script>

    <!-- Modal pilih sales -->
    <div class="modal fade" id="pilihSales" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Sales</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table" id="sales">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col" style="width: 20%;">Nama Sales</th>
                            <th scope="col" style="width: 30%;">Email</th>
                            <th scope="col" style="width: 20%;">No. Telp</th>
                            <th scope="col" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            // Query untuk mengambil data dari tabel tb_sales_ecat
                            $query = "SELECT *
                            FROM tb_sales_ecat
                            WHERE status_sales = 'Aktif'";
                            $result = mysqli_query($koneksi, $query);

                            // Hasil query
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {

                                echo "<tr>";
                                echo "<th scope='row' style='width: 5%;'>" . $no++ . "</th>";
                                echo "<td style='width: 20%;'>" . $row['nama_sales'] . "</td>"; 
                                echo "<td style='width: 25%;'>" . $row['email_sales'] . "</td>";
                                echo "<td style='width: 20%;'>" . $row['no_telp_sales'] . "</td>";
                                echo "<td style='width: 5%;'><button type='button' class='btn btn-primary btn-sm mt-2 btn-pilih-sales' data-id='" . $row['id_sales'] . "'>Pilih</button></td>";
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
    <script>
        new DataTable('#sales');
    </script>
    <script>
        function hidePilihButtonSales(button) {
            var idSales = button.data('id');
            $('#sales tbody button[data-id]').each(function() {
                if ($(this).data('id') !== idSales) {
                    $(this).show();
                }
            });
            button.hide();
        }

        // Panggil fungsi hidePilihButtonSales saat dokumen siap
        $(document).ready(function() {
            $('#sales tbody button[data-id]').each(function() {
                var button = $(this);
                button.on('click', function() {
                    hidePilihButtonSales(button);
                });
            });
        });

        $('#sales').on('click', '.btn-pilih-sales', function(e) {
            var button = $(this);
            var idSales = button.data('id');
            var namaSales = button.closest('tr').find('td:eq(0)').text();

            // Menandai sales sebagai terpilih
            $('#id_sales').val(idSales);
            $("input[name='nama_sales']").val(namaSales);

            // Menonaktifkan tombol "Pilih" pada baris sales sebelumnya (jika ada)
            hidePilihButtonSales(button);

            // Menambahkan atribut data-bs-dismiss="modal" secara dinamis
            $('#pilihSales').attr('data-bs-dismiss', 'modal');
        });
    </script>
    <!-- Modal pilih satker -->
    <div class="modal fade" id="pilihSatker" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Satuan Kerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table" id="satker">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col" style="width: 20%;">Nama Perusahaan</th>
                            <th scope="col" style="width: 30%;">Provinsi</th>
                            <th scope="col" style="width: 20%;">Alamat</th>
                            <th scope="col" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            // Query untuk mengambil data dari tabel tb_sales_ecat
                            $query = "SELECT tb_perusahaan.id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.alamat_perusahaan, tb_provinsi.nama_provinsi 
                                    FROM tb_perusahaan
                                    LEFT JOIN tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi";
                            $result = mysqli_query($koneksi, $query);

                            // Hasil query
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {

                                echo "<tr>";
                                echo "<th scope='row' style='width: 5%;'>" . $no++ . "</th>";
                                echo "<td style='width: 20%;'>" . $row['nama_perusahaan'] . "</td>"; 
                                echo "<td style='width: 25%;'>" . $row['nama_provinsi'] . "</td>";
                                echo "<td style='width: 20%;'>" . $row['alamat_perusahaan'] . "</td>";
                                echo "<td style='width: 5%;'><button type='button' class='btn btn-primary btn-sm mt-2 btn-pilih-satker' data-id='" . $row['id_perusahaan'] . "'>Pilih</button></td>";
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
    <script>
        new DataTable('#satker');
    </script>
    <script>
        function hidePilihButtonSatker(button) {
            var idPerusahaan = button.data('id');
            $('#satker tbody button[data-id]').each(function() {
                if ($(this).data('id') !== idPerusahaan) {
                    $(this).show();
                }
            });
            button.hide();
        }

        // Panggil fungsi hidePilihButtonSales saat dokumen siap
        $(document).ready(function() {
            $('#satker tbody button[data-id]').each(function() {
                var button = $(this);
                button.on('click', function() {
                    hidePilihButtonSatker(button);
                });
            });
        });

        $('#satker').on('click', '.btn-pilih-satker', function(e) {
            var button = $(this);
            var idPerusahaan = button.data('id');
            var namaPerusahaan = button.closest('tr').find('td:eq(0)').text();
            var wilayahPerusahaan = button.closest('tr').find('td:eq(1)').text();
            var alamatPerusahaan = button.closest('tr').find('td:eq(2)').text();

            // Menandai perusahaan sebagai terpilih pada form e-catalog
            $('#id_perusahaan_ecat').val(idPerusahaan);
            $("input[name='nama_perusahaan']").val(namaPerusahaan);
            $('#ecatalogForm #nama_provinsi').val(wilayahPerusahaan);
            $('#ecatalogForm textarea[name="alamat_perusahaan"]').val(alamatPerusahaan);

            // Menonaktifkan tombol "Pilih" pada baris perusahaan sebelumnya (jika ada)
            hidePilihButtonSatker(button);

            // Menambahkan atribut data-bs-dismiss="modal" secara dinamis
            $('#pilihSatker').attr('data-bs-dismiss', 'modal');
        });
    </script>
</body>
</html>

<!-- Modal pilih perusahaan -->
<div class="modal fade" id="pilihPerusahaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Perusahaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
        <table class="table" id="perusahaan">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 20%;">Nama Perusahaan</th>
                    <th scope="col" style="width: 30%;">Wilayah</th>
                    <th scope="col" style="width: 20%;">Alamat</th>
                    <th scope="col" style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "koneksi.php";
                    // Query untuk mengambil data dari tabel tb_sales_ecat
                    $query = "SELECT tb_perusahaan.id_perusahaan, tb_perusahaan.nama_perusahaan, tb_perusahaan.alamat_perusahaan, tb_provinsi.nama_provinsi 
                    FROM tb_perusahaan
                    LEFT JOIN tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi";
                    $result = mysqli_query($koneksi, $query);

                    // Hasil query
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "<tr>";
                        echo "<th scope='row' style='width: 5%;'>" . $no++ . "</th>";
                        echo "<td style='width: 20%;'>" . $row['nama_perusahaan'] . "</td>"; 
                        echo "<td style='width: 25%;'>" . $row['nama_provinsi'] . "</td>";
                        echo "<td style='width: 20%;'>" . $row['alamat_perusahaan'] . "</td>";
                        echo "<td style='width: 5%;'><button type='button' class='btn btn-primary btn-sm mt-2 btn-pilih-perusahaan' data-pr='" . $row['id_perusahaan'] . "'>Pilih</button></td>";
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
<script>
    new DataTable('#perusahaan');
</script>
<script>
    function hidePilihButtonPerusahaan(button) {
        var idSatker = button.data('pr');
        $('#perusahaan tbody button[data-pr]').each(function () {
            if ($(this).data('pr') !== idSatker) {
                $(this).show();
            }
        });
        button.hide();
    }

    // Panggil fungsi hidePilihButtonPerusahaan saat dokumen siap
    $(document).ready(function () {
        $('#perusahaan tbody button[data-pr]').each(function () {
            var button = $(this);
            button.on('click', function () {
                hidePilihButtonPerusahaan(button);
            });
        });
    });

    $('#perusahaan').on('click', '.btn-pilih-perusahaan', function (e) {
        var button = $(this);
        var idSatker = button.data('pr');
        var namaPerusahaan = button.closest('tr').find('td:eq(0)').text();
        var wilayahKerja = button.closest('tr').find('td:eq(1)').text();
        var alamatPerusahaan = button.closest('tr').find('td:eq(2)').text();

        // Menandai perusahaan sebagai terpilih pada form penunjukkan langsung
        $('#id_perusahaan_pl').val(idSatker);
        $("input[name='nama_perusahaan']").val(namaPerusahaan);
        $('#langsungForm #nama_provinsi').val(wilayahKerja);
        $('#langsungForm textarea[name="alamat_perusahaan"]').val(alamatPerusahaan);

        // Menonaktifkan tombol "Pilih" pada baris perusahaan sebelumnya (jika ada)
        hidePilihButtonPerusahaan(button);

        // Menambahkan atribut data-bs-dismiss="modal" secara dinamis
        $('#pilihPerusahaan').attr('data-bs-dismiss', 'modal');
    });
</script>