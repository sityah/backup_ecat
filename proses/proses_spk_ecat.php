<?php
    session_start();
    include "../koneksi.php";

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["simpan"])) {
            $id_spk_ecat = $_POST['id_spk_ecat'];
            $id_sales = $_POST['id_sales'];
            $id_perusahaan_ecat = $_POST['id_perusahaan'];
            $id_user = $_POST['id_user'];
            $no_spk_ecat = $_POST['no_spk_ecat'];
            $tgl_spk_ecat = $_POST['tgl_spk_ecat']; 
            $no_paket = $_POST['no_paket'];
            $nama_paket = $_POST['nama_paket'];
            $tgl_pesanan_ecat = $_POST['tgl_pesanan_ecat'];
            $fee_marketing = $_POST['fee_marketing'];
            $notes = $_POST['notes'];

            // Menghapus folder yang terbuat sebelumnya
            $path = "SPK/" . $id_spk_ecat;
            if (is_dir($path)) {
                rmdir($path);
            }

            // Membuat folder baru
            mkdir($path, 0777, true);

            $query_insert = "INSERT INTO tb_spk_ecat
                                (id_spk_ecat, id_sales, id_perusahaan, id_user, no_spk_ecat, tgl_spk_ecat, no_paket, nama_paket, tgl_pesanan_ecat, fee_marketing, notes) 
                                VALUES ('$id_spk_ecat', '$id_sales', '$id_perusahaan_ecat', '$id_user', '$no_spk_ecat', '$tgl_spk_ecat', '$no_paket', '$nama_paket', '$tgl_pesanan_ecat', '$fee_marketing', '$notes')";

            $result_insert = mysqli_query($koneksi, $query_insert);

            if ($result_insert) {
                $query_update_status = "UPDATE tb_spk_ecat SET status_spk_ecat = 'Belum Diproses' WHERE id_spk_ecat = '$id_spk_ecat'";
                mysqli_query($koneksi, $query_update_status);

                // Redirect back to data_spk.php
                header("Location: ../data_spk.php");
                exit();
            } else {
                // Redirect back to data_spk.php with error flag
                header("Location: ../data_spk.php?error=insert_failed");
                exit();
            }
        }
    }

    // If somehow the script reaches here without processing the form, redirect back to data_spk.php
    header("Location: ../data_spk.php");
    exit();
?>
