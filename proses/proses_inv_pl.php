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

        date_default_timezone_set('Asia/Jakarta');

        // Pastikan metode yang digunakan adalah POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil nilai dari form
            $id_inv_pl = $_POST['id_inv_pl']; 
            $id_spk_pl = $_POST['id_spk_pl']; 
            $id_user = $_POST['id_user']; 
            $no_inv_pl = $_POST['no_inv_pl'];
            $tgl_inv_pl = $_POST['tgl_inv_pl'];
            $tgl_tempo = $_POST['tgl_tempo'];
            $jenis_invoice = $_POST['jenis_invoice'];
            $sp_disc = $_POST['sp_disc'];
            $notes = $_POST['notes'];
            $created_date = date("Y-m-d H:i:s");

            // Query untuk menyisipkan data ke dalam tabel inv_ecat
            $sql_insert = "INSERT INTO inv_pl (id_inv_pl, id_user, no_inv_pl, tgl_inv_pl, tgl_tempo, jenis_invoice, sp_disc, notes, status_transaksi, created_date) 
                        VALUES ('$id_inv_pl', '$id_user', '$no_inv_pl', '$tgl_inv_pl', '$tgl_tempo', '$jenis_invoice', '$sp_disc', '$notes', 'Invoice Dibuat', '$created_date')";

            // Jalankan query penyisipan data
            if (mysqli_query($koneksi, $sql_insert)) {
                // Query untuk mengupdate status SPK menjadi "Invoice Dibuat" berdasarkan id_sales dan status_spk_ecat
                $sql_update_spk = "UPDATE tb_spk_pl SET status_spk_pl = 'Invoice Dibuat', id_inv_pl = '$id_inv_pl' 
                                WHERE id_spk_pl = '$id_spk_pl' AND status_spk_pl = 'Siap Kirim'";

                if (mysqli_query($koneksi, $sql_update_spk)) {
                    // Query untuk memperbarui status transaksi menjadi "Siap Kirim"
                    $sql_update_status_transaksi = "UPDATE inv_pl SET status_transaksi = 'Invoice Dibuat' WHERE id_inv_pl = '$id_inv_pl'";

                    if (mysqli_query($koneksi, $sql_update_status_transaksi)) {echo "<script>
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Invoice Berhasil Dibuat',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '../spk_pl_siap_kirim.php';
                                    }
                                });
                            </script>";
                    } else {
                        echo "Error updating status transaksi: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Error updating status SPK: " . mysqli_error($koneksi);
                }
            } else {
                echo "Error inserting data: " . mysqli_error($koneksi);
            }
        }
    ?>
</body>
</html>

