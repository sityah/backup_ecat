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

        if (isset($_POST["edit-produk"])) {
            $id_transaksi_ecat = $_POST['id_transaksi_ecat'];
            $nama = $_POST['nama_produk_spk'];
            $harga = $_POST['harga'];
            $id_inv_ecat = $_POST['id_inv_ecat'];

            $query = "SELECT * FROM transaksi_produk_ecat WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_array($result);

            $harga = preg_replace("/[^0-9]/", "", $harga);

            $update = mysqli_query($koneksi, "UPDATE transaksi_produk_ecat 
                        SET
                        nama_produk_spk  = '$nama',
                        harga  = '$harga'
                        WHERE id_transaksi_ecat='$id_transaksi_ecat'");

            if ($update) {
                $qty = $data_lama['qty'];

                $total_harga_baru = $harga * $qty;

                $update_total_harga = mysqli_query($koneksi, "UPDATE transaksi_produk_ecat 
                                                            SET total_harga = '$total_harga_baru' 
                                                            WHERE id_transaksi_ecat='$id_transaksi_ecat'");

                // Mengambil total harga dari transaksi_produk_pl berdasarkan id_inv_pl
                $query_total_harga = "SELECT SUM(total_harga) AS total_harga FROM transaksi_produk_ecat WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
                $result_total_harga = mysqli_query($koneksi, $query_total_harga);
                $data_total_harga = mysqli_fetch_array($result_total_harga);
                $total_harga_ecat = $data_total_harga['total_harga'];

                // Update total_spk_pl di tb_spk_pl berdasarkan id_inv_pl
                $update_total_spk_ecat = mysqli_query($koneksi, "UPDATE tb_spk_ecat SET total_spk_ecat = '$total_harga_ecat' WHERE id_inv_ecat = '$id_inv_ecat'");

                if ($update_total_spk_ecat) {
                    echo "<script>
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data produk berhasil diperbarui',
                                icon: 'success'
                            }).then(function() {
                                // Setelah pesan dikonfirmasi, arahkan pengguna ke halaman details_invoice_ecat.php
                                window.location.href = '../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat';
                            });
                        </script>";
                    exit();
                } else {
                    header("Location: ../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat&error=gagal_update_total_harga");
                    exit();
                }
            } else {
                header("Location: ../details_invoice_ecat.php?id_inv_ecat=$id_inv_ecat&error=gagal_update_harga");
                exit();
            }
        }
    ?>
</body>
</html>
    