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
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                    <div class="nav-align-top mb-4">   
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <a href="data_spk.php" class="nav-link">SPK E-Catalog</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home">SPK Penunjukkan Langsung</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM 
                                                    tb_spk_pl
                                                WHERE 
                                                    tb_spk_pl.status_spk_pl = 'Belum Diproses'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="data_spk_pl.php" class="nav-link">
                                        <i class="tf-icons bx bx-time"></i> Belum Diproses
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM 
                                                    tb_spk_pl
                                                WHERE 
                                                    tb_spk_pl.status_spk_pl = 'Dalam Proses'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_dalam_proses.php" class="nav-link">
                                        <i class="tf-icons bx bx-sync"></i> Dalam Proses
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM 
                                                    tb_spk_pl
                                                WHERE 
                                                    tb_spk_pl.status_spk_pl = 'Siap Kirim'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_siap_kirim.php" class="nav-link">
                                        <i class="tf-icons bx bx-package"></i> Siap Kirim
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM 
                                                    tb_spk_pl
                                                WHERE 
                                                    tb_spk_pl.status_spk_pl = 'Invoice Dibuat'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_invoice_dicetak.php" class="nav-link">
                                        <i class="tf-icons bx bx-printer"></i> Invoice Dicetak
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM inv_pl
                                                WHERE status_transaksi = 'Dikirim'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_dikirim.php" class="nav-link">
                                        <i class="tf-icons bx bx-send"></i> Dikirim
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM inv_pl
                                                WHERE status_transaksi = 'Diterima'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_diterima.php" class="nav-link">
                                        <i class="tf-icons bx bx-user-check"></i> Diterima
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM inv_pl
                                                WHERE status_transaksi = 'Transaksi Selesai'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_pl_selesai.php" class="nav-link">
                                        <i class="tf-icons bx bx-calendar-check"></i> Transaksi Selesai
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        // Query untuk mengambil data dari tabel tb_spk_pl
                                        $query = "SELECT *
                                                FROM inv_pl
                                                WHERE status_transaksi = 'Cancel'";
                                        $result = mysqli_query($koneksi, $query);

                                        // Hitung jumlah baris (data) yang ditemukan
                                        $total_rows = mysqli_num_rows($result);
                                        
                                        // Inisialisasi variabel badge
                                        $badge = '';

                                        // Jika ada data yang ditemukan, tampilkan badge dengan jumlah data
                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-justified-profile">
                                        <i class="tf-icons bx bx-x-circle"></i> Cancel
                                        <?php echo $badge; ?>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-justified-messages" role="tabpanel">
                                <table class="table" id="spk_ecat" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. SPK</th>
                                            <th>Tgl. SPK</th>
                                            <th>Nama Sales</th>
                                            <th>Alasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include "koneksi.php";
                                            $query = "SELECT 
                                                        tb.id_inv_pl,
                                                        GROUP_CONCAT(tb.no_spk_pl SEPARATOR ', ') AS no_spk_combined,
                                                        CONCAT('<strong>(', 
                                                            (SELECT DISTINCT inv.no_inv_pl 
                                                                FROM inv_pl inv 
                                                                WHERE inv.id_inv_pl = tb.id_inv_pl 
                                                                LIMIT 1),'</strong>)') AS inv_numbers,
                                                        tb.tgl_spk_pl,
                                                        tb.id_spk_pl,
                                                        tb.notes,
                                                        sales.nama_sales
                                                    FROM tb_spk_pl AS tb
                                                    JOIN tb_sales_ecat AS sales ON tb.id_sales = sales.id_sales
                                                    LEFT JOIN inv_pl AS inv ON tb.id_inv_pl = inv.id_inv_pl
                                                    WHERE tb.status_spk_pl = 'Cancel'
                                                    GROUP BY tb.id_inv_pl";
                                            $result = mysqli_query($koneksi, $query);

                                            // Hasil query
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td scope='row'>" . $no++ . "</td>";
                                                if (!empty($row['inv_numbers'])) {
                                                    echo "<td>" . $row['no_spk_combined'] . " - " . $row['inv_numbers'] . "</td>"; // Menampilkan no_spk_ecat dan no_inv_ecat dalam satu kolom jika ada
                                                } else {
                                                    echo "<td>" . $row['no_spk_combined'] . "</td>"; // Menampilkan no_spk_ecat saja jika tidak ada no_inv_ecat
                                                }
                                                echo "<td>" . $row['tgl_spk_pl'] . "</td>";  
                                                echo "<td>" . $row['nama_sales'] . "</td>";
                                                echo "<td>" . $row['notes'] . "</td>"; 
                                                echo "<td>
                                                        <a href='details_transaksi_pl_cancel.php?id_spk_pl=" . $row['id_spk_pl'] . "' class='btn btn-info btn-sm mt-2'>
                                                            <i class='bx bx-show'></i>
                                                        </a>
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
    <script type="text/javascript">
        $(document).ready(function() {
            new DataTable('#spk_ecat');
        }); 
    </script>

    <?php include "page/script.php"; ?>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="proses/proses_spk_pl.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_spk_pl" id="idToDelete">
                        <input type="hidden" id="noSpkToDelete" name="no_spk_pl">
                        <p id="deleteMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" name="delete-spk">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).on("click", ".btn-delete", function() {
            var idToDelete = $(this).data('id'); 
            var noSpk = $(this).data('no'); 
            var spkMessage = "Apakah anda yakin ingin menghapus ID SPK <strong>" + noSpk + "</strong>?"; 
            $("#idToDelete").val(idToDelete); 
            $("#noSpkToDelete").val(noSpk); 
            $("#deleteMessage").html(spkMessage); 
            $("#deleteModal").modal('show');
        });
    </script>
</body>
</html>
