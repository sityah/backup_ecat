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

        if(isset($_POST['delete-spk'])) {
            $id_spk_ecat = $_POST['id_spk_ecat'];
            $no_spk_ecat = $_POST['no_spk_ecat'];
            $notes = $_POST['notes'];

            // Memisahkan ID SPK jika ada lebih dari satu
            $id_spk_array = explode(",", $id_spk_ecat);

            foreach ($id_spk_array as $id_spk) {
                // Ambil id_inv_ecat dari $id_spk
                $query_select_id_ecat = "SELECT id_inv_ecat FROM tb_spk_ecat WHERE id_spk_ecat = '$id_spk'";
                $result_select_id_ecat = mysqli_query($koneksi, $query_select_id_ecat);
                $row_id_ecat = mysqli_fetch_assoc($result_select_id_ecat);
                $id_inv_ecat = $row_id_ecat['id_inv_ecat'];

                // Ambil data transaksi dari transaksi_produk_ecat
                $query_get_transaksi = "SELECT 
                                            id_spk,
                                            id_produk,
                                            qty,
                                            harga,
                                            disc,
                                            total_harga,
                                            NOW() as created_date
                                        FROM 
                                            transaksi_produk_ecat
                                        WHERE 
                                            id_spk = '$id_spk'";
                $result_get_transaksi = mysqli_query($koneksi, $query_get_transaksi);

                while($row = mysqli_fetch_assoc($result_get_transaksi)) {
                    $id_spk_ecat = $row['id_spk'];
                    $id_produk = $row['id_produk'];
                    $qty = $row['qty'];
                    $harga = $row['harga'];
                    $disc = $row['disc'];
                    $total_harga = $row['total_harga'];
                    $created_date = $row['created_date'];

                    $idTrxCancel = mysqli_real_escape_string($koneksi, uuid());

                    // Simpan data yang dicancel ke tabel trx_cancel
                    $query_insert_cancel = "INSERT INTO trx_cancel (id_trx_cancel, id_spk_ecat, id_produk, qty, harga, disc, total_harga, created_date) 
                                            VALUES ('$idTrxCancel', '$id_spk_ecat', '$id_produk', '$qty', '$harga', '$disc', '$total_harga', '$created_date')";
                    mysqli_query($koneksi, $query_insert_cancel);
                }

                // Hapus data dari tabel transaksi_produk_ecat menggunakan id_spk
                $query_delete_trans = "DELETE FROM transaksi_produk_ecat WHERE id_spk = '$id_spk'";
                $result_delete_trans = mysqli_query($koneksi, $query_delete_trans);

                // Perbarui status_spk_ecat berdasarkan input dari field notes
                $query_update_status = "UPDATE tb_spk_ecat SET status_spk_ecat = 'Cancel', notes = '$notes' WHERE id_spk_ecat = '$id_spk'";
                mysqli_query($koneksi, $query_update_status);

                // Set status transaksi di tabel inv_ecat menjadi "Cancel"
                $query_update_inv_ecat = "UPDATE inv_ecat SET status_transaksi = 'Cancel' WHERE id_inv_ecat = '$id_inv_ecat'";
                mysqli_query($koneksi, $query_update_inv_ecat);
            }

            if ($result_delete_trans) {
                echo "<script>
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil diCancel!',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '../data_spk.php';
                        });
                    </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal melakukan Cancel!',
                            icon: 'error'
                        }).then(function() {
                            window.location.href = '../data_spk.php';
                        });
                    </script>";
            }
        }
        // Fungsi untuk menghasilkan UUID dalam format string
        function uuid() {
            $data = random_bytes(12); // 12 byte yang tersisa
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
            return 'TRXC' . vsprintf('%s%s-%s', str_split(bin2hex($data), 4));
        }

        // Tutup koneksi database jika sudah tidak digunakan
        mysqli_close($koneksi);
    ?>
</body>
</html>
