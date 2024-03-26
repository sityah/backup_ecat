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
                                            echo '<td class="mb-3" style="width: 180px">ID Paket</td>';
                                            echo '<td class="p-2 py-0">:</td>';
                                            echo '<td>' . $row["no_paket"] . '</td>';
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
                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = 'spk_dikirim.php';">
                                                            <i class="tf-icons bx bxs-chevrons-left"></i> Kembali
                                                        </button>
                                                        <?php
                                                            include "koneksi.php";

                                                            // Memastikan koneksi mysqli tetap terbuka atau dibuka kembali jika sudah ditutup sebelumnya
                                                            if (mysqli_connect_errno()) {
                                                                printf("Koneksi database gagal: %s\n", mysqli_connect_error());
                                                                exit();
                                                            }

                                                            // Kemudian Anda dapat menjalankan kueri Anda di sini
                                                            $query_jenis_pengiriman = "SELECT jenis_pengiriman FROM status_kirim WHERE id_inv_ecat = '$id_inv_ecat'";
                                                            $result_jenis_pengiriman = mysqli_query($koneksi, $query_jenis_pengiriman);

                                                            // Periksa apakah query berhasil dieksekusi dan hasilnya ada
                                                            if ($result_jenis_pengiriman && mysqli_num_rows($result_jenis_pengiriman) > 0) {
                                                                $row_jenis_pengiriman = mysqli_fetch_assoc($result_jenis_pengiriman);
                                                                $jenis_pengiriman = $row_jenis_pengiriman['jenis_pengiriman'];

                                                                // Tambahkan logika untuk menampilkan atau menyembunyikan tombol "Ubah Driver"
                                                                if ($jenis_pengiriman == "Driver") {
                                                                    // Tampilkan tombol "Ubah Driver" jika jenis_pengiriman adalah "Driver"
                                                            ?>
                                                                    <button type="button" class="btn btn-outline-primary" id="btnProsesPesanan" data-bs-toggle="modal" data-bs-target="#editNamaPetugasModal">
                                                                        Driver
                                                                    </button>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo "Error: " . mysqli_error($koneksi);
                                                            }

                                                            // Setelah selesai menggunakan koneksi, pastikan untuk menutupnya
                                                            mysqli_close($koneksi);
                                                        ?>
                                                        <?php
                                                            include "koneksi.php";

                                                            // Memastikan koneksi mysqli tetap terbuka atau dibuka kembali jika sudah ditutup sebelumnya
                                                            if (mysqli_connect_errno()) {
                                                                printf("Koneksi database gagal: %s\n", mysqli_connect_error());
                                                                exit();
                                                            }

                                                            // Kemudian Anda dapat menjalankan kueri Anda di sini
                                                            $query_jenis_pengiriman = "SELECT jenis_pengiriman FROM status_kirim WHERE id_inv_ecat = '$id_inv_ecat'";
                                                            $result_jenis_pengiriman = mysqli_query($koneksi, $query_jenis_pengiriman);

                                                            // Periksa apakah query berhasil dieksekusi dan hasilnya ada
                                                            if ($result_jenis_pengiriman && mysqli_num_rows($result_jenis_pengiriman) > 0) {
                                                                $row_jenis_pengiriman = mysqli_fetch_assoc($result_jenis_pengiriman);
                                                                $jenis_pengiriman = $row_jenis_pengiriman['jenis_pengiriman'];

                                                                // Tambahkan logika untuk menampilkan atau menyembunyikan tombol "Ubah Driver"
                                                                if ($jenis_pengiriman == "Ekspedisi") {
                                                                    // Tampilkan tombol "Ubah Driver" jika jenis_pengiriman adalah "Driver"
                                                            ?>
                                                                    <button type="button" class="btn btn-outline-primary" id="btnEkspedisi" data-bs-toggle="modal" data-bs-target="#editResidanOngkir">
                                                                        No. Resi & Ongkir
                                                                    </button>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo "Error: " . mysqli_error($koneksi);
                                                            }

                                                            // Setelah selesai menggunakan koneksi, pastikan untuk menutupnya
                                                            mysqli_close($koneksi);
                                                        ?>
                                                        <button type="button" class="btn btn-outline-primary" id="btnProsesPesanan" data-inv="<?php echo $id_inv_ecat; ?>" data-bs-toggle="modal" data-bs-target="#ubahJenisPengirimanModal">
                                                            Jenis Pengiriman
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary" onclick="printInvoice('invoice')">Invoice</button>
                                                        <button type="button" class="btn btn-outline-primary" onclick="printInvoice('pdf')">PDF</button>
                                                        <button type="button" class="btn btn-outline-primary" onclick="printInvoice('kwitansi')">Kwitansi</button>
                                                        <button type="button" class="btn btn-outline-primary" onclick="printInvoice('surat jalan')">Surat Jalan</button>
                                                        <button type="button" class="btn btn-outline-primary" id="btnUbahStatus" data-inv="<?php echo $id_inv_ecat; ?>" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">Ubah Status</button>
                                                    </div>
                                                    <!-- Modal Ubah Driver -->
                                                    <div class="modal fade" id="editNamaPetugasModal" tabindex="-1" aria-labelledby="inputNamaPetugasModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="inputNamaDriverModalLabel">Ubah Driver</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form id="inputNamaDriverForm" method="post" action="proses/ubah_driver.php">
                                                                    <input type="hidden" id="id_inv_ecat" name="id_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                                                                    <input type="hidden" class="form-control" name="id_status_kirim">
                                                                    <div class="modal-body">
                                                                        <div id="editdriverForm">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Pilih Driver</strong></label>
                                                                                <select class="form-select" id="id_driver" name="id_driver">
                                                                                    <option value="">Pilih Driver</option>
                                                                                    <?php
                                                                                    include "koneksi.php";
                                                                                    $query_driver = "SELECT id_driver, nama_driver FROM tb_driver";
                                                                                    $result_driver = mysqli_query($koneksi, $query_driver);
                                                                                    while ($data_driver = mysqli_fetch_array($result_driver)) {
                                                                                        echo '<option value="' . $data_driver['id_driver'] . '">' . $data_driver['nama_driver'] . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" id="siapDikirimBtn">Siap Dikirim</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal Ubah Jenis Pengiriman -->
                                                    <div class="modal fade" id="ubahJenisPengirimanModal" tabindex="-1" aria-labelledby="ubahJenisPengirimanLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="inputNamaPetugasModalLabel">Ubah Jenis Pengiriman</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form id="inputNamaPetugasForm" method="post" action="proses/ubah_jenis_pengiriman.php">
                                                                    <input type="hidden" id="id_inv_ecat" name="id_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                                                                    <input type="hidden" class="form-control" name="id_status_kirim">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"><strong>Jenis Pengiriman</strong></label>
                                                                            <select class="form-select" id="id_status_kirim" name="jenis_pengiriman">
                                                                                <option value="">Pilih Jenis Pengiriman</option>
                                                                                <option value="1">Diambil Langsung</option>
                                                                                <option value="2">Driver</option>
                                                                                <option value="3">Ekspedisi</option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="langsungForm">
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_langsung" name="tgl_kirim_langsung" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div id="driverForm">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Pilih Driver</strong></label>
                                                                                <select class="form-select" id="id_driver" name="id_driver">
                                                                                    <option value="">Pilih Driver</option>
                                                                                    <?php
                                                                                    include "koneksi.php";
                                                                                    $query_driver = "SELECT id_driver, nama_driver FROM tb_driver";
                                                                                    $result_driver = mysqli_query($koneksi, $query_driver);
                                                                                    while ($data_driver = mysqli_fetch_array($result_driver)) {
                                                                                        echo '<option value="' . $data_driver['id_driver'] . '">' . $data_driver['nama_driver'] . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_driver" name="tgl_kirim_driver" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div id="ekspedisiForm" style="display: none;">
                                                                            <input type="hidden" id="id_status_kirim" name="id_status_kirim">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Pilih Ekspedisi</strong></label>
                                                                                <select class="form-select" id="id_ekspedisi" name="id_ekspedisi">
                                                                                    <option value="">Pilih Ekspedisi</option>
                                                                                    <?php
                                                                                        include "koneksi.php";
                                                                                        $query_ekspedisi = "SELECT id_ekspedisi, nama_ekspedisi FROM ekspedisi";
                                                                                        $result_ekspedisi = mysqli_query($koneksi2, $query_ekspedisi);
                                                                                        while ($data_ekspedisi = mysqli_fetch_array($result_ekspedisi)) {
                                                                                            echo '<option value="' . $data_ekspedisi['id_ekspedisi'] . '">' . $data_ekspedisi['nama_ekspedisi'] . '</option>';
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Dikirim Oleh</strong></label>
                                                                                <input type="text" id="dikirim_oleh" name="dikirim_oleh" class="form-control">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Penanggung Jawab</strong></label>
                                                                                <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="form-control">
                                                                            </div>
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_ekspedisi" name="tgl_kirim_ekspedisi" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary" id="siapDikirimBtn">Siap Dikirim</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 me-3 ms-2 ms-auto d-flex flex-column align-items-start">
                                                        <!-- <small class="text-light fw-bold mb-2" style="color: your_color_here;">Data ditampilkan :</small> -->
                                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><strong>Pilih Total </strong></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" data-value="totalInvoice">Total Invoice</a></li>
                                                            <li><a class="dropdown-item" href="#" data-value="totalFeeMarketing">Total Fee Marketing</a></li>
                                                            <li><a class="dropdown-item" href="#" data-value="totalAkhir">Total Akhir</a></li>
                                                        </ul>
                                                    </div>
                                                    <?php
                                                        include "koneksi.php"; // Sesuaikan dengan file koneksi Anda

                                                        // Mengambil nilai total_inv_ecat dari inv_ecat
                                                        $query_total = "SELECT total_inv_ecat FROM inv_ecat WHERE id_inv_ecat = '$id_inv_ecat'"; // Sesuaikan dengan logika aplikasi Anda
                                                        $result_total = mysqli_query($koneksi, $query_total);

                                                        // Mengambil nilai fee_marketing dari tb_spk_ecat
                                                        $query_fee_marketing = "SELECT fee_marketing FROM tb_spk_ecat WHERE id_inv_ecat = '$id_inv_ecat'";
                                                        $result_fee_marketing = mysqli_query($koneksi, $query_fee_marketing);

                                                        // Periksa apakah query berhasil dieksekusi dan hasilnya ditemukan
                                                        if ($result_total && mysqli_num_rows($result_total) > 0 && $result_fee_marketing && mysqli_num_rows($result_fee_marketing) > 0) {
                                                            $row_total = mysqli_fetch_assoc($result_total);
                                                            $total_inv_ecat = $row_total['total_inv_ecat'];

                                                            $row_fee_marketing = mysqli_fetch_assoc($result_fee_marketing);
                                                            $fee_marketing = $row_fee_marketing['fee_marketing'];

                                                            // Menghitung Total Fee Marketing
                                                            $total_fee_marketing = ($fee_marketing / 100) * $total_inv_ecat;

                                                            // Menghitung Total Akhir
                                                            $total_akhir = $total_inv_ecat - $total_fee_marketing;

                                                            // Tampilkan nilai total_inv_ecat dan total_fee_marketing di dalam card
                                                            echo "<div class='col-lg-2 col-md-2 total-card' id='totalInvoiceCard'>";
                                                            echo "    <div class='card border d-flex flex-column'>";
                                                            echo "        <div class='card-body d-flex align-items-center justify-content-center'>";
                                                            echo "            <div class='text-center'>";
                                                            echo "                <span class='fw d-block mb-1'>Total Invoice</span>";
                                                            echo "                <h3 class='card-title mb-2'>" . number_format($total_inv_ecat) . "</h3>";
                                                            echo "            </div>";
                                                            echo "        </div>";
                                                            echo "    </div>";
                                                            echo "</div>";

                                                            echo "<div class='col-lg-2 col-md-2 total-card' id='totalFeeMarketingCard'>";
                                                            echo "    <div class='card border d-flex flex-column'>";
                                                            echo "        <div class='card-body d-flex align-items-center justify-content-center'>";
                                                            echo "            <div class='text-center'>";
                                                            echo "                <span class='fw d-block mb-1'>Total Fee Marketing (%)</span>";
                                                            echo "                <h3 class='card-title mb-2'>" . number_format($total_fee_marketing) . "</h3>";
                                                            echo "            </div>";
                                                            echo "        </div>";
                                                            echo "    </div>";
                                                            echo "</div>";

                                                            // Tampilkan nilai total_akhir di dalam card
                                                            echo "<div class='col-lg-2 col-md-2 total-card' id='totalAkhirCard'>";
                                                            echo "    <div class='card border d-flex flex-column'>";
                                                            echo "        <div class='card-body d-flex align-items-center justify-content-center'>";
                                                            echo "            <div class='text-center'>";
                                                            echo "                <span class='fw d-block mb-1'>Total Akhir</span>";
                                                            echo "                <h3 class='card-title mb-2'>" . number_format($total_akhir) . "</h3>";
                                                            echo "            </div>";
                                                            echo "        </div>";
                                                            echo "    </div>";
                                                            echo "</div>";
                                                        } else {
                                                            echo "Data tidak ditemukan"; 
                                                        }

                                                        mysqli_close($koneksi); 
                                                    ?>
                                                    
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
    <form action="proses/proses_inv_diterima.php" method="POST">
    <!-- Modal Konfirmasi -->
        <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <input type="hidden" name="id_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Perubahan Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah benar pesanan telah diterima?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ya, Pesanan Telah Diterima</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php include "page/script.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
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

    <script>
        function formatNumber(input) {
            return Number(input).toLocaleString('id-ID'); 
        }

        var hargaInputs = document.querySelectorAll('[id^="harga_"]');

        hargaInputs.forEach(function(inputElement) {
            var textValue = inputElement.value;
            
            inputElement.value = formatNumber(textValue);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectedProductsTable').DataTable({
                scrollX: true
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnSimpan = document.getElementById("siapDikirimBtn");

            btnSimpan.addEventListener("click", function() {
                const id_inv_ecat = document.getElementById("id_inv_ecat").value;
                const id_driver = document.getElementById("id_driver").value;

                // Kirim data ke skrip PHP menggunakan AJAX
                $.ajax({
                    url: 'proses/ubah_driver.php',
                    method: 'POST',
                    data: {
                        id_inv_ecat: id_inv_ecat,
                        id_driver: id_driver
                    },
                    success: function(response) {
                        console.log(response);
                        alert('Data berhasil diperbarui.');
                        // Sembunyikan modal setelah data berhasil diperbarui
                        $('#editNamaPetugasModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat memperbarui data.');
                    }
                });
            });
        });
    </script>
    <script>
       // Mengatur tampilan field berdasarkan pilihan jenis_pengiriman saat modal dibuka
        document.addEventListener('DOMContentLoaded', function() {
            var driverForm = document.getElementById('driverForm');
            var ekspedisiForm = document.getElementById('ekspedisiForm');
            var langsungForm = document.getElementById('langsungForm');
            var jenisPengirimanSelect = document.getElementById('id_status_kirim');

            // Sembunyikan semua form kecuali form untuk Diambil Langsung
            driverForm.style.display = 'none';
            ekspedisiForm.style.display = 'none';
            langsungForm.style.display = 'none';

            // Periksa jenis_pengiriman yang dipilih saat modal dibuka
            if (jenisPengirimanSelect.value === '1') { // Jika memilih "Diambil Langsung"
                langsungForm.style.display = 'block';
            }
        });

        // Event listener untuk mengubah tampilan field saat jenis_pengiriman berubah
        document.getElementById('id_status_kirim').addEventListener('change', function() {
            var driverForm = document.getElementById('driverForm');
            var ekspedisiForm = document.getElementById('ekspedisiForm');
            var langsungForm = document.getElementById('langsungForm');

            if (this.value === '1') { // Jika memilih "Diambil Langsung"
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'block';
            } else if (this.value === '2') { // Jika memilih "Driver"
                driverForm.style.display = 'block';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'none';
            } else if (this.value === '3') { // Jika memilih "Ekspedisi"
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'block';
                langsungForm.style.display = 'none';
            } else {
                // Sembunyikan kedua form jika memilih jenis pengiriman lainnya
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'none';
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mendengarkan perubahan pada dropdown jenis ongkir
            document.getElementById("jenisOngkir").addEventListener("change", function() {
                var jenisOngkir = this.value;
                var ongkirForm = document.getElementById("ongkirForm");
                var ongkirInput = document.getElementById("ongkir");
                var buktiTerimaInput = document.getElementById("buktiTerima");

                // Jika jenis ongkir adalah COD, sembunyikan form ongkir
                if (jenisOngkir === "COD") {
                    ongkirForm.style.display = "none";
                    ongkirInput.removeAttribute("required");
                    buktiTerimaInput.setAttribute("required", "required");
                } else { // Jika jenis ongkir adalah Non COD, tampilkan form ongkir
                    ongkirForm.style.display = "block";
                    ongkirInput.setAttribute("required", "required");
                    buktiTerimaInput.setAttribute("required", "required");
                }
            });
        });
    </script>
    
    <!-- <script>
        $('#normalize').selectize({ normalize: true });
    </script> -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#ecat').DataTable();

            // Hide all cards initially except for Total Invoice
            $('.total-card').hide();
            $('#totalInvoiceCard').show();

            // Dropdown menu click event
            $('.dropdown-item').on('click', function () {
                var selectedValue = $(this).data('value');

                // Hide all cards
                $('.total-card').hide();

                // Show the selected card
                $('#' + selectedValue + 'Card').show();

            });

        });
    </script>

    <!-- Modal Edit Resi dan Ongkir -->
    <div class="modal fade" id="editResidanOngkir" tabindex="-1" aria-labelledby="editResidanOngkirLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editResidanOngkirLabel">Input No. Resi & Ongkir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="inputResidanOngkirForm" method="post" action="proses/proses_resi_ongkir.php"  enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="id_inv_ecat" name="id_inv_ecat" value="<?php echo $id_inv_ecat; ?>">
                    <div class="mb-3">
                        <label class="form-label"><strong>Jenis Ongkir</strong></label>
                        <select class="form-select" id="jenisOngkir" name="jenis_ongkir">
                            <option value="COD">COD</option>
                            <option value="Non COD">Non COD</option>
                        </select>
                    </div>
                    <div id="ongkirForm" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label"><strong>Ongkir</strong></label>
                            <input type="text" id="ongkir" name="ongkir" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>No. Resi</strong></label>
                        <input type="text" id="noResi" name="no_resi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Bukti Resi Kirim</strong></label>
                        <input type="file" id="buktiTerima" name="bukti_terima" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
    function submitForm() {
        console.log("Tombol Simpan diklik!"); // Membuat log untuk memastikan fungsi dipanggil
        document.getElementById("inputResidanOngkirForm").submit();
    }
    </script>
    <script>
    $(document).ready(function() {
        // Fungsi untuk mengonversi angka menjadi format yang sesuai
        function formatAngka(angka) {
            // Memeriksa apakah nilai input adalah angka atau string kosong
            if (!angka || isNaN(angka)) {
                return ''; // Mengembalikan string kosong jika input tidak valid
            }

            // Mengonversi angka menjadi format mata uang dengan menggunakan Intl.NumberFormat
            var formattedAngka = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(angka);

            // Menghapus penambahan ,00 di akhir nilai
            if (formattedAngka.slice(-3) === ',00') {
                formattedAngka = formattedAngka.slice(0, -3);
            }

            return formattedAngka;
        }

        // Event listener untuk memperbarui format harga saat input berubah
        $('#ongkir').on('input', function() {
            // Menghapus karakter selain angka dari input
            var nilaiInput = hapusKarakterTidakValid($(this).val());
            
            // Mengonversi nilai input ke dalam format angka yang sesuai
            var formattedNilai = formatAngka(nilaiInput);

            // Memasukkan nilai yang telah diformat kembali ke dalam input
            $(this).val(formattedNilai);
        });

        // Fungsi untuk menghapus semua karakter selain angka dari input
        function hapusKarakterTidakValid(str) {
            return str.replace(/\D/g, '');
        }
    });
</script>

</body>
</html>

