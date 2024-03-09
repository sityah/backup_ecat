<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>INVOICE</title>
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
    .info-box-metode {
        width: 160px; 
        margin-top: 2px;
        border: 1px solid #000;
        padding: 8px; 
        border-radius: 6px;
    }
    .info-box-metode p {
        margin: 5px 0; 
    }
</style>
</head>
<body>
    <div class="print-area">
        <div class="container">
            <div class="header">
                <h1>INVOICE</h1>
            </div>
            <div class="left-column">
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
                                inv_ecat.total_inv_ecat,
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
                        echo '
                            <div class="left-column" style="line-height: 0.9;">
                                <p><strong>No. Invoice : </strong>' . $row["no_inv_ecat"] . '</p>
                                <p><strong>Tgl. Invoice : </strong>' . $row["tgl_inv_ecat"] . '</p>
                                <p><strong>Nama Sales : </strong>' . $row["nama_sales"] . '</p>
                                <p><strong>Nama Paket : </strong>' . $row["nama_paket"] . '</p>
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
            <div class="right-column">
                <?php
                    include "koneksi.php";

                    if (isset($_GET['id_inv_ecat'])) {
                    $id_inv_ecat = $_GET['id_inv_ecat'];

                    $sql = "SELECT
                                inv_ecat.total_inv_ecat
                            FROM
                                inv_ecat
                            LEFT JOIN
                                tb_spk_ecat ON inv_ecat.id_inv_ecat = tb_spk_ecat.id_inv_ecat 
                            WHERE
                                inv_ecat.id_inv_ecat = '$id_inv_ecat'";

                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $formatted_total = 'Rp ' . number_format($row["total_inv_ecat"], 0, '', '.');
                        echo '
                        ';
                        // Fungsi konversi angka menjadi terbilang
                        function terbilang($angka) {
                            $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
                            if ($angka < 12) {
                                return $bilangan[$angka];
                            } elseif ($angka < 20) {
                                return $bilangan[$angka - 10] . ' Belas';
                            } elseif ($angka < 100) {
                                return $bilangan[floor($angka / 10)] . ' Puluh ' . $bilangan[$angka % 10];
                            } elseif ($angka < 200) {
                                return 'Seratus ' . terbilang($angka - 100);
                            } elseif ($angka < 1000) {
                                return terbilang(floor($angka / 100)) . ' Ratus ' . terbilang($angka % 100);
                            } elseif ($angka < 2000) {
                                return 'Seribu ' . terbilang($angka - 1000);
                            } elseif ($angka < 1000000) {
                                return terbilang(floor($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
                            } elseif ($angka < 1000000000) {
                                return terbilang(floor($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000);
                            } elseif ($angka < 1000000000000) {
                                return terbilang(floor($angka / 1000000000)) . ' Milyar ' . terbilang($angka % 1000000000);
                            } elseif ($angka < 1000000000000000) {
                                return terbilang(floor($angka / 1000000000000)) . ' Trilyun ' . terbilang($angka % 1000000000000);
                            }
                }

                    $total_terbilang = terbilang((int)$row["total_inv_ecat"]);
                    }                                      
                    } else {
                    echo "Tidak ada data yang ditemukan";
                    }

                    mysqli_close($koneksi);
                ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%; text-align: center;">No</th>
                        <th scope="col" style="width: 50%; text-align: center;">Nama Produk</th>
                        <th scope="col" style="width: 15%; text-align: center;">Qty</th>
                        <th scope="col" style="width: 15%; text-align: center;">Harga</th>
                        <th scope="col" style="width: 15%; text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include "koneksi.php";
                        // Query untuk mengambil data dari tabel tb_customer
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
                        $grand_total = 0; // Inisialisasi grand total
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<th scope='row' style='text-align: center;'>" . $no++ . "</th>";
                            echo "<td style='text-align: left;'>" . $row['nama_produk'] . "</td>"; 
                            echo "<td style='text-align: center;'>" . $row['qty'] . "</td>";  
                            echo "<td style='text-align: center;'>" . number_format($row['harga'], 0, ',', '.') . "</td>";
                            echo "<td style='text-align: right;'>" . number_format($row['total_harga'], 0, ',', '.') . "</td>"; 
                            echo "</tr>";
                            
                            // Akumulasi grand total
                            $grand_total += $row['total_harga'];
                        }
                        // Menampilkan baris grand total
                        echo "<tr>";
                        echo "<th colspan='4' style='text-align:right;'>Grand Total :</th>";
                        echo "<td style='text-align:right;'><strong>Rp " . number_format($grand_total, 0, ',', '.') . "</strong></td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th colspan='5' style='text-align:center; padding-left: 10px;'>\"$total_terbilang Rupiah\"</th>";
                        echo "</tr>";

                        mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
            </div>
            <br><br><br>
            <div class="info-box-metode">
                <p><strong>Metode Pembayaran :</strong></p>
                <p>- Transfer Bank BCA</p>
                <p>- No. Rek : 086468867</p>
                <p>- Atas Nama : Lasino</p>
            </div>
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
