<?php
include "koneksi.php";

// Pastikan id_spk_pl diset sebelum melakukan perubahan
if (isset($_GET['id_spk_pl'])) {
    $id_spk_pl = $_GET['id_spk_pl'];

    // Update status cetak menjadi 1
    $updateSql = "UPDATE tb_spk_pl SET status_cetak = 1 WHERE id_spk_pl = '$id_spk_pl'";
    mysqli_query($koneksi, $updateSql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SPK E-CATALOG</title>
<style>
    body {
        font-family: Times New Roman, serif;
        font-size: 14px; 
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
        text-align: center;
        margin-bottom: 40px;
        font-size: 11px;
    }
    .left-column {
        width: 60%;
        float: left;
    }
    .left-column p {
        margin: 0; 
    }
    .left-column p span {
        margin-right: 5px; 
    }
    .right-column {
        width: 40%;
        float: right;
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    th, td {
        border: 1px solid #000;
        padding: 4px; 
        text-align: left;
    }
    .signatures-container {
        display: flex;
        justify-content: center;
    }
    .signatures {
        width: 30%; 
        margin-right: 20px; 
        text-align: center; 
        margin-bottom: 20px; 
    }
    .top-buttons {
        text-align: center;
        margin-bottom: 20px; 
    }
    .top-buttons button {
        margin: 0 2px;
        box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.4); 
        padding: 8px 16px; 
        font-size: 14px; 
        border-radius: 5px; 
        border: none;
    }
    .top-buttons button:nth-child(1) {
        background-color: orange; 
        color: white; 
    }
    .top-buttons button:nth-child(2) {
        background-color: red; 
        color: white; 
    }
    @media print {
        .top-buttons {
            display: none;
        }
    }
</style>
</head>
<body>
    <div class="print-area">
        <div class="container">
            <div class="top-buttons">
                <button onclick="window.print()">Print</button>
                <button onclick="window.history.back()">Kembali</button>
            </div>
            <div class="header">
                <h1>SURAT PERINTAH KERJA</h1>
            </div>
            <div class="left-column" style="width: 60%; float: left;">
                <?php
                include "koneksi.php";

                if (isset($_GET['id_spk_pl'])) {
                    $id_spk_pl = $_GET['id_spk_pl'];

                    $query = "SELECT
                                tb_spk_pl.no_spk_pl,
                                tb_spk_pl.tgl_spk_pl,
                                tb_spk_pl.no_po,
                                tb_sales_ecat.nama_sales,
                                tb_perusahaan.nama_perusahaan
                            FROM
                                tb_spk_pl
                            JOIN
                                tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                            JOIN
                                tb_perusahaan ON tb_spk_pl.id_perusahaan = tb_perusahaan.id_perusahaan
                            WHERE
                                tb_spk_pl.id_spk_pl = '$id_spk_pl'";
                    $result = mysqli_query($koneksi, $query);

                    // Check if the query returned any rows
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        // Output the fetched values
                        echo '<table style="border: none; width: 100%; font-size: 13px;">
                                <tbody style="width: 100%;">
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 18%;">No. SPK</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 3%;">:</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 79%; vertical-align: top;">' .
                                        $row["no_spk_pl"].
                                    '</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 18%;">Tgl. SPK</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 3%;">:</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 79%; vertical-align: top;">' .
                                        $row["tgl_spk_pl"].
                                    '</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 18%;">ID Paket</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 3%;">:</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 79%; vertical-align: top;">' .
                                        $row["no_po"].
                                    '</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 18%;">Satker</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 3%;">:</td>
                                    <td style="border: none; padding: 2px 5px 2px 0; width: 79%; vertical-align: top;">' .
                                        $row["nama_perusahaan"].
                                    '</td>
                                </tr>
                            </tbody>
                            </table>';
                    } else {
                        echo "No data found for the specified SPK ID.";
                    }
                }
                ?>
            </div>
            <?php
                // Lokasi (misal: Bekasi)
                $lokasi = "Bekasi";

                // Tanggal (tgl_spk_pl)
                $tanggal = ""; // inisialisasi tanggal
                if (isset($_GET['id_spk_pl'])) {
                    $id_spk_pl = $_GET['id_spk_pl'];
                    $query = "SELECT tgl_spk_pl FROM tb_spk_pl WHERE id_spk_pl = '$id_spk_pl'";
                    $result = mysqli_query($koneksi, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $tanggal = $row["tgl_spk_pl"];
                    }
                }

                echo "<div class=\"right-column\">";
                echo "<p>$lokasi, $tanggal</p>";
                echo "</div>";
            ?>
            <table>
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%; text-align: center;">No</th>
                        <th scope="col" style="width: 50%; text-align: center;">Nama Produk</th>
                        <th scope="col" style="width: 15%; text-align: center;">Satuan</th>
                        <th scope="col" style="width: 15%; text-align: center;">Merk</th>
                        <th scope="col" style="width: 15%; text-align: center;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include "koneksi.php";
                        // Query untuk mengambil data dari tabel tb_customer
                        $query = "SELECT 
                                    sr.id_spk_pl,
                                    tps.id_tmp_pl,
                                    tps.id_produk_ecat,
                                    spr.stock, 
                                    tpr.nama_produk, 
                                    tpr.satuan,
                                    tps.qty,
                                    tps.status_tmp,
                                    tpr.harga_produk,
                                    tm.nama_merk  
                                FROM mandir36_db_ecat_staging.tmp_produk_spk_pl AS tps
                                LEFT JOIN mandir36_db_ecat_staging.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk_pl
                                LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                                LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                                LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                                WHERE sr.id_spk_pl = '$id_spk_pl' AND tps.status_tmp = 1";
                        $result = mysqli_query($koneksi, $query);

                        // Hasil query
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<th scope='row' style='text-align: center;'>" . $no++ . "</th>"; 
                            echo "<td style='text-align: left;'>" . $row['nama_produk'] . "</td>";
                            echo "<td style='text-align: center;'>" . $row['satuan'] . "</td>"; 
                            echo "<td style='text-align: center;'>" . $row['nama_merk'] . "</td>"; 
                            echo "<td style='text-align: center;'>" . $row['qty'] . "</td>";
                            echo "</tr>";
                        }                            
                        mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
            <div class="note">
            <?php
                include "koneksi.php";

                if (isset($_GET['id_spk_pl'])) {
                $id_spk_pl = $_GET['id_spk_pl'];

                $sql = "
                        SELECT
                        tb_spk_pl.notes
                    FROM
                        tb_spk_pl
                    WHERE
                        tb_spk_pl.id_spk_pl = '$id_spk_pl'

                ";

                $result = mysqli_query($koneksi, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo '
                        <div class="column">
                            <p><strong>Notes : ' . $row["notes"] . '</strong></p>
                        </div>
                    ';
                }
                } 

                mysqli_close($koneksi);
                ?>
            </div>
            <div class="signatures-container">
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
                <div class="signatures">
                    <div class="content-hormat text-left" style="border: 1px solid #000; padding: 10px; text-align: left; display: inline-block;">
                        <?php
                            include "koneksi.php";

                            if (isset($_GET['id_spk_pl'])) {
                                $id_spk_pl = $_GET['id_spk_pl'];

                                $sql = "SELECT petugas_pl FROM tb_spk_pl WHERE id_spk_pl = '$id_spk_pl'";
                                $result = mysqli_query($koneksi, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo 'Nama Petugas : ' . $row["petugas_pl"];
                                }
                            } 

                            mysqli_close($koneksi);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

