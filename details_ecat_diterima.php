<?php include "akses.php" ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 p-2">
                            <h5 class="card-header text-center"><b>DETAIL INVOICE E-CATALOG</b></h5>
                            <div class="card-body border m-2">
                            <div class="mt-4 text-end me-3">
                                <button type="button" class="btn btn-secondary mb-3">E-Catalog</button>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_inv_ecat'])) {
                                        $id_inv_ecat = $_GET['id_inv_ecat'];

                                        $sql = "SELECT
                                                    tb_spk_ecat.tgl_pesanan_ecat,
                                                    COALESCE(GROUP_CONCAT(tb_spk_ecat.no_spk_ecat SEPARATOR ', '), 'N/A') AS no_spk_ecat,
                                                    tb_spk_ecat.no_paket,
                                                    tb_spk_ecat.nama_paket,
                                                    tb_spk_ecat.fee_marketing,
                                                    tb_sales_ecat.nama_sales,
                                                    tb_perusahaan.nama_perusahaan,
                                                    tb_perusahaan.alamat_perusahaan,
                                                    tb_provinsi.nama_provinsi,
                                                    inv_ecat.no_inv_ecat,
                                                    inv_ecat.tgl_inv_ecat,
                                                    inv_ecat.notes,
                                                    status_kirim.jenis_pengiriman,
                                                    status_kirim.tgl_kirim,
                                                    tb_driver.nama_driver,
                                                    ekspedisi.nama_ekspedisi,
                                                    status_kirim.dikirim_oleh,
                                                    status_kirim.penanggung_jawab
                                                FROM
                                                    inv_ecat
                                                LEFT JOIN
                                                    tb_spk_ecat ON inv_ecat.id_inv_ecat = tb_spk_ecat.id_inv_ecat -- Menggunakan id_inv_ecat dari inv_ecat
                                                LEFT JOIN
                                                    tb_sales_ecat ON tb_spk_ecat.id_sales = tb_sales_ecat.id_sales
                                                LEFT JOIN
                                                    tb_perusahaan ON tb_spk_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                                                LEFT JOIN
                                                    tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                                LEFT JOIN
                                                    status_kirim ON inv_ecat.id_inv_ecat = status_kirim.id_inv_ecat
                                                LEFT JOIN
                                                    tb_driver ON status_kirim.id_driver = tb_driver.id_driver
                                                LEFT JOIN
                                                    ekspedisi ON status_kirim.id_ekspedisi = ekspedisi.id_ekspedisi
                                                WHERE
                                                    inv_ecat.id_inv_ecat = '$id_inv_ecat' AND
                                                    tb_spk_ecat.status_spk_ecat = 'Dikirim'
                                                GROUP BY
                                                    inv_ecat.id_inv_ecat";

                                        $result = mysqli_query($koneksi, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            echo '<div class="card-body border m-1 flex-wrap-table" style="flex: 1; width: 48%;">';
                                            echo '<table>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Tgl. Pesanan</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["tgl_pesanan_ecat"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">No. SPK</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["no_spk_ecat"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">No. Invoice</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["no_inv_ecat"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Tgl. Invoice</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["tgl_inv_ecat"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Nama Paket</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["nama_paket"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Sales</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["nama_sales"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Fee Marketing</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["fee_marketing"] . '</td>';
                                            echo '</tr>';
                                            echo '</table>';
                                            echo '</div>';
                                            echo '<div class="card-body border m-1 flex-wrap-table" style="flex: 1; width: 48%;">';
                                            echo '<table>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Satuan Kerja</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["nama_perusahaan"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Wilayah Kerja</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["nama_provinsi"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Note Invoice</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["notes"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Jenis Pengiriman</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["jenis_pengiriman"] . '</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<td class="mb-3" style="width: 180px">Tgl Pengiriman</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["tgl_kirim"] . '</td>';
                                            echo '</tr>';
                                            // Menampilkan Nama Driver jika jenis_pengiriman adalah "Driver"
                                            if ($row["jenis_pengiriman"] === "Driver") {
                                                echo '<tr>';
                                                echo '<td class="mb-3" style="width: 180px">Nama Driver</td>';
                                                echo '<td class="p-2 py-0">:</td>';
                                                echo '<td>' . $row["nama_driver"] . '</td>';
                                            }
                                            echo '</tr>';
                                            // Menampilkan Nama Ekspedisi, Dikirim Oleh, dan Penanggung Jawab jika jenis_pengiriman adalah "Ekspedisi"
                                            if ($row["jenis_pengiriman"] === "Ekspedisi") {
                                                echo '<tr>';
                                                echo '<td class="mb-3" style="width: 180px">Nama Ekspedisi</td>';
                                                echo '<td class="p-2 py-0">:</td>';
                                                echo '<td>' . $row["nama_ekspedisi"] . '</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="mb-3" style="width: 180px">Dikirim Oleh</td>';
                                                echo '<td class="p-2 py-0">:</td>';
                                                echo '<td>' . $row["dikirim_oleh"] . '</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="mb-3" style="width: 180px">Penanggung Jawab</td>';
                                                echo '<td class="p-2 py-0">:</td>';
                                                echo '<td>' . $row["penanggung_jawab"] . '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</table>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo "Tidak ada data yang ditemukan";
                                    }

                                    mysqli_close($koneksi);
                                ?>
                            
                                <form id="insertForm" method="post" action="proses/proses_kirim.php">
                                    <input type="hidden" id="no_inv_ecat" name="no_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                                    <div class="card-body border mt-2 mb-4">
                                        <div class="row mb-4">
                                            <div class="table-responsive">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="">
                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = 'spk_diterima.php';">
                                                            <i class="tf-icons bx bxs-chevrons-left"></i> Kembali
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary" id="btnTampilBuktiTerima" data-inv="<?php echo $id_inv_ecat; ?>" data-bs-toggle="modal" data-bs-target="#modalBuktiTerima">
                                                            <i class="tf-icons bx bxs-file-image"></i> Bukti Terima
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary" id="btnUbahStatus" data-inv="<?php echo $id_inv_ecat; ?>" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">Ubah Status</button>
                                                    </div>
                                                </div>
                                                <table class="table table-striped" id="selectedProductsTable" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>No. SPK</th>
                                                            <th>Nama Produk</th>
                                                            <th>Satuan</th>
                                                            <th>Merk</th>
                                                            <th>Harga</th>
                                                            <th>Quantity</th>
                                                            <th>Total Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            include "koneksi.php";
                                                            $query = "SELECT 
                                                                        sr.id_spk_ecat,
                                                                        sr.status_spk_ecat,
                                                                        tps.id_transaksi_ecat,
                                                                        sr.no_spk_ecat,
                                                                        tps.nama_produk_spk,
                                                                        tps.harga,
                                                                        tps.total_harga,
                                                                        tps.id_produk,
                                                                        spr.stock, 
                                                                        tpr.nama_produk, 
                                                                        tpr.satuan,
                                                                        tps.qty,
                                                                        tps.status_trx,
                                                                        tpr.harga_produk,
                                                                        tm.nama_merk
                                                                    FROM 
                                                                        mandir36_db_ecat_staging.transaksi_produk_ecat AS tps
                                                                    LEFT JOIN 
                                                                        mandir36_db_ecat_staging.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk
                                                                    LEFT JOIN 
                                                                        mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                                                    LEFT JOIN 
                                                                        mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                                                    LEFT JOIN 
                                                                        mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                                                    WHERE 
                                                                        tps.status_trx = 1 AND sr.id_inv_ecat = (SELECT id_inv_ecat FROM inv_ecat WHERE id_inv_ecat = '$id_inv_ecat')";
                                                            $result = mysqli_query($koneksi, $query);

                                                            // Hasil query
                                                            $no = 1;
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo "<tr>";
                                                                echo "<th scope='row'>" . $no++ . "</th>";
                                                                echo "<td>" . $row['no_spk_ecat'] . "</td>";
                                                                echo "<td>" . $row['nama_produk_spk'] . "</td>"; 
                                                                echo "<td>" . $row['satuan'] . "</td>";  
                                                                echo "<td>" . $row['nama_merk'] . "</td>"; 
                                                                echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>"; 
                                                                echo "<td>" . $row['qty'] . "</td>"; 
                                                                echo "<td>" . number_format($row['total_harga'], 0, ',', '.') . "</td>"; 
                                                                echo "</tr>";
                                                            }
                                                            mysqli_close($koneksi);
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectedProductsTable').DataTable({
                scrollX: true
            });
        });
    </script>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="insertForm" method="post" action="proses/proses_transaksi_selesai.php">
                    <input type="hidden" name="id_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Perubahan Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menyelesaikan pesanan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Transaksi Selesai</button>
                        <button type="button" class="btn btn-primary" onclick="tampilkanKomplainModal()">Komplain</button>
                    </div>
                    </div>
                </form>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan modal konfirmasi
        function tampilkanModal() {
            $('#konfirmasiModal').modal('show');
        }

        // Fungsi untuk mengirimkan formulir setelah konfirmasi
        function kirimForm() {
            document.getElementById('insertForm').submit();
            $('#konfirmasiModal').modal('hide');
        }
    </script>

    <!-- Modal Bukti Terima -->
    <div class="modal fade" id="modalBuktiTerima" tabindex="-1" aria-labelledby="modalBuktiTerimaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuktiTerimaLabel">Bukti Terima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="border p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <img id="buktiTerimaImg" src="" alt="Bukti Terima" style="max-width: 100%;">
                            </div>
                            <div class="col-md-6 d-flex flex-column justify-content-center align-items-start">
                                <div class="text-center">
                                    <p><strong>Penerima:</strong> <span id="penerimaInfo"></span></p>
                                </div>
                                <div class="text-center">
                                    <p><strong>Tgl Diterima:</strong> <span id="tglDiterimaInfo"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function untuk menampilkan modal bukti terima
        $('#modalBuktiTerima').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var idInvEcat = button.data('inv'); 
            var imgSrc = ''; 

            imgSrc = 'uploads/' + idInvEcat + '.png'; 
            $('#buktiTerimaImg').attr('src', imgSrc); 
        });

        // Function untuk memperbesar (zoom) gambar ketika diklik
        $(document).on('click', '#buktiTerimaImg', function() {
            $('#modalBuktiTerima').modal('hide'); // Menutup modal bukti terima
            $('#modalZoom').modal('show'); // Menampilkan modal zoom
            $('#zoomedImage').attr('src', $(this).attr('src'));
        });

        // Function untuk menampilkan kembali modal bukti terima ketika modal zoom ditutup
        $('#modalZoom').on('hide.bs.modal', function() {
            $('#modalBuktiTerima').modal('show'); 
        });
    </script>

    <!-- Modal Zoom untuk memperbesar gambar -->
    <div class="modal fade" id="modalZoom" tabindex="-1" aria-labelledby="modalZoomLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img id="zoomedImage" src="" alt="Zoomed Image" style="max-width: 1000px; height: 450px; margin-bottom: 30px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Komplain -->
    <div class="modal fade" id="komplainModal" tabindex="-1" aria-labelledby="komplainModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="komplainForm" method="post" action="proses/proses_komplain.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="komplainModalLabel">Ajukan Komplain</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggalKomplain" class="form-label"><strong>Tanggal Komplain</strong></label>
                            <input type="date" class="form-control" id="tanggalKomplain" name="tgl_komplain">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Komplain</label>
                            <input type="text" class="form-control bg-light" id="no_komplain" name="no_komplain" readonly>
                        </div>
                        <p style="margin-bottom: 5px;"><strong>Pilih alasan komplain Anda :</strong></p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="komplain" id="komplainBarangRusak" value="Barang Rusak">
                            <label class="form-check-label" for="komplainBarangRusak">Barang Rusak</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="komplain" id="komplainTidakSesuaiPesanan" value="Barang Tidak Sesuai Pesanan">
                            <label class="form-check-label" for="komplainTidakSesuaiPesanan">Barang Tidak Sesuai Pesanan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="komplain" id="komplainPengirimanTerlambat" value="Pengiriman Terlambat">
                            <label class="form-check-label" for="komplainPengirimanTerlambat">Pengiriman Terlambat</label>
                        </div>
                        <p style="margin-top: 20px; margin-bottom: 5px;"><strong>Retur Barang</strong></p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="retur_barang" id="returBarangYa" value="Ya">
                            <label class="form-check-label" for="returBarangYa">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="retur_barang" id="returBarangTidak" value="Tidak">
                            <label class="form-check-label" for="returBarangTidak">Tidak</label>
                        </div>
                        <div class="mb-3" id="refundDanaContainer" style="display: none; margin-top: 15px;">
                            <label for="refundDana" class="form-label"><strong>Refund Dana</strong></label>
                            <div id="refundDanaOptions" style="display: none;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="refund_dana" id="refundDanaYa" value="Ya">
                                    <label class="form-check-label" for="refundDanaYa">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="refund_dana" id="refundDanaTidak" value="Tidak">
                                    <label class="form-check-label" for="refundDanaTidak">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="keterangan" class="form-label"><strong>Keterangan</strong></label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>

                        <!-- hidden input untuk id transaksi jika diperlukan -->
                        <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Komplain</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Menampilkan opsi Refund Dana saat radio button "Ya" dipilih untuk Retur Barang
        $('input[name="retur_barang"]').change(function() {
            if ($(this).val() === 'Ya') {
                $('#refundDanaContainer').show();
                $('#refundDanaOptions').show();
            } else {
                $('#refundDanaContainer').hide();
                $('#refundDanaOptions').hide();
            }
        });
    </script>

    <script>
        // Fungsi untuk menampilkan modal komplain
        function tampilkanKomplainModal() {
            $('#komplainModal').modal('show');
            $('#konfirmasiModal').modal('hide'); // Menutup modal konfirmasi
        }

        // Fungsi untuk menampilkan modal konfirmasi
        function tampilkanModal() {
            $('#konfirmasiModal').modal('show');
            $('#komplainModal').modal('hide'); 
        }

        // Event listener untuk menampilkan modal konfirmasi saat modal komplain ditutup
        $('#komplainModal').on('hidden.bs.modal', function () {
            tampilkanModal(); 
        });
    </script>
    <!-- JAVASCRIPT U/ NO_KOMPLAIN -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var inputNoSPK = document.getElementById('no_komplain');

        // Fetch nomor terakhir dari server
        fetch('get_latest_no_komplain.php')
            .then(response => response.text())
            .then(lastInvEcat => {
                // Mengubah nomor urut terakhir menjadi integer
                var latestINVNumber = parseInt(lastInvEcat) || 0;

                var currentDate = new Date();
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;

                // Menghasilkan nomor SPK yang unik dengan nomor urut terakhir + 1
                var newSPKNumber = latestINVNumber + 1;

                // Format nomor SPK baru hanya dengan mengganti angka di bagian depan
                var formattedNoSPK = ("000" + newSPKNumber).slice(-3) + "/CC/ECAT/" + getRomanNumeral(currentMonth) + "/" + currentYear;

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
