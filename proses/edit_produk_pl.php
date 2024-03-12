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
            $id_transaksi_pl = $_POST['id_transaksi_pl'];
            $nama = $_POST['nama_produk_spk'];
            $harga = $_POST['harga'];
            $id_inv_pl = $_POST['id_inv_pl'];
            $id_spk_pl = $_POST['id_spk'];

            $query = "SELECT * FROM transaksi_produk_pl WHERE id_transaksi_pl = '$id_transaksi_pl'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_array($result);

            $harga = preg_replace("/[^0-9]/", "", $harga);

            $update = mysqli_query($koneksi, "UPDATE transaksi_produk_pl 
                        SET
                        nama_produk_spk  = '$nama',
                        harga  = '$harga'
                        WHERE id_transaksi_pl='$id_transaksi_pl'");

            if ($update) {
                $qty = $data_lama['qty'];

                $total_harga_baru = $harga * $qty;

                $update_total_harga = mysqli_query($koneksi, "UPDATE transaksi_produk_pl 
                                                            SET total_harga = '$total_harga_baru' 
                                                            WHERE id_transaksi_pl='$id_transaksi_pl'");

                // Mengambil total harga dari transaksi_produk_pl berdasarkan id_inv_pl
                $query_total_harga = "SELECT SUM(total_harga) AS total_harga FROM transaksi_produk_pl WHERE id_spk = '$id_spk_pl'";
                $result_total_harga = mysqli_query($koneksi, $query_total_harga);
                $data_total_harga = mysqli_fetch_array($result_total_harga);
                $total_harga_pl = $data_total_harga['total_harga'];

                // Update total_spk_pl di tb_spk_pl berdasarkan id_inv_pl
                $update_total_spk_pl = mysqli_query($koneksi, "UPDATE tb_spk_pl AS spk
                                                                SET spk.total_spk_pl = (SELECT IFNULL(SUM(tp.total_harga), 0) FROM transaksi_produk_pl AS tp WHERE tp.id_spk = spk.id_spk_pl)
                                                                WHERE spk.id_inv_pl = '$id_inv_pl'");

                if ($update_total_spk_pl) {
                    echo "<script>
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data produk berhasil diperbarui',
                                icon: 'success'
                            }).then(function() {
                                // Setelah pesan dikonfirmasi, arahkan pengguna ke halaman details_invoice_ecat.php
                                window.location.href = '../details_invoice_pl.php?id_inv_pl=$id_inv_pl';
                            });
                        </script>";
                    exit();
                } else {
                    header("Location: ../details_invoice_pl.php?id_inv_pl=$id_inv_pl&error=gagal_update_total_spk_pl");
                    exit();
                }
        }
    }
    ?>
</body>
</html>
    