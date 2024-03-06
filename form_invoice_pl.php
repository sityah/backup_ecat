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
    $invuuid1 = "INV$tahun1$bulan1$uuid1$hari1"; 
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
                        <div class="card shadow p-2">
                            <div class="card-header text-center">
                                <h5 style="margin-bottom: 30px;"><strong>FORM INVOICE PENUNJUKKAN LANGSUNG</strong></h5>
                                <hr style="margin-bottom: 0px;">
                            </div>
                            <form action="proses/proses_inv_pl.php" method="POST">
                                <div class="card-body" style="margin-top: -20px;">
                                    <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_spk_pl'])) {
                                        $id_spk_pl = $_GET['id_spk_pl'];

                                        // Query untuk mendapatkan data yang sesuai dari database
                                        $sql = "SELECT
                                                tb_spk_pl.tgl_pesanan_pl,
                                                tb_spk_pl.no_spk_pl,
                                                tb_spk_pl.tgl_spk_pl,
                                                tb_spk_pl.no_po,
                                                tb_spk_pl.fee_marketing,
                                                tb_sales_ecat.id_sales,
                                                tb_sales_ecat.nama_sales,
                                                tb_perusahaan.nama_perusahaan,
                                                tb_perusahaan.alamat_perusahaan,
                                                tb_provinsi.nama_provinsi
                                            FROM
                                                tb_spk_pl
                                            JOIN
                                                tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                                            JOIN
                                                tb_perusahaan ON tb_spk_pl.id_perusahaan = tb_perusahaan.id_perusahaan
                                            JOIN
                                                tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                            WHERE
                                                tb_spk_pl.id_spk_pl = '$id_spk_pl'";

                                        // Jalankan query
                                        $result = mysqli_query($koneksi, $sql);

                                        // Periksa jika ada hasil yang ditemukan
                                        if ($result) {
                                            // Ambil baris pertama hasil query
                                            $row = mysqli_fetch_assoc($result);

                                            // Set nilai-nilai dari hasil query ke dalam variabel
                                            $no_po = $row['no_po'];
                                            $nama_perusahaan = $row['nama_perusahaan'];
                                            $alamat_perusahaan = $row['alamat_perusahaan'];
                                            $nama_provinsi = $row['nama_provinsi'];
                                            $id_sales = $row['id_sales'];
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="card-body">
                                            <input type="hidden" class="form-control" name="id_inv_pl" id="id_inv_pl" value="<?php echo $invuuid1; ?>">
                                            <div class="mt-3">
                                                <label class="form-label">Jenis Invoice *</label>
                                                <select class="form-control" id="jenis_invoice" name="jenis_invoice">
                                                    <option value="PPN">PPN</option>
                                                    <option value="NON PPN">NON PPN</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">No. Invoice *</label>
                                                <input type="text" class="form-control bg-light" id="no_inv" name="no_inv_pl" readonly>
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="form-label">Tanggal Invoice *</label>
                                                <input type="date" class="form-control" id="tgl_inv_pl" name="tgl_inv_pl" required>
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="form-label">Tanggal Tempo *</label>
                                                <input type="date" class="form-control" id="tgl_tempo" name="tgl_tempo" required>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Special Diskon *</label>
                                                <input type="text" class="form-control" id="sp_disc" name="sp_disc">
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">No. PO</label>
                                                <input type="hidden" class="form-control" id="id_spk_pl" name="id_spk_pl" value="<?php echo $id_spk_pl; ?>">
                                                <input type="text" class="form-control bg-light" id="no_po" name="no_po" value="<?php echo $no_po; ?>" readonly>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card-body">
                                            <div class="mt-3">
                                                <label class="form-label">Nama Institusi / Perusahaan</label>
                                                <input type="hidden" class="form-control" id="id_perusahaan" name="id_perusahaan">
                                                <input type="text" class="form-control bg-light" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo $nama_perusahaan; ?>" readonly>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Alamat Institusi / Perusahaan</label>
                                                <input type="hidden" class="form-control" id="id_perusahaan" name="id_perusahaan">
                                                <input type="text" class="form-control bg-light" id="alamat_perusahaan" name="alamat_perusahaan" value="<?php echo $alamat_perusahaan; ?>" readonly>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Wilayah Institusi / Perusahaan</label>
                                                <input type="hidden" class="form-control" id="id_perusahaan" name="id_perusahaan">
                                                <input type="text" class="form-control bg-light" id="nama_provinsi" name="nama_provinsi" value="<?php echo $nama_provinsi; ?>" readonly>
                                            </div>
                                            <div class="mt-3">
                                            <small class="text-light fw-bold">Tambahan Invoice</small>
                                                <div class="form-check mt-0">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
                                                    <label class="form-check-label" for="defaultCheck1"> Surat Jalan </label>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label for="alamat" class="form-label">Note Invoice</label>
                                                <textarea type="text" class="form-control bg-white" id="notes" name="notes" rows="3"></textarea>
                                            </div>
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" name="simpan" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                        <a href="spk_pl_siap_kirim.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </section>
                    </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

     <!-- JAVASCRIPT U/ NO_SPK_ECAT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var inputNoSPK = document.getElementById('no_inv');

        // Fetch nomor terakhir dari server
        fetch('get_latest_no_inv_pl.php')
            .then(response => response.text())
            .then(lastInvPl => {
                // Mengubah nomor urut terakhir menjadi integer
                var latestINVNumber = parseInt(lastInvPl) || 0;

                var currentDate = new Date();
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;

                // Menghasilkan nomor SPK yang unik dengan nomor urut terakhir + 1
                var newSPKNumber = latestINVNumber + 1;

                // Format nomor SPK baru hanya dengan mengganti angka di bagian depan
                var formattedNoSPK = ("000" + newSPKNumber).slice(-3) + "/INV/ECAT/PL/" + getRomanNumeral(currentMonth) + "/" + currentYear;

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
</body>
</html>