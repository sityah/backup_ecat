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
                    $id_spk_ecat = $spk['id_spk_ecat'];
                    $id_inv_ecat = $spk['id_inv_ecat'];

                    // Update data di tb_spk_ecat
                    $query_update = "UPDATE tb_spk_ecat 
                                    SET id_inv_ecat = '$id_inv_ecat', status_spk_ecat = 'Invoice Dibuat'
                                    WHERE id_spk_ecat = '$id_spk_ecat' AND status_spk_ecat = 'Siap Kirim'";
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