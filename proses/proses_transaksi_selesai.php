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
            $id_inv_ecat = $_POST['id_inv_ecat'];

            // Update status transaksi menjadi "Transaksi Selesai"
            $query = "UPDATE inv_ecat SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_ecat = '$id_inv_ecat'";
            $result = mysqli_query($koneksi, $query);

            // Menutup koneksi
            mysqli_close($koneksi);

            if ($result) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Transaksi Selesai!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../spk_diterima.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menyelesaikan transaksi!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../spk_diterima.php";
                        });
                    </script>';
            }
        }
    ?>
</body>
</html>

