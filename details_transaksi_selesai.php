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
    <link rel="stylesheet" href="lightGallery-1.10.0/dist/css/lightgallery.min.css" />
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
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
                                                    mandir36_db_ecat_staging.inv_ecat
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.tb_spk_ecat ON inv_ecat.id_inv_ecat = tb_spk_ecat.id_inv_ecat -- Menggunakan id_inv_ecat dari inv_ecat
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.tb_sales_ecat ON tb_spk_ecat.id_sales = tb_sales_ecat.id_sales
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.tb_perusahaan ON tb_spk_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.status_kirim ON inv_ecat.id_inv_ecat = status_kirim.id_inv_ecat
                                                LEFT JOIN
                                                    mandir36_db_ecat_staging.tb_driver ON status_kirim.id_driver = tb_driver.id_driver
                                                LEFT JOIN
                                                    mandir36_staging.ekspedisi ON status_kirim.id_ekspedisi = ekspedisi.id_ekspedisi
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
                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = 'spk_selesai.php';">
                                                            <i class="tf-icons bx bxs-chevrons-left"></i> Kembali
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary" id="btnTampilBuktiTerima" data-inv="<?php echo $id_inv_ecat; ?>" data-bs-toggle="modal" data-bs-target="#modalBuktiTerima">
                                                            <i class="tf-icons bx bxs-file-image"></i> Bukti Terima
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary" onclick="printInvoice('invoice')">Invoice</button>
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
    <script>
        function printInvoice(type) {
            var id_inv_ecat = <?php echo json_encode($id_inv_ecat); ?>;

            if (type === 'invoice') {
                window.location.href = "cetak_invoice_ecat.php?id_inv_ecat=" + id_inv_ecat;
            } else if (type === 'pdf') {
                window.location.href = "cetak_pdf_ecat.php?id_inv_ecat=" + id_inv_ecat;
            } else if (type === 'kwitansi') {
                window.location.href = "cetak_kwitansi_ecat.php?id_inv_ecat=" + id_inv_ecat;
            } else if (type === 'surat jalan') {
                window.location.href = "cetak_surat_jalan_ecat.php?id_inv_ecat=" + id_inv_ecat;
            }
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
                                <img id="buktiTerimaImg" data-src="<?php echo $imgSrc; ?>" alt="Bukti Terima" style="max-width: 100%;" />
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

    <script src="lightGallery-1.10.0/dist/js/lightgallery-all.min.js"></script>
    <script>
        // Function untuk menampilkan modal bukti terima
        $('#modalBuktiTerima').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var idInvEcat = button.data('inv'); 
            var imgSrc = 'uploads/' + idInvEcat + '.png'; 
            $('#buktiTerimaImg').attr('src', imgSrc).attr('data-src', imgSrc); 
        });

        // Inisialisasi lightGallery pada gambar dengan ID 'buktiTerimaImg' ketika diklik
        $(document).on('click', '#buktiTerimaImg', function() {
            $('#modalBuktiTerima').modal('hide');

            // Inisialisasi lightGallery
            $(this).lightGallery({
                dynamic: true,
                dynamicEl: [{
                    src: $(this).data('src') 
                }]
            });
        });
        // Menampilkan kembali modal bukti terima setelah menutup lightGallery
        $(document).on('onCloseAfter.lg', function(event){
            $('#modalBuktiTerima').modal('show');
            var button = $(event.relatedTarget); 
            var idInvEcat = '<?php echo $id_inv_ecat ?>'; 
            var imgSrc = 'uploads/' + idInvEcat + '.png'; 
            $('#buktiTerimaImg').attr('src', imgSrc).attr('data-src', imgSrc); 
        });
    </script>
    
</body>
</html>
