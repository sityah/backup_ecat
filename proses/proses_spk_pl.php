<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
        session_start();
        include "../koneksi.php";

        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST["simpan"])) {
                $id_spk_pl = $_POST['id_spk_pl'];
                $id_perusahaan_pl = $_POST['id_perusahaan'];
                $id_sales = $_POST['id_sales'];
                $id_user = $_POST['id_user'];
                $no_spk_pl = $_POST['no_spk_pl'];
                $tgl_spk_pl = $_POST['tgl_spk_pl']; 
                $no_po = $_POST['no_po'];
                $tgl_po = $_POST['tgl_po'];
                $tgl_pesanan_pl = $_POST['tgl_pesanan_pl'];
                $fee_marketing = $_POST['fee_marketing'];
                $notes = $_POST['notes'];

                // Menghapus folder yang terbuat sebelumnya
                $path = "SPK/" . $id_spk_pl;
                if (is_dir($path)) {
                    rmdir($path);
                }

                // Membuat folder baru
                mkdir($path, 0777, true);

                $query_insert = "INSERT INTO tb_spk_pl
                                    (id_spk_pl, id_sales, id_perusahaan, id_user, no_spk_pl, tgl_spk_pl, no_po, tgl_pesanan_pl, fee_marketing, notes) 
                                    VALUES ('$id_spk_pl', '$id_sales', '$id_perusahaan_pl', '$id_user', '$no_spk_pl', '$tgl_spk_pl', '$no_po', '$tgl_pesanan_pl', '$fee_marketing', '$notes')";

                $result_insert = mysqli_query($koneksi, $query_insert);

                if ($result_insert) {
                    $query_update_status = "UPDATE tb_spk_pl SET status_spk_pl = 'Belum Diproses' WHERE id_spk_pl = '$id_spk_pl'";
                    mysqli_query($koneksi, $query_update_status);

                    // Redirect back to data_spk.php
                    header("Location: ../data_spk_pl.php");
                    exit();
                } else {
                    // Redirect back to data_spk.php with error flag
                    header("Location: ../data_spk_pl.php?error=insert_failed");
                    exit();
                }
            }
        }
        mysqli_close($koneksi);
    ?>
</body>
</html>