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

        if (isset($_POST["edit-qty"])) {
            $id_tmp_ecat = $_POST['id_tmp_ecat'];
            $qty = $_POST['qty'];

            // Mengambil data lama dari database
            $query = "SELECT * FROM tmp_produk_spk_ecat WHERE id_tmp_ecat = '$id_tmp_ecat'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_array($result);

            // Gunakan operator SET dengan benar di dalam query UPDATE
            $update = mysqli_query($koneksi, "UPDATE tmp_produk_spk_ecat 
                SET
                qty  = '$qty'
                WHERE id_tmp_ecat='$id_tmp_ecat'");

            if ($update) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../detail_produk_spk.php?id_spk_ecat=' . $data_lama['id_spk_ecat'] . '";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../detail_produk_spk.php?id_spk_ecat=' . $data_lama['id_spk_ecat'] . '";
                        });
                    </script>';
            }
        }

        // Delete
        elseif (isset($_POST["delete-produk"])) {
            // Periksa apakah ID produk dan nama produk telah diterima
            if(isset($_POST['id_tmp_ecat']) && isset($_POST['nama_produk'])) {
                $id_tmp_ecat = $_POST['id_tmp_ecat'];
                $nama_produk = $_POST['nama_produk'];

                // Mengambil data lama dari database
                $query = "SELECT * FROM tmp_produk_spk_ecat WHERE id_tmp_ecat = '$id_tmp_ecat'";
                $result = mysqli_query($koneksi, $query);
                $data_lama = mysqli_fetch_array($result);
    
                // Lakukan query untuk menghapus data
                $delete = mysqli_query($koneksi, "DELETE FROM tmp_produk_spk_ecat WHERE id_tmp_ecat = '$id_tmp_ecat'");
    
                if ($delete) {
                    echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Produk ' . $nama_produk . ' berhasil dihapus!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../detail_produk_spk.php?id_spk_ecat=' . $data_lama['id_spk_ecat'] . '";
                                });
                            </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../detail_produk_spk.php?id_spk_ecat=' . $data_lama['id_spk_ecat'] . '";
                            });
                        </script>';
                }
            } else {
                echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "ID produk atau nama produk tidak ditemukan!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../detail_produk_spk.php?id_spk_ecat=' . $data_lama['id_spk_ecat'] . '";
                            });
                        </script>';
            }
        }
    ?>
</body>
</html>
