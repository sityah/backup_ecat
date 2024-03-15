<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include "../koneksi.php";

        // Tangkap data yang dikirimkan dari form
        $id_inv_pl = $_POST['id_inv_ecat'];
        $jenis_ongkir = $_POST['jenis_ongkir'];
        $no_resi = $_POST['no_resi'];
        $ongkir = $_POST['ongkir'];

        // Check if file is uploaded successfully
        if(isset($_FILES['bukti_terima']) && $_FILES['bukti_terima']['error'] === UPLOAD_ERR_OK) {
            $nama_file = $_FILES['bukti_terima']['name']; 
            $file_tmp = $_FILES['bukti_terima']['tmp_name']; 

            $uuid = uniqid();
            $hari = date('d');
            $tahun = date('y');
            $BKTuuid = "BKT$uuid$hari$tahun";

            // Proses upload bukti terima ke direktori
            $target_dir = "../uploads/";
            $extension = pathinfo($nama_file, PATHINFO_EXTENSION); 
            $new_filename = $id_inv_pl . '.' . $extension; 
            $target_file = $target_dir . $new_filename;

            if(move_uploaded_file($file_tmp, $target_file)) {
                // Baca isi file yang diunggah
                $file_content = file_get_contents($target_file);
                $file_content = mysqli_real_escape_string($koneksi, $file_content); 

                // Update tabel status_kirim
                $update_status_kirim_query = "UPDATE status_kirim SET jenis_ongkir = '$jenis_ongkir', no_resi = '$no_resi' WHERE id_inv_ecat = '$id_inv_pl'";
                mysqli_query($koneksi, $update_status_kirim_query);

                // Insert data ke tabel inv_bukti_terima
                $created_date = date('Y-m-d H:i:s'); 
                $insert_bukti_terima_query = "INSERT INTO inv_bukti_terima (id_bukti_terima, id_inv_ecat, bukti_terima, created_date) VALUES ('$BKTuuid', '$id_inv_pl', '$file_content', '$created_date')";
                mysqli_query($koneksi, $insert_bukti_terima_query);

                // Update tabel inv_ecat
                $ongkir = preg_replace("/[^0-9]/", "", $ongkir);
                $update_inv_ecat_query = "UPDATE inv_pl SET ongkir = '$ongkir' WHERE id_inv_pl = '$id_inv_pl'";
                mysqli_query($koneksi, $update_inv_ecat_query);

                // Tutup koneksi database
                mysqli_close($koneksi);

                // Redirect kembali ke halaman sebelumnya atau halaman sukses
                header("Location: ../details_pl_dikirim.php?id_inv_pl=$id_inv_pl");
                exit(); 
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File upload failed with error code: " . $_FILES['bukti_terima']['error'];
        }
    ?>
</body>
</html>
