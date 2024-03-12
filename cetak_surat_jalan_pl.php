<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SURAT JALAN</title>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px; 
        margin: auto;
        width: 21cm; 
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f2f2f2;
    }
    .print-area {
        width: 21cm; 
        border: none; 
        padding: 20px; 
        background-color: white;
        margin: auto;
    }
    .container {
        width: 95%;
        margin: auto;
    }
    .header {
        text-align: right;
        margin-bottom: 20px;
    }
    .left-column {
        width: 60%;
        float: left;
    }
    .right-column {
        width: 40%;
        float: right;
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
    }
    .left-column-terbilang {
        width: 100%;
        float: left;
    }
    th, td {
        border: 1px solid #000;
        padding: 5px; 
        text-align: left;
    }
    .info-box {
        border: 1px solid #000; 
        padding: 5px; 
        display: inline-block; 
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .info-box p {
        text-align: left; 
        margin: 5px;
    }
</style>
</head>
<body>
    <div class="print-area">
        <div class="container">
            <div class="header">
                <h1>SURAT JALAN</h1>
            </div>
            <div class="left-column">
                <?php
                    include "koneksi.php";

                    if (isset($_GET['id_inv_pl'])) {
                    $id_inv_pl = $_GET['id_inv_pl'];

                    $sql = "SELECT
                                tb_spk_pl.tgl_pesanan_pl,
                                COALESCE(GROUP_CONCAT(tb_spk_pl.no_spk_pl SEPARATOR ', '), 'N/A') AS no_spk_pl,
                                tb_spk_pl.no_po,
                                tb_spk_pl.fee_marketing,
                                tb_sales_ecat.nama_sales,
                                tb_perusahaan.nama_perusahaan,
                                tb_perusahaan.alamat_perusahaan,
                                tb_provinsi.nama_provinsi,
                                inv_pl.no_inv_pl,
                                inv_pl.tgl_inv_pl,
                                inv_pl.total_inv_pl,
                                inv_pl.notes,
                                status_kirim.jenis_pengiriman,
                                status_kirim.tgl_kirim,
                                tb_driver.nama_driver,
                                ekspedisi.nama_ekspedisi,
                                status_kirim.dikirim_oleh,
                                status_kirim.penanggung_jawab
                            FROM
                                inv_pl
                            LEFT JOIN
                                tb_spk_pl ON inv_pl.id_inv_pl = tb_spk_pl.id_inv_pl 
                            LEFT JOIN
                                tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                            LEFT JOIN
                                tb_perusahaan ON tb_spk_pl.id_perusahaan = tb_perusahaan.id_perusahaan
                            LEFT JOIN
                                tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                            LEFT JOIN
                                status_kirim ON inv_pl.id_inv_pl = status_kirim.id_inv_ecat
                            LEFT JOIN
                                tb_driver ON status_kirim.id_driver = tb_driver.id_driver
                            LEFT JOIN
                                ekspedisi ON status_kirim.id_ekspedisi = ekspedisi.id_ekspedisi
                            WHERE
                                inv_pl.id_inv_pl = '$id_inv_pl' AND
                                tb_spk_pl.status_spk_pl = 'Dikirim'
                            GROUP BY
                                inv_pl.id_inv_pl";

                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo '
                            <div class="left-column" style="line-height: 0.9;">
                                <p><strong>No. Invoice : </strong>' . $row["no_inv_pl"] . '</p>
                                <p><strong>Tgl. Invoice : </strong>' . $row["tgl_inv_pl"] . '</p>
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
                <?php
                if (mysqli_num_rows($result) > 0) {
                    echo '
                        <div class="info-box">
                            <p><strong>Kepada :</strong></p>
                            <p>' . $row["nama_perusahaan"] . '</p>
                            <p>' . $row["alamat_perusahaan"] . '</p>
                        </div>
                    ';
                }            
                ?>
            </div>
            <div>
            <table>
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%; text-align: center;">No</th>
                        <th scope="col" style="width: 50%; text-align: center;">Nama Produk</th>
                        <th scope="col" style="width: 15%; text-align: center;">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include "koneksi.php";
                        // Query untuk mengambil data dari tabel tb_customer
                        $query = "SELECT 
                                    sr.id_spk_pl,
                                    sr.status_spk_pl,
                                    tps.id_transaksi_pl,
                                    sr.no_spk_pl,
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
                                    mandir36_db_ecat_staging.transaksi_produk_pl AS tps
                                LEFT JOIN 
                                    mandir36_db_ecat_staging.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk
                                LEFT JOIN 
                                    mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                LEFT JOIN 
                                    mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                LEFT JOIN 
                                    mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                WHERE 
                                    tps.status_trx = 1 AND sr.id_inv_pl = (SELECT id_inv_pl FROM inv_pl WHERE id_inv_pl = '$id_inv_pl')";
                        $result = mysqli_query($koneksi, $query);

                        // Hasil query
                        $no = 1;
                        $grand_total = 0; // Inisialisasi grand total
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<th scope='row' style='text-align: center;'>" . $no++ . "</th>";
                            echo "<td style='text-align: left;'>" . $row['nama_produk'] . "</td>"; 
                            echo "<td style='text-align: center;'>" . $row['qty'] . "</td>";  
                            echo "</tr>";
                            
                        }

                        mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
            </div>
            <br><br><br>
            <div>
                <table style="width: 100%; border: none; margin-top: 30px;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 34%; text-align: center; border: none; vertical-align: top;">Disetujui oleh,</th>
                            <th scope="col" style="width: 33%; text-align: center; border: none; vertical-align: top;">Diantar oleh,</th>
                            <th scope="col" style="width: 33%; text-align: center; border: none; vertical-align: top;">Diterima oleh,</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center; height: 100px; border: none;">____________</td>
                            <td style="text-align: center; height: 100px; border: none;">____________</td>
                            <td style="text-align: center; height: 100px; border: none;">____________</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
