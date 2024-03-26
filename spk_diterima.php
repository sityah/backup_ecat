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
                            <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home">SPK E-Catalog</button>
                        </li>
                        <li class="nav-item">
                            <a href="data_spk_pl.php" class="nav-link">SPK Penunjukkan Langsung</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT 
                                                    tb_spk_ecat.*
                                                FROM 
                                                    tb_spk_ecat
                                                WHERE 
                                                    tb_spk_ecat.status_spk_ecat = 'Belum Diproses'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="data_spk.php" class="nav-link">
                                        <i class="tf-icons bx bx-time"></i> Belum Diproses
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT 
                                                    tb_spk_ecat.*
                                                FROM 
                                                    tb_spk_ecat
                                                WHERE 
                                                    tb_spk_ecat.status_spk_ecat = 'Dalam Proses'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_dalam_proses.php" class="nav-link">
                                        <i class="tf-icons bx bx-sync"></i> Dalam Proses
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT 
                                                    tb_spk_ecat.*
                                                FROM 
                                                    tb_spk_ecat
                                                WHERE 
                                                    tb_spk_ecat.status_spk_ecat = 'Siap Kirim'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_siap_kirim.php" class="nav-link">
                                        <i class="tf-icons bx bx-package"></i> Siap Kirim
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT *
                                                FROM inv_ecat
                                                WHERE status_transaksi = 'Invoice Dibuat'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_invoice_dicetak.php" class="nav-link">
                                        <i class="tf-icons bx bx-printer"></i> Invoice Dicetak
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT *
                                                FROM inv_ecat
                                                WHERE status_transaksi = 'Dikirim'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_dikirim.php" class="nav-link">
                                        <i class="tf-icons bx bx-send"></i> Dikirim
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT *
                                                FROM inv_ecat
                                                WHERE status_transaksi = 'Diterima'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-justified-messages">
                                        <i class="tf-icons bx bx-user-check"></i> Diterima
                                        <?php echo $badge; ?>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT *
                                                FROM inv_ecat
                                                WHERE status_transaksi = 'Transaksi Selesai'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="spk_selesai.php" class="nav-link">
                                        <i class="tf-icons bx bx-calendar-check"></i> Transaksi Selesai
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php
                                        include "koneksi.php";
                                        $query = "SELECT 
                                                    tb_spk_ecat.*
                                                FROM 
                                                    tb_spk_ecat
                                                WHERE 
                                                    tb_spk_ecat.status_spk_ecat = 'Cancel'";
                                        $result = mysqli_query($koneksi, $query);

                                        $total_rows = mysqli_num_rows($result);
                                        
                                        $badge = '';

                                        if ($total_rows > 0) {
                                            $badge = '<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">' . $total_rows . '</span>';
                                        }
                                    ?>
                                    <a href="transaksi_cancel.php" class="nav-link">
                                        <i class="tf-icons bx bx-sync"></i> Cancel
                                        <?php echo $badge; ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-justified-messages" role="tabpanel">
                                <table class="table" id="spk_ecat" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Invoice</th>
                                            <th>Tgl. Invoice</th>
                                            <th>Nama Sales</th>
                                            <th>Jenis Pengiriman</th>
                                            <th>Note</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include "koneksi.php";
                                            $query = "SELECT inv.id_inv_ecat, 
                                                            inv.no_inv_ecat, 
                                                            inv.tgl_inv_ecat, 
                                                            inv.notes, 
                                                            inv.total_inv_ecat, 
                                                            kirim.jenis_pengiriman,
                                                            sales.nama_sales
                                                    FROM inv_ecat AS inv
                                                    JOIN status_kirim AS kirim ON inv.id_inv_ecat = kirim.id_inv_ecat
                                                    JOIN tb_spk_ecat AS spk ON inv.id_inv_ecat = spk.id_inv_ecat
                                                    JOIN tb_sales_ecat AS sales ON spk.id_sales = sales.id_sales
                                                    WHERE inv.status_transaksi = 'Diterima'
                                                    GROUP BY inv.id_inv_ecat, 
                                                            inv.no_inv_ecat, 
                                                            inv.tgl_inv_ecat, 
                                                            inv.notes, 
                                                            inv.total_inv_ecat, 
                                                            kirim.jenis_pengiriman,
                                                            sales.nama_sales";
                                            $result = mysqli_query($koneksi, $query);

                                            // Hasil query
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td scope='row'>" . $no++ . "</td>";
                                                echo "<td>" . $row['no_inv_ecat'] . "</td>"; 
                                                echo "<td>" . $row['tgl_inv_ecat'] . "</td>"; 
                                                echo "<td>" . $row['nama_sales'] . "</td>"; 
                                                echo "<td>" . $row['jenis_pengiriman'] . "</td>";  
                                                echo "<td>" . $row['notes'] . "</td>";  
                                                echo "<td>
                                                        <a href='details_ecat_diterima.php?id_inv_ecat=" . $row['id_inv_ecat'] . "' class='btn btn-info btn-sm mt-2'>
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
</body>
</html>
