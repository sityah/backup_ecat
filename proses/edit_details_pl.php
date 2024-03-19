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
            $id_spk_pl = $_POST['id_spk_pl'];
            $tgl_spk_pl = $_POST['tgl_spk_pl'];
            $id_sales = $_POST['id_sales'];
            $fee_marketing = $_POST['fee_marketing'];

            $query_update = "UPDATE tb_spk_pl SET tgl_spk_pl = '$tgl_spk_pl', id_sales = '$id_sales', fee_marketing = '$fee_marketing' WHERE id_spk_pl = '$id_spk_pl'";
            
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
                                window.location='../detail_produk_spk_pl_siap_kirim.php?id_spk_pl=$id_spk_pl';
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
                                window.location='../detail_produk_spk_pl_siap_kirim.php?id_spk_pl=$id_spk_pl';
                            }
                        });
                      </script>";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
        }

        if(isset($_POST['edit-tgl'])) {
            $tgl_inv_pl = $_POST['tgl_inv_pl'];
            $id_inv_pl = $_POST['id_inv_pl'];

            // Update tgl_inv_pl di tabel inv_pl
            $query_update_inv_pl = "UPDATE inv_pl SET tgl_inv_pl = '$tgl_inv_pl' WHERE id_inv_pl = '$id_inv_pl'";
            
            // Eksekusi query untuk mengupdate tgl_inv_pl di tabel inv_pl
            $result_update_inv_pl = mysqli_query($koneksi, $query_update_inv_pl);

            if($result_update_inv_pl) {
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Berhasil Mengedit Tanggal!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location='../details_invoice_pl.php?id_inv_pl=$id_inv_pl';
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
                                window.location='../details_invoice_pl.php?id_inv_pl=$id_inv_pl';
                            }
                        });
                      </script>";
            }
        }
    ?>
</body>
</html>
    
