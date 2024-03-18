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
                    <div class="container-xxl flex-grow-1 container-p-y">
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
                                        $query = "SELECT *
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
                                        $query = "SELECT *
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
                                        $query = "SELECT *
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
                                    <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#navs-justified-messages">
                                        <i class="tf-icons bx bx-printer"></i> Invoice Dicetak
                                        <?php echo $badge; ?>
                                    </button>
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
                                    <a href="spk_diterima.php" class="nav-link">
                                        <i class="tf-icons bx bx-user-check"></i> Diterima
                                        <?php echo $badge; ?>
                                    </a>
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
                                        <i class="tf-icons bx bx-x-circle"></i> Cancel
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
                                            <th style="width: 5%; text-align: center;">No</th>
                                            <th style="width: 20%; text-align: center;">No. Invoice</th>
                                            <th style="width: 15%; text-align: center;">Tgl. Invoice</th>
                                            <th style="width: 15%; text-align: center;">ID Paket</th>
                                            <th style="width: 35%; text-align: center;">Nama Satker</th>
                                            <th style="width: 10%; text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include "koneksi.php";
                                            $query = "SELECT 
                                                        inv_ecat.id_inv_ecat, 
                                                        inv_ecat.no_inv_ecat, 
                                                        inv_ecat.tgl_inv_ecat, 
                                                        inv_ecat.notes, 
                                                        tb_sales_ecat.nama_sales, 
                                                        tb_perusahaan.nama_perusahaan, 
                                                        tb_spk_ecat.no_paket,
                                                        GROUP_CONCAT(tb_spk_ecat.id_spk_ecat) AS id_spk_ecat,
                                                        GROUP_CONCAT(tb_spk_ecat.no_spk_ecat) AS no_spk_ecat
                                                    FROM 
                                                        inv_ecat
                                                    LEFT JOIN 
                                                        tb_spk_ecat ON inv_ecat.id_inv_ecat = tb_spk_ecat.id_inv_ecat
                                                    LEFT JOIN 
                                                        tb_sales_ecat ON tb_spk_ecat.id_sales = tb_sales_ecat.id_sales
                                                    LEFT JOIN 
                                                        tb_perusahaan ON tb_spk_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                                                    WHERE 
                                                        inv_ecat.status_transaksi = 'Invoice Dibuat'
                                                    GROUP BY 
                                                        inv_ecat.id_inv_ecat";
                                                        
                                            $result = mysqli_query($koneksi, $query);

                                            // Hasil query
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td scope='row' style='text-align: center;'>" . $no++ . "</td>";
                                                echo "<td style='text-align: center;'>" . $row['no_inv_ecat'] . "</td>"; 
                                                echo "<td style='text-align: center;'>" . $row['tgl_inv_ecat'] . "</td>";  
                                                echo "<td style='text-align: center;'>" . $row['no_paket'] . "</td>"; 
                                                echo "<td style='text-align: center;'>" . $row['nama_perusahaan'] . "</td>";
                                                echo "<td>
                                                        <a href='details_invoice_ecat.php?id_inv_ecat=" . $row['id_inv_ecat'] . "' class='btn btn-info btn-sm mt-2'>
                                                            <i class='bx bx-show'></i>
                                                        </a>
                                                        <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_spk_ecat'] . "' data-no='" . $row['no_spk_ecat'] . "'>
                                                            <i class='bx bx-x-circle'></i>
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
    <script type="text/javascript">
        $(document).ready(function() {
            new DataTable('#spk_ecat');
        }); 
    </script>

    <?php include "page/script.php"; ?>

    <!-- Modal Cancel -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="proses/cancel_invoice.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel"><b>Cancel Pesanan</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <input type="hidden" name="id_spk_ecat" id="idToDelete">
                        <input type="hidden" id="noSpkToDelete" name="no_spk_ecat">
                        <p id="deleteMessage"></p>
                        <div class="mb-3">
                            <label for="namaPetugas" class="form-label"><strong>Alasan Cancel</strong></label>
                            <input type="text" class="form-control" id="notes" name="notes" required>
                        </div>
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
            var spkMessage = "Apakah anda yakin ingin Cancel Pesanan <strong>" + noSpk + " ?</strong>"; 
            $("#idToDelete").val(idToDelete); 
            $("#noSpkToDelete").val(noSpk); 
            $("#deleteMessage").html(spkMessage); 
            $("#deleteModal").modal('show');
        });
    </script>
</body>
</html>

