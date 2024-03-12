<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KWITANSI</title>
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
        width: 100%;
        float: left;
    }
    .right-column {
        width: 40%;
        float: right;
        text-align: right;
    }
    th, td {
        border: 1px solid #000;
        padding: 5px; 
        text-align: left;
    }
    .info-box {
        border: 1px solid #000; 
        padding: 4px; 
        display: inline-block; 
        margin-bottom: 20px;
        border-radius: 3px;
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
                <h1>KWITANSI</h1>
                <div class="info-box">
                    <?php
                        include "koneksi.php";

                        if (isset($_GET['id_inv_ecat'])) {
                            $id_inv_ecat = $_GET['id_inv_ecat'];

                            $sql = "SELECT
                                        inv_ecat.no_inv_ecat
                                    FROM
                                        inv_ecat
                                    WHERE
                                        inv_ecat.id_inv_ecat = '$id_inv_ecat'";

                            $result = mysqli_query($koneksi, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo '<p>No. : ' . $row["no_inv_ecat"] . '</p>';
                            } else {
                                echo "Tidak ada data yang ditemukan";
                            }
                        }

                        mysqli_close($koneksi);
                    ?>
                </div>
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
                        <div class="left-column" style="line-height: 0.1; margin-bottom: 5px;">
                            <table style="border: none; width: 100%; font-size: 14px;">
                                <tbody>
                                    <tr>
                                        <td style="width: 150px; vertical-align: top; border: none;">
                                            <p><strong>Sudah Terima Dari</strong></p>
                                        </td>
                                        <td style="border: none; padding: 2px 10px 2px 0;">:</td>
                                        <td style="border: 1px solid #000; padding: 13px 13px 13px 0; width: 530px; vertical-align: top;">
                                            <?php echo $row["alamat_perusahaan"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px; vertical-align: top; border: none;">
                                            <p><strong>Alamat</strong></p>
                                        </td>
                                        <td style="border: none; padding: 2px 10px 2px 0;">:</td>
                                        <td style="border: 1px solid #000; padding: 13px 13px 13px 0; width: 530px; vertical-align: top;">
                                            <?php echo $row["alamat_perusahaan"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px; vertical-align: top; border: none;">
                                            <p><strong>Sebesar</strong></p>
                                        </td>
                                        <td style="border: none; padding: 2px 10px 2px 0;">:</td>
                                        <td style="border: 1px solid #000; padding: 13px 13px 13px 0; width: 530px; vertical-align: top;">
                                            <?php echo $row["alamat_perusahaan"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px; vertical-align: top; border: none;">
                                            <p><strong>Untuk Pembayaran</strong></p>
                                        </td>
                                        <td style="border: none; padding: 2px 10px 2px 0;">:</td>
                                        <td style="border: 1px solid #000; padding: 13px 13px 13px 0; width: 530px; vertical-align: top;">
                                            <?php echo $row["alamat_perusahaan"]; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
                    }            
                    } else {
                    echo "Tidak ada data yang ditemukan";
                    }

                    mysqli_close($koneksi);
                ?>
            </div>
            <div>
            </div>
            <?php
                include "koneksi.php";

                if (isset($_GET['id_inv_ecat'])) {
                    $id_inv_ecat = $_GET['id_inv_ecat'];

                    $sql = "SELECT
                                inv_ecat.total_inv_ecat
                            FROM
                                inv_ecat
                            WHERE
                                inv_ecat.id_inv_ecat = '$id_inv_ecat'";

                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        // Format nilai uang dengan Rupiah
                        $formatted_total_inv_ecat = "Rp" . number_format($row["total_inv_ecat"], 0, ",", ".") . ",-";
                        // Output nilai uang dalam format tabel yang diminta
                        echo '<div style="float: left; margin-left: 100px;">
                                <table style="width: 160px; height: 60px; margin-top: 30px; font-size: 18px; border-radius: 5px; border: 1px solid black;">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;"><strong>' . $formatted_total_inv_ecat . '</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>';
                    } else {
                        echo "Tidak ada data yang ditemukan";
                    }
                }

                mysqli_close($koneksi);
            ?>
            <div style="float: right; margin-right: 70px;">
                <table style="width: 100%; border: none; margin-top: 30px;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 33%; text-align: right; border: none; vertical-align: top;">Diterima oleh,</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: right; height: 100px; border: none;">____________</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
