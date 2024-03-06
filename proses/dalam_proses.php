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

        if (isset($_POST["delete-produk"])) {
            // Periksa apakah ID produk dan nama produk telah diterima
            if(isset($_POST['id_transaksi_ecat']) && isset($_POST['nama_produk'])) {
                // Ambil ID produk dan nama produk dari formulir
                $id_transaksi_ecat = $_POST['id_transaksi_ecat'];
                $nama_produk = $_POST['nama_produk'];

                // Mengambil data lama dari database
                $query = "SELECT * FROM transaksi_produk_ecat WHERE id_transaksi_ecat = '$id_transaksi_ecat'";
                $result = mysqli_query($koneksi, $query);
                $data_lama = mysqli_fetch_array($result);
        
                // Lakukan query untuk menghapus data
                $delete = mysqli_query($koneksi, "DELETE FROM transaksi_produk_ecat WHERE id_transaksi_ecat = '$id_transaksi_ecat'");
        
                // Periksa apakah query penghapusan berhasil
                if ($delete) {
                    // Jika berhasil, tampilkan pesan sukses dengan menggunakan nama produk
                    echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Produk ' . $nama_produk . ' berhasil dihapus!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../detail_produk_spk_dalam_proses.php?id_spk_ecat=' . $data_lama['id_spk'] . '";
                                });
                            </script>';
                } else {
                    // Jika gagal, tampilkan pesan kesalahan
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../detail_produk_spk_dalam_proses.php?id_spk_ecat=' . $data_lama['id_spk'] . '";
                            });
                        </script>';
                }
            } 
        }
    ?>
</body>
</html>
