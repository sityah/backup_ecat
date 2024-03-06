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
                            <h5 class="card-header text-center"><b>DETAIL TRANSAKSI CANCEL</b></h5>
                            <div class="card-body border m-2">
                            <div class="mt-4 text-end me-3">
                                <button type="button" class="btn btn-secondary mb-3">E-Catalog</button>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_spk_pl'])) {
                                        $id_spk_pl = $_GET['id_spk_pl'];

                                        $sql = "
                                                SELECT
                                                tb_spk_pl.tgl_pesanan_pl,
                                                COALESCE(GROUP_CONCAT(tb_spk_pl.no_spk_pl SEPARATOR ', '), 'N/A') AS no_spk_pl,
                                                tb_spk_pl.tgl_spk_pl,
                                                tb_spk_pl.no_po,
                                                tb_spk_pl.fee_marketing,
                                                tb_spk_pl.notes,
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
                                                tb_spk_pl.id_spk_pl = '$id_spk_pl'
                                    
                                        ";

                                        $result = mysqli_query($koneksi, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            echo '
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table> 
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. Pesanan</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_pesanan_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">No. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_spk_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_spk_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">ID Paket</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_po"] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Satuan Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_perusahaan"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Alamat Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["alamat_perusahaan"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Wilayah Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_provinsi"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Sales</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_sales"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Notes</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["notes"] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            ';
                                        }
                                    } else {
                                        echo "Tidak ada data yang ditemukan";
                                    }
                                    
                                    mysqli_close($koneksi);

                                ?>
                            </div>
                            <form id="insertForm" method="post" action="">
                                <input type="hidden" name="id_spk_pl" value="<?php echo $id_spk_pl; ?>">
                                <div class="card-body border mt-2 mb-4">
                                    <div class="row mb-4">
                                        <div class="table-responsive">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = 'transaksi_pl_cancel.php';"><i class="tf-icons bx bxs-chevrons-left"></i> Kembali</button>
                                                
                                            </div>

                                            <table class="table table-striped" id="selectedProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 5%;">No</th>
                                                        <th scope="col" style="width: 40%;">Nama Produk</th>
                                                        <th scope="col" style="width: 15%;">Satuan</th>
                                                        <th scope="col" style="width: 15%;">Merk</th>
                                                        <th scope="col" style="width: 15%;">Harga</th>
                                                        <th scope="col" style="width: 10%;">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        include "koneksi.php";
                                                        $query = "SELECT 
                                                                    sr.id_spk_pl,
                                                                    sr.status_spk_pl,
                                                                    tps.id_trx_cancel,
                                                                    tps.id_produk,
                                                                    spr.stock, 
                                                                    tpr.nama_produk, 
                                                                    tpr.satuan,
                                                                    tps.qty,
                                                                    tpr.harga_produk,
                                                                    tm.nama_merk
                                                                FROM 
                                                                    db_ecat.trx_cancel AS tps
                                                                LEFT JOIN 
                                                                    db_ecat.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk_pl
                                                                LEFT JOIN 
                                                                    db_inventory.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                                                WHERE 
                                                                    sr.id_spk_pl = '$id_spk_pl'";
                                                        $result = mysqli_query($koneksi, $query);

                                                        // Hasil query
                                                        $no = 1;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>";
                                                            echo "<th scope='row'>" . $no++ . "</th>";
                                                            echo "<td>" . $row['nama_produk'] . "</td>"; 
                                                            echo "<td>" . $row['satuan'] . "</td>";  
                                                            echo "<td>" . $row['nama_merk'] . "</td>"; 
                                                            echo "<td>" . number_format($row['harga_produk'], 0, ',', '.') . "</td>"; 
                                                            echo "<td>" . $row['qty'] . "</td>"; 
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

    <?php include "page/script.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
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
            $('#selectedProductsTable').DataTable();
        });
    </script>

</body>
</html>