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

        if(isset($_POST['edit-tgl'])) {
            $tgl_inv_ecat = $_POST['tgl_inv_ecat'];
            $id_inv_ecat = $_POST['id_inv_ecat'];

            // Update tgl_inv_ecat di tabel inv_ecat
            $query_update_inv_ecat = "UPDATE inv_ecat SET tgl_inv_ecat = '$tgl_inv_ecat' WHERE id_inv_ecat = '$id_inv_ecat'";
            
            // Eksekusi query untuk mengupdate tgl_inv_ecat di tabel inv_ecat
            $result_update_inv_ecat = mysqli_query($koneksi, $query_update_inv_ecat);

            if($result_update_inv_ecat) {
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Berhasil Mengedit Tanggal!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location='../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat';
                            }
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal Mengedit Tanggal!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location='../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat';
                            }
                        });
                      </script>";
            }
        }
    ?>
</body>
</html>
    
