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

    if(isset($_POST['namaPetugas'], $_POST['spkId'])) {
        $namaPetugas = $_POST['namaPetugas'];
        $id_spk_pl = $_POST['spkId'];

        mysqli_begin_transaction($koneksi);

        // Update petugas_ecat dan status_spk_ecat di tabel tb_spk_ecat
        $query_spk = "UPDATE tb_spk_pl SET petugas_pl = '$namaPetugas', status_spk_pl = 'Siap Kirim' WHERE id_spk_pl = '$id_spk_pl'";
        $result_spk = mysqli_query($koneksi, $query_spk);

        // Mengambil total harga dari transaksi_produk_ecat
        $query_total_harga = "SELECT SUM(total_harga) AS total FROM transaksi_produk_pl WHERE id_spk = '$id_spk_pl'";
        $result_total_harga = mysqli_query($koneksi, $query_total_harga);
        $row_total_harga = mysqli_fetch_assoc($result_total_harga);
        $totalHarga = $row_total_harga['total'];

        // Update total_spk_ecat di tabel tb_spk_ecat dengan total harga
        $query_update_total = "UPDATE tb_spk_pl SET total_spk_pl = '$totalHarga' WHERE id_spk_pl = '$id_spk_pl'";
        $result_update_total = mysqli_query($koneksi, $query_update_total);

        if ($result_spk && $result_update_total) {
            mysqli_commit($koneksi);

            echo "<script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Berhasil diproses ke Siap Kirim',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../spk_pl_dalam_proses.php';
                        }
                    });
                </script>";
        } else {
            mysqli_rollback($koneksi);

            echo "<script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal memperbarui data: " . mysqli_error($koneksi) . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
        }
    } else {
        echo "Data tidak lengkap";
    }

    mysqli_close($koneksi);
?>
</body>
</html>