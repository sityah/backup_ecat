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

        $redirect_page = $_POST['url'];

        if(isset($_POST['delete-spk'])) {
            $id_spk_pl = $_POST['id_spk_pl'];
            $no_spk_pl = $_POST['no_spk_pl'];
            $notes = $_POST['notes'];
            
            // Ambil data yang akan dicancel dari transaksi_produk_ecat
            $query_select_trans = "SELECT 
                                    sr.id_spk_pl,
                                    sr.status_spk_pl,
                                    tps.id_transaksi_pl,
                                    tps.id_produk,
                                    tps.id_spk,
                                    spr.stock, 
                                    tpr.nama_produk, 
                                    tpr.satuan,
                                    tps.qty,
                                    tps.harga,
                                    tps.total_harga,
                                    tps.disc,
                                    tps.status_trx,
                                    tpr.harga_produk,
                                    tm.nama_merk
                                FROM 
                                    db_ecat.transaksi_produk_pl AS tps
                                LEFT JOIN 
                                    db_ecat.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk
                                LEFT JOIN 
                                    db_inventory.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                LEFT JOIN 
                                    db_inventory.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                LEFT JOIN 
                                    db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                WHERE 
                                    tps.id_spk = '$id_spk_pl'";
            $result_select_trans = mysqli_query($koneksi, $query_select_trans);

            // Loop untuk setiap baris data yang akan dicancel
            while($row = mysqli_fetch_assoc($result_select_trans)) {
                $id_spk_pl = $row['id_spk'];
                $id_produk = $row['id_produk'];
                $qty = $row['qty'];
                $harga = $row['harga'];
                $disc = $row['disc'];
                $total_harga = $row['total_harga'];
                $created_date = date("Y-m-d H:i:s");

                $idTrxCancel = mysqli_real_escape_string($koneksi, uuid());

                // Simpan data yang dicancel ke tabel trx_cancel
                $query_insert_cancel = "INSERT INTO trx_cancel (id_trx_cancel, id_spk_ecat, id_produk, qty, harga, disc, total_harga, created_date) VALUES ('$idTrxCancel', '$id_spk_pl', '$id_produk', '$qty', '$harga', '$disc', '$total_harga', '$created_date')";
                mysqli_query($koneksi, $query_insert_cancel);
            }

            // Perbarui status_spk_ecat berdasarkan input dari field notes
            $query_update_status = "UPDATE tb_spk_pl SET status_spk_pl = 'Cancel', notes = '$notes' WHERE id_spk_pl = '$id_spk_pl'";
            mysqli_query($koneksi, $query_update_status);

            // Update alasan cancel di tb_spk_ecat
            $query_update_notes = "UPDATE tb_spk_pl SET notes = '$notes' WHERE id_spk_pl = '$id_spk_pl'";
            mysqli_query($koneksi, $query_update_notes);

            // Setelah semua data berhasil dimasukkan ke trx_cancel dan status diperbarui, hapus dari transaksi_produk_ecat
            $query_delete_trans = "DELETE FROM transaksi_produk_pl WHERE id_spk = '$id_spk_pl'";
            $result_delete_trans = mysqli_query($koneksi, $query_delete_trans);

            if ($result_delete_trans) {
                echo "<script>
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil diCancel!',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '{$redirect_page}';
                        });
                    </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal melakukan Cancel!',
                            icon: 'error'
                        }).then(function() {
                            window.location.href = '{$redirect_page}';
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

