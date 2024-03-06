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
<style>
    #ecat th, #ecat td {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #id_kota_kab_select,
    #id_kota_kab_label {
        display: none; /* Sembunyikan kolom kota/kabupaten dan label awalnya */
    }
    #ecat_modal th {
        white-space: nowrap;
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
                    <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                        <a href="data_produk_satuan.php" class="nav-link" role="tab" aria-controls="navs-pills-justified-home" aria-selected="true">
                            <i class="tf-icons bx bx-package"></i> Produk Satuan
                        </a>
                        </li>
                        <li class="nav-item">
                        <button type="button" class="nav-link  active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">
                            <i class="tf-icons bx bx-layer"></i> Produk Set
                        </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tableKu">
                                <thead>
                                    <tr class="text-white" style="background-color: #051683;">
                                        <td class="text-center p-3" style="width: 50px">No</td>
                                        <td class="text-center p-3" style="width: 450px">Nama Produk</td>
                                        <td class="text-center p-3" style="width: 100px">Merk</td>
                                        <td class="text-center p-3" style="width: 80px">Stock</td>
                                        <td class="text-center p-3" style="width: 80px">Level</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    date_default_timezone_set('Asia/Jakarta');
                                    include "koneksi.php";
                                    include "function/class-function-stock.php";
                                    $no = 1;
                                    $sql_set = "SELECT 
                                                    COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat) AS id_produk,
                                                    COALESCE(tpr.nama_produk, tpsm.nama_set_ecat) AS nama_produk,
                                                    COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                                    spr.id_stock_prod_ecat,
                                                    spr.stock,
                                                    tkp.min_stock, 
                                                    tkp.max_stock,
                                                    SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) AS substr_id_produk
                                                FROM stock_produk_ecat AS spr
                                                LEFT JOIN tb_produk_ecat AS tpr ON (tpr.id_produk_ecat = spr.id_produk_ecat)
                                                LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                                                LEFT JOIN tb_produk_set_ecat AS tpsm ON (tpsm.id_set_ecat = spr.id_produk_ecat)
                                                LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                                                LEFT JOIN tb_merk AS mr_tpsm ON (tpsm.id_merk = mr_tpsm.id_merk)
                                                WHERE SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) = 'SE'
                                                ORDER BY nama_produk ASC";
                                    $query_set = mysqli_query($koneksi2, $sql_set);
                                    while ($data_set = mysqli_fetch_array($query_set)) {
                                        $id_stock = base64_encode($data_set['id_stock_prod_ecat']);
                                        $id_produk = base64_encode($data_set['id_produk']);
                                        $stockDataSet = StockStatusStock::getStatusStock($data_set['stock'], $data_set['min_stock'], $data_set['max_stock']);
                                    ?>
                                        <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td><?php echo $data_set['nama_produk'] ?></td>
                                        <td class="text-center"> <?php echo $data_set['nama_merk'] ?> </td>
                                        <?php echo "<td class='text-end " . $stockDataSet['textColor'] . "' style='background-color: " . $stockDataSet['backgroundColor'] . "'>" . $stockDataSet['formattedStock'] . "</td>";  ?>
                                        <?php echo "<td class='text-end'>" . $stockDataSet['status'] . "</td>"; ?>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

</body>
</html>
<script type="text/javascript">
    new DataTable('#tableKu');
</script>
