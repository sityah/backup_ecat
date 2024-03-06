<?php
include "koneksi.php";

// Pastikan id_spk_ecat diset sebelum melakukan perubahan
if (isset($_GET['id_spk_ecat'])) {
    $spkId = $_GET['id_spk_ecat'];

    // Update status cetak menjadi 1
    $updateSql = "UPDATE tb_spk_ecat SET status_cetak = 1 WHERE id_spk_ecat = '$spkId'";
    mysqli_query($koneksi, $updateSql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SURAT PERINTAH KERJA</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        width: 80%;
        margin: 0 auto;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .left-column {
        float: left;
        width: 50%;
    }
    .right-column {
        float: right;
        width: 50%;
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .note {
        margin-bottom: 20px;
    }
    .signatures {
        width: 50%;
        float: left;
        margin-bottom: 40px; 
    }
    .label {
        float: right;
        text-align: right;
    }
    .petugas-box {
        border: 1px solid #000;
        padding: 8px;
        display: inline-block;
    }
    @media print {
            .print-btn, .back-btn {
                display: none !important;
            }
        }
</style>
</head>
<body>
    <div class="row">
        <div class="left-column">
            <a href="detail_produk_spk.php?id_spk_ecat=<?php echo $spkId; ?>" class="btn btn-outline-primary back-btn" onclick="reloadPage()">Kembali</a>
        </div>
        <div class="right-column">
            <a href="#" onclick="window.print();" class="btn btn-outline-primary print-btn">Cetak SPK</a>
        </div>
    </div>
    <div class="container">
        <div class="header">
            <h1>SURAT PERINTAH KERJA</h1>
        </div>
        <div class="left-column">
        <?php
            include "koneksi.php";

            if (isset($_GET['id_spk_ecat'])) {
            $spkId = $_GET['id_spk_ecat'];

            $sql = "
                    SELECT
                    tb_spk_ecat.tgl_pesanan_ecat,
                    tb_spk_ecat.no_spk_ecat,
                    tb_spk_ecat.tgl_spk_ecat,
                    tb_spk_ecat.no_paket,
                    tb_spk_ecat.nama_paket,
                    tb_spk_ecat.fee_marketing,
                    tb_sales_ecat.nama_sales,
                    tb_perusahaan.nama_perusahaan,
                    tb_perusahaan.alamat_perusahaan,
                    tb_provinsi.nama_provinsi
                FROM
                    tb_spk_ecat
                JOIN
                    tb_sales_ecat ON tb_spk_ecat.id_sales = tb_sales_ecat.id_sales
                JOIN
                    tb_perusahaan ON tb_sales_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                JOIN
                    tb_provinsi ON tb_sales_ecat.id_provinsi = tb_provinsi.id_provinsi
                WHERE
                    tb_spk_ecat.id_spk_ecat = '$spkId'

            ";

            $result = mysqli_query($koneksi, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo '
                    <div class="left-column">
                        <p>No. SPK : ' . $row["no_spk_ecat"] . '</p>
                        <p>ID Paket : ' . $row["no_paket"] . '</p>
                        <p>Nama Paket : ' . $row["nama_paket"] . '</p>
                        <p>Sales : ' . $row["nama_sales"] . '</p>
                    </div>
                ';
            }            
            } else {
            echo "Tidak ada data yang ditemukan";
            }

            mysqli_close($koneksi);
            ?>
        </div>
        <div class="right-column">
            <p><?php echo "Bekasi, " . date("d F Y"); ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 50%;">Nama Produk</th>
                    <th scope="col" style="width: 15%;">Satuan</th>
                    <th scope="col" style="width: 15%;">Merk</th>
                    <th scope="col" style="width: 15%;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "koneksi.php";
                    // Query untuk mengambil data dari tabel tb_customer
                    $query = "SELECT 
                                sr.id_spk_ecat,
                                tps.id_tmp_ecat,
                                tps.id_produk_ecat,
                                spr.stock, 
                                tpr.nama_produk, 
                                tpr.satuan,
                                tps.qty,
                                tps.status_tmp,
                                tpr.harga_produk,
                                tm.nama_merk  
                            FROM mandir36_db_ecat_staging.tmp_produk_spk_ecat AS tps
                            LEFT JOIN mandir36_db_ecat_staging.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk_ecat
                            LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                            LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                            LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                            WHERE sr.id_spk_ecat = '$spkId' AND tps.status_tmp = 1";
                    $result = mysqli_query($koneksi, $query);

                    // Hasil query
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $no++ . "</th>";
                        echo "<td>" . $row['nama_produk'] . "</td>"; 
                        echo "<td>" . $row['satuan'] . "</td>";  
                        echo "<td>" . $row['nama_merk'] . "</td>"; 
                        echo "<td>" . $row['qty'] . "</td>"; 
                        echo "</tr>";
                    }
                    mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
        <div class="note">
        <?php
            include "koneksi.php";

            if (isset($_GET['id_spk_ecat'])) {
            $spkId = $_GET['id_spk_ecat'];

            $sql = "
                    SELECT
                    tb_spk_ecat.notes
                FROM
                    tb_spk_ecat
                WHERE
                    tb_spk_ecat.id_spk_ecat = '$spkId'

            ";

            $result = mysqli_query($koneksi, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo '
                    <div class="column">
                        <p>Notes : ' . $row["notes"] . '</p>
                    </div>
                ';
            }
            } 

            mysqli_close($koneksi);
            ?>
        </div>
        <div class="signatures">
            <p>Mengetahui,</p>
            <div class="content-img-ttd text-right">
                <br><br><br>
            </div>
            <div class="content-hormat text-left">
                <b style="text-decoration: underline;">Purwono</b><br>
                Kepala Gudang
            </div>
        </div>
        <div class="signatures">
            <p>Mengetahui,</p>
            <div class="content-img-ttd text-right">
                <br><br><br>
            </div>
            <div class="content-hormat text-left">
                <b style="text-decoration: underline;">Lisa</b><br>
                Penanggung Jawab Teknis
            </div>
        </div>
        <div class="row">
            &nbsp;&nbsp;&nbsp;
            <div class="right-column" style="border: 1px solid black; padding: 10px; text-align: left; width: fit-content;">
                <div class="content-hormat">
                    <b>Nama Petugas : </b><br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
