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
            $id_transaksi_ecat_array = $_POST['id_transaksi_ecat'];
            $new_nama_produk_array = $_POST['nama_produk'];
            $new_harga_produk_array = $_POST['harga_produk']; 
            $id_inv_ecat = $_POST['id_inv_ecat'];
            $id_spk_ecat = $_POST['id_spk'];

            $success = true;

            for ($i = 0; $i < count($id_transaksi_ecat_array); $i++) {
                $id_transaksi_ecat = mysqli_real_escape_string($koneksi, $id_transaksi_ecat_array[$i]);
                $new_nama_produk = mysqli_real_escape_string($koneksi, $new_nama_produk_array[$i]);
                $new_harga_produk = mysqli_real_escape_string($koneksi, str_replace(',', '', $new_harga_produk_array[$i]));
                $new_harga_produk = intval($new_harga_produk);

                // Query SQL untuk mengambil qty dari transaksi_produk_ecat
                $query_qty = "SELECT qty FROM transaksi_produk_ecat WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
                $result_qty = mysqli_query($koneksi, $query_qty);
                $row_qty = mysqli_fetch_assoc($result_qty);
                $qty = $row_qty['qty'];

                // Update nama produk dan harga produk
                $query_update = "UPDATE transaksi_produk_ecat 
                SET nama_produk_spk = '$new_nama_produk', harga = '$new_harga_produk', status_trx = 1
                WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
                $result_update = mysqli_query($koneksi, $query_update);

                if (!$result_update) {
                    $success = false;
                    echo "Terjadi kesalahan saat memperbarui data produk dengan ID transaksi $id_transaksi_ecat: " . mysqli_error($koneksi);
                    exit(); 
                }

                // Mengupdate total harga (harga * qty)
                $total_harga = $new_harga_produk * $qty;
                $query_update_total_harga = "UPDATE transaksi_produk_ecat 
                                            SET total_harga = '$total_harga' 
                                            WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
                $result_update_total_harga = mysqli_query($koneksi, $query_update_total_harga);

                // Mengambil total harga dari transaksi_produk_ecat untuk id_inv_ecat tertentu
                $query_total_harga_ecat = "SELECT SUM(total_harga) AS total_harga_ecat FROM transaksi_produk_ecat WHERE id_spk = '$id_spk_ecat'";
                $result_total_harga_ecat = mysqli_query($koneksi, $query_total_harga_ecat);
                $row_total_harga_ecat = mysqli_fetch_assoc($result_total_harga_ecat);
                $total_harga_ecat = $row_total_harga_ecat['total_harga_ecat'];

                // Update total_spk_ecat di tb_spk_ecat
                $query_update_total_spk_ecat = "UPDATE tb_spk_ecat AS spk
                                                SET spk.total_spk_ecat = (SELECT IFNULL(SUM(tp.total_harga), 0) FROM transaksi_produk_ecat AS tp WHERE tp.id_spk = spk.id_spk_ecat)
                                                WHERE spk.id_inv_ecat = '$id_inv_ecat'";
                $result_update_total_spk_ecat = mysqli_query($koneksi, $query_update_total_spk_ecat);

                if (!$result_update_total_spk_ecat) {
                    $success = false;
                    echo "Terjadi kesalahan saat memperbarui total_spk_ecat di tb_spk_ecat: " . mysqli_error($koneksi);
                    exit();
                }
            }

            if ($success) {
                echo "<script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data produk berhasil diperbarui',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat';
                            }
                        });
                    </script>";
            }
        } else {
            echo "Metode permintaan tidak valid.";
        }

        mysqli_close($koneksi);
    ?>
</body>
</html>
    
