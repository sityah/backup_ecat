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
        width: 100%;
        margin: auto;
    }
    .left-column-header-img {
        width: 70%;
        float: left;
        margin-bottom: 50px;
    }
    .right-column-header {
        width: 28%;
        float: right;
        text-align: center;
        margin-bottom: 22px;
        border: 1px solid #000; 
        padding: 10px; 
        box-sizing: border-box; 
    }
    .right-column-header h1 {
        font-size: 18px; 
        margin: 0; 
        display: inline-block; 
        border-bottom: 2px solid #000;
    }
    .right-column-header p {
        text-align: left; 
        margin: 3px 0; 
        font-size: 11px;
    }
    .left-column {
        width: 65%;
        float: left;
    }
    .right-column {
        width: 35%;
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
    }
    .info-box p {
        text-align: left; 
        margin: 5px;
    }
    .keterangan {
        border: 1px solid #000; 
        padding: 10px 10px 5px 10px; 
        text-align: justify;
    }
    .keterangan p {
        font-size: 12px; 
        margin: 3px 0;
    }
    .keterangan b {
        font-size: 13px;
        margin: 0; 
    }
    .signatures-container {
        display: flex;
        justify-content: left;
    }
    .signatures {
        width: 20%; 
        margin-right: 20px; 
        text-align: center; 
        margin-bottom: 30px; 
    }
