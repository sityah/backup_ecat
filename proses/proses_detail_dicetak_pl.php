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
            $id_transaksi_pl_array = $_POST['id_transaksi_pl'];
            $new_nama_produk_array = $_POST['nama_produk'];
            $new_harga_produk_array = $_POST['harga_produk']; 
            $id_inv_pl = $_POST['id_inv_pl'];

            $success = true;

            for ($i = 0; $i < count($id_transaksi_pl_array); $i++) {
                $id_transaksi_pl = mysqli_real_escape_string($koneksi, $id_transaksi_pl_array[$i]);
                $new_nama_produk = mysqli_real_escape_string($koneksi, $new_nama_produk_array[$i]);
                $new_harga_produk = mysqli_real_escape_string($koneksi, str_replace(',', '', $new_harga_produk_array[$i]));
                $new_harga_produk = intval($new_harga_produk);

                // Query SQL untuk mengambil qty dari transaksi_produk_ecat
                $query_qty = "SELECT qty FROM transaksi_produk_pl WHERE id_transaksi_pl = '$id_transaksi_pl'";
                $result_qty = mysqli_query($koneksi, $query_qty);
                $row_qty = mysqli_fetch_assoc($result_qty);
                $qty = $row_qty['qty'];

                // Update nama produk dan harga produk
                $query_update = "UPDATE transaksi_produk_pl 
                SET nama_produk_spk = '$new_nama_produk', harga = '$new_harga_produk', status_trx = 1
                WHERE id_transaksi_pl = '$id_transaksi_pl'";
                $result_update = mysqli_query($koneksi, $query_update);

                if (!$result_update) {
                    $success = false;
                    echo "Terjadi kesalahan saat memperbarui data produk dengan ID transaksi $id_transaksi_pl: " . mysqli_error($koneksi);
                    exit(); 
                }

                // Mengupdate total harga (harga * qty)
                $total_harga = $new_harga_produk * $qty;
                $query_update_total_harga = "UPDATE transaksi_produk_pl 
                                            SET total_harga = '$total_harga' 
                                            WHERE id_transaksi_pl = '$id_transaksi_pl'";
                $result_update_total_harga = mysqli_query($koneksi, $query_update_total_harga);

                // Mengambil total harga dari transaksi_produk_pl untuk id_inv_pl tertentu
                $query_total_harga_pl = "SELECT SUM(total_harga) AS total_harga_pl FROM transaksi_produk_pl WHERE id_transaksi_pl = '$id_transaksi_pl'";
                $result_total_harga_pl = mysqli_query($koneksi, $query_total_harga_pl);
                $row_total_harga_pl = mysqli_fetch_assoc($result_total_harga_pl);
                $total_harga_pl = $row_total_harga_pl['total_harga_pl'];

                // Update total_spk_pl di tb_spk_pl
                $query_update_total_spk_pl = "UPDATE tb_spk_pl SET total_spk_pl = '$total_harga_pl' WHERE id_inv_pl = '$id_inv_pl'";
                $result_update_total_spk_pl = mysqli_query($koneksi, $query_update_total_spk_pl);

                if (!$result_update_total_spk_pl) {
                    $success = false;
                    echo "Terjadi kesalahan saat memperbarui total_spk_pl di tb_spk_pl: " . mysqli_error($koneksi);
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
                                window.location.href = '../details_invoice_pl.php?id_inv_pl=$id_inv_pl';
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
    
