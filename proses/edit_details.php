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

        if(isset($_POST['edit-produk'])) { 
            $spkId = $_POST['id_spk_ecat'];
            $tgl_spk_ecat = $_POST['tgl_spk_ecat'];
            $id_sales = $_POST['id_sales'];
            $fee_marketing = $_POST['fee_marketing'];

            $query_update = "UPDATE tb_spk_ecat SET tgl_spk_ecat = '$tgl_spk_ecat', id_sales = '$id_sales', fee_marketing = '$fee_marketing' WHERE id_spk_ecat = '$spkId'";
            
            // Eksekusi query
            $result_update = mysqli_query($koneksi, $query_update);

            if($result_update) {
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Berhasil Mengedit!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location='../detail_produk_spk_siap_kirim.php?id_spk_ecat=$spkId';
                            }
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal Mengedit Data!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location='../detail_produk_spk_siap_kirim.php?id_spk_ecat=$spkId';
                            }
                        });
                      </script>";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
        }
    ?>
</body>
</html>
    