</style>
</head>
<body>
    <div class="print-area">
        <div class="container">
            <img src="assets/img/header-kma.jpg" alt="Header" class="left-column-header-img">
            <div class="right-column-header">
                <h1>INVOICE</h1>
                <?php
                    include "koneksi.php";

                    $bulan = array(
                        "January" => "Januari",
                        "February" => "Februari",
                        "March" => "Maret",
                        "April" => "April",
                        "May" => "Mei",
                        "June" => "Juni",
                        "July" => "Juli",
                        "August" => "Agustus",
                        "September" => "September",
                        "October" => "Oktober",
                        "November" => "November",
                        "December" => "Desember"
                    );

                    if (isset($_GET['id_inv_ecat'])) {
                        $id_inv_ecat = $_GET['id_inv_ecat'];

                        $sql = "SELECT *
                                FROM 
                                    inv_ecat
                                WHERE 
                                    inv_ecat.id_inv_ecat = '$id_inv_ecat'";

                        $result = mysqli_query($koneksi, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            // Mengubah format tanggal
                            $tgl_inv_ecat = date_create($row['tgl_inv_ecat']);
                            $formatted_day = date_format($tgl_inv_ecat, "d");
                            $formatted_month = date_format($tgl_inv_ecat, "F");
                            $formatted_year = date_format($tgl_inv_ecat, "Y");
                            // Menggunakan array asosiatif untuk mengubah nama bulan ke bahasa Indonesia
                            $formatted_month_indonesia = $bulan[$formatted_month];
                            echo "<p>No. Invoice : " . $row['no_inv_ecat'] . "</p>";
                            echo "<p>Tgl. Invoice : " . $formatted_day . " " . $formatted_month_indonesia . " " . $formatted_year . "</p>";
                        } else {
                            echo "Tidak ada data yang ditemukan";
                        }
                    } else {
                        echo "Tidak ada data yang ditemukan";
                    }

                    mysqli_close($koneksi);
                ?>
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
                                tb_spk_ecat ON inv_ecat.id_inv_ecat = tb_spk_ecat.id_inv_ecat 
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
                            <div class="info-box">
                                <p><strong style="width: 75px; display: inline-block;">ID Paket</strong>: ' . $row["no_paket"] . '</p>
                                <p><strong style="width: 75px; display: inline-block;">Nama Paket</strong>: ' . $row["nama_paket"] . '</p>
                            </div>';
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
                        <th scope="col" style="width: 15%; text-align: center;">Harga</th>
                        <th scope="col" style="width: 15%; text-align: center;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        function terbilang($angka) {
                            $bilangan = array(
                                '',
                                'satu',
                                'dua',
                                'tiga',
                                'empat',
                                'lima',
                                'enam',
                                'tujuh',
                                'delapan',
                                'sembilan',
                                'sepuluh',
                                'sebelas'
                            );
                            if ($angka < 12) {
                                return $bilangan[$angka];
                            } elseif ($angka < 20) {
                                return terbilang($angka - 10) . ' belas';
                            } elseif ($angka < 100) {
                                return terbilang($angka / 10) . ' puluh ' . terbilang($angka % 10);
                            } elseif ($angka < 200) {
                                return ' seratus ' . terbilang($angka - 100);
                            } elseif ($angka < 1000) {
                                return terbilang($angka / 100) . ' ratus ' . terbilang($angka % 100);
                            } elseif ($angka < 2000) {
                                return ' seribu ' . terbilang($angka - 1000);
                            } elseif ($angka < 1000000) {
                                return terbilang($angka / 1000) . ' ribu ' . terbilang($angka % 1000);
                            } elseif ($angka < 1000000000) {
                                return terbilang($angka / 1000000) . ' juta ' . terbilang($angka % 1000000);
                            }
                        }

                        function capitalizeEachWord($str) {
                            return ucwords(strtolower($str));
                        }

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
                        echo "<th colspan='4' style='text-align:right;'>Sub Total </th>";
                        echo "<td style='text-align:right;'><strong>Rp " . number_format($grand_total, 0, ',', '.') . "</strong></td>";
                        echo "</tr>";

                        // Hitung PPN
                        $ppn = ($grand_total * 11) / 100;

                        echo "<tr>";
                        echo "<th colspan='4' style='text-align:right;'>PPN 11% </th>";
                        echo "<td style='text-align:right;'><strong>Rp " . number_format($ppn, 0, ',', '.') . "</strong></td>";
                        echo "</tr>";

                        // Hitung Total Faktur
                        $total_faktur = $grand_total + $ppn;

                        echo "<tr>";
                        echo "<th colspan='4' style='text-align:right;'>Total Faktur </th>";
                        echo "<td style='text-align:right;'><strong>Rp " . number_format($total_faktur, 0, ',', '.') . "</strong></td>";
                        echo "</tr>";

                        // Mengonversi total_faktur menjadi terbilang
                        $total_faktur_terbilang = capitalizeEachWord(terbilang($total_faktur));

                        echo "<tr>";
                        echo "<th colspan='5' style='text-align:center; padding-left: 10px;'>\"" . $total_faktur_terbilang . " Rupiah\"</th>";
                        echo "</tr>";

                        mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
            </div>
            <br>
            <div class="keterangan">
                <b style="font-size: 13px;">Keterangan :</b>
                <p>1. Barang tersebut diatas telah diterima dalam keadaan baik dan bagus.</p>
                <p>2. Barang tersebut di atas apabila dikembalikan/retur dalam keadaan baik dan berfungsi dalam waktu 7 hari terhitung dari tanggal penerimaan barang.</p>
                <p>3. Pembayaran :</p>
                <table style="width:100%; margin-bottom: 0;">
                    <tr>
                        <td style="width:50%; vertical-align: center; border: none;">
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">Nama Bank</strong><strong>: BANK MANDIRI</strong>
                            </p>
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">No. Rek</strong><strong>: 156 00 8888 993 8</strong>
                            </p>
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">Atas Nama</strong><strong>: PT. KARSA MANDIRI ALKESINDO</strong>
                            </p>
                        </td>
                        <td style="width:50%; vertical-align: center; border: none;">
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">Nama Bank</strong><strong>: BANK BCA</strong>
                            </p>
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">No. Rek</strong><strong>: 521 155 1888</strong>
                            </p>
                            <p style="margin-top: 0; margin-bottom: 0; padding: 1px; padding-left: 8px;">
                                <strong style="width: 80px; display: inline-block;">Atas Nama</strong><strong>: PT. KARSA MANDIRI ALKESINDO</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="signatures-container">
                <div class="signatures">
                    <p>Mengetahui :</p>
                    <div class="content-img-ttd text-right">
                        <br><br><br>
                    </div>
                    <div class="content-hormat text-left">
                        <b>H. Lasino</b>
                    </div>
                </div>
                <div class="signatures">
                    <p>Disetujui oleh :</p>
                    <div class="content-img-ttd text-right">
                        <br><br><br>
                    </div>
                    <div class="content-hormat text-left">
                        <b>Lisa Ayu F</b>
                    </div>
                </div>
                <div class="signatures">
                    <p>Diterima oleh :</p>
                    <div class="content-img-ttd text-right">
                        <br><br><br>
                    </div>
                    <div class="content-hormat text-left">
                        <b>________________</b><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
