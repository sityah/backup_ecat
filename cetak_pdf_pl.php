<?php
include "koneksi.php";
use Dompdf\Dompdf;

// Pastikan id_spk_pl diset sebelum melakukan perubahan
if (isset($_GET['id_inv_pl'])) {
    $id_inv_pl = $_GET['id_inv_pl'];

    // Membuat file PDF
    require_once 'dompdf/autoload.inc.php';

    // Mulai dokumen PDF
    $dompdf = new Dompdf();
    ob_start(); // Mulai penangkapan output
?>
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
        width: 21cm;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 90%;
        margin: 0;
    }
    .header {
        text-align: right;
        margin-bottom: 20px;
    }
    .content-header {
        margin-bottom: 0;
    }
    .left-column {
        width: 60%;
        float: left;
    }
    .right-column {
        width: 40%;
        float: right;
        text-align: right;
        min-height: 200px;
    }
    .left-column-terbilang {
        width: 100%;
        float: left;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        margin-top: 130px;
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
        min-width: 280px;
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
    @media print {
    .print-btn, .back-btn {
        display: none !important;
    }
    }
</style>
</head>
<body>
    <div class="container flex-container">
        <div class="header">
            <h1>INVOICE</h1>
        </div>
        <div class="content-header">
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
                                <p><strong>Nama Sales : </strong>' . $row["nama_sales"] . '</p>
                                <p><strong>No. PO : </strong>' . $row["no_po"] . '</p>
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
        </div>
        <div>
        <div class="right-column">
            <?php
                include "koneksi.php";

                if (isset($_GET['id_inv_pl'])) {
                $id_inv_pl = $_GET['id_inv_pl'];

                $sql = "SELECT
                            inv_pl.total_inv_pl
                        FROM
                            inv_pl
                        LEFT JOIN
                            tb_spk_pl ON inv_pl.id_inv_pl = tb_spk_pl.id_inv_pl 
                        WHERE
                            inv_pl.id_inv_pl = '$id_inv_pl'";

                $result = mysqli_query($koneksi, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $formatted_total = 'Rp ' . number_format($row["total_inv_pl"], 0, '', '.');
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

                $total_terbilang = terbilang((int)$row["total_inv_pl"]);
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
</body>
</html>
<?php
    $html = ob_get_clean(); // Mengambil output dan membersihkannya dari buffer

    $dompdf->loadHtml($html); // Memuat HTML ke dalam dompdf
    $dompdf->setPaper('A4', 'portrait'); // Mengatur ukuran dan orientasi kertas
    $dompdf->render(); // Membuat PDF

    // Output PDF sebagai string
    $output = $dompdf->output();

    // Menyimpan PDF ke dalam file
    $pdfFilePath = "invoices/pl/invoice_$id_inv_pl.pdf"; // Path untuk menyimpan file PDF
    file_put_contents($pdfFilePath, $output);

    // Mengarahkan pengguna untuk mengunduh file PDF yang dihasilkan
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
    header('Content-Length: ' . filesize($pdfFilePath));
    readfile($pdfFilePath);

    // Setelah mengirimkan file, Anda bisa menghapusnya jika diinginkan
    unlink($pdfFilePath);
}
?>
