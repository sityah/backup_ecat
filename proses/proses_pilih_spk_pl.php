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
        include "../koneksi.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['spk_data']) && !empty($_POST['spk_data'])) {
                $spk_data = $_POST['spk_data'];

                foreach($spk_data as $spk) {
                    $id_sales = $spk['id_sales'];
                    $id_spk_pl = $spk['id_spk_pl'];
                    $id_inv_pl = $spk['id_inv_pl'];

                    // Update data di tb_spk_ecat
                    $query_update = "UPDATE tb_spk_pl 
                                    SET id_inv_pl = '$id_inv_pl', status_spk_pl = 'Invoice Dibuat'
                                    WHERE id_spk_pl = '$id_spk_pl' AND status_spk_pl = 'Siap Kirim'";
                    $result_update = mysqli_query($koneksi, $query_update);

                }
            } else {
                echo "Tidak ada data SPK yang dikirim.";
            }
        } else {
            echo "Metode permintaan tidak valid.";
        }

        mysqli_close($koneksi);
    ?>
</body>
</html>