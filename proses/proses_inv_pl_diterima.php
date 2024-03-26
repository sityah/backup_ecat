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

        // Memastikan bahwa metode yang digunakan adalah POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Mendapatkan data dari form
            $id_inv_pl = $_POST['id_inv_pl'];

            $update = mysqli_query($koneksi, "UPDATE inv_pl SET status_transaksi = 'Diterima' WHERE id_inv_pl = '$id_inv_pl'");

            // Menutup koneksi
            mysqli_close($koneksi);

            if ($update) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Pesanan Diterima!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../spk_pl_dikirim.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal melakukan Ubah Status!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../spk_pl_dikirim.php";
                        });
                    </script>';
            }

        }
    ?>
</body>
</html>
