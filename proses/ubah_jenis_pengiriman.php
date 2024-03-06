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

        // Pastikan metode yang digunakan adalah POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil data yang dikirim melalui formulir
            $id_inv_ecat = $_POST['id_inv_ecat'];
            $jenis_pengiriman = $_POST['jenis_pengiriman'];
            $id_driver = $_POST['id_driver'];
            $id_ekspedisi = $_POST['id_ekspedisi'];
            $dikirim_oleh = $_POST['dikirim_oleh'];
            $penanggung_jawab = $_POST['penanggung_jawab'];
            $tgl_kirim = '';

            // Tentukan nilai tgl_kirim sesuai dengan jenis pengiriman
            if ($jenis_pengiriman == "1") {
                // Diambil Langsung
                $tgl_kirim = $_POST['tgl_kirim_langsung'];
            } elseif ($jenis_pengiriman == "2") {
                // Driver
                $tgl_kirim = $_POST['tgl_kirim_driver'];
            } elseif ($jenis_pengiriman == "3") {
                // Ekspedisi
                $tgl_kirim = $_POST['tgl_kirim_ekspedisi'];
            }

            // Persiapkan kueri SQL untuk memperbarui data pengiriman berdasarkan ID inv_ecat
            $query = "UPDATE status_kirim SET jenis_pengiriman = '$jenis_pengiriman', id_driver = '$id_driver', id_ekspedisi = '$id_ekspedisi', dikirim_oleh = '$dikirim_oleh', penanggung_jawab = '$penanggung_jawab', tgl_kirim = '$tgl_kirim' WHERE id_inv_ecat = '$id_inv_ecat'";

            // Eksekusi kueri
            if (mysqli_query($koneksi, $query)) {
                // Tampilkan Sweet Alert 2
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Berhasil mengubah jenis pengiriman.",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../details_ecat_dikirim.php?id_inv_ecat=' . $id_inv_ecat . '";
                        });
                    </script>';
            } else {
                // Jika gagal, tampilkan pesan error
                echo "Terjadi kesalahan saat memperbarui data pengiriman: " . mysqli_error($koneksi);
            }

            // Tutup koneksi
            mysqli_close($koneksi);
        }
    ?>
</body>
</html>
    
