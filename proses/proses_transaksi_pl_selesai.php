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

            // Mendapatkan informasi file yang diunggah
            $nama_file = $_FILES['nama_file']['name'];
            $nama_file_tmp = $_FILES['nama_file']['tmp_name'];

            // Membuat UUID untuk id_bast
            $id_bast = uniqid(); 

            // Lokasi penyimpanan file yang diunggah
            $lokasi_upload = "../uploads/"; 
            $lokasi_file = $lokasi_upload . $nama_file;

            // Menyimpan file yang diunggah
            if (move_uploaded_file($nama_file_tmp, $lokasi_file)) {
                // Jika penyimpanan berhasil, tambahkan data ke tabel file_bast
                $query_insert_file = "INSERT INTO file_bast (id_bast, id_inv_ecat, nama_file, created_date) VALUES ('$id_bast', '$id_inv_pl', '$nama_file', NOW())";
                $result_insert_file = mysqli_query($koneksi, $query_insert_file);

                // Jika penambahan data berhasil, lakukan update status transaksi
                if ($result_insert_file) {
                    $query_update_transaksi = "UPDATE inv_pl SET status_transaksi = 'Transaksi Selesai' WHERE id_inv_pl = '$id_inv_pl'";
                    $result_update_transaksi = mysqli_query($koneksi, $query_update_transaksi);

                    if ($result_update_transaksi) {
                        echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Transaksi Selesai!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../spk_pl_diterima.php";
                                });
                            </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Gagal menyelesaikan transaksi!",
                                    icon: "error"
                                }).then(function() {
                                    window.location.href = "../spk_pl_diterima.php";
                                });
                            </script>';
                    }
                } else {
                    // Jika penambahan data gagal, tampilkan pesan error
                    echo "Error: " . $query_insert_file . "<br>" . mysqli_error($koneksi);
                }
            } else {
                // Jika penyimpanan file gagal, tampilkan pesan error
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }

            // Menutup koneksi
            mysqli_close($koneksi);
        }
    ?>
</body>
</html>