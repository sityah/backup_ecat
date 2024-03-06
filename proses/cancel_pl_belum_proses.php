<?php
session_start();
include "../koneksi.php";

if(isset($_POST['cancel-spk'])) {
    $id_spk_pl = $_POST['id_spk_pl'];
    $no_spk_pl = $_POST['no_spk_pl'];
    $notes = $_POST['notes'];

    // Ambil data yang akan dicancel dari transaksi_produk_ecat
    $query_select_trans = "SELECT 
                            sr.id_spk_pl,
                            tps.id_tmp_pl,
                            tps.id_produk_ecat,
                            spr.stock, 
                            tpr.nama_produk, 
                            tpr.satuan,
                            tps.qty,
                            tps.status_tmp,
                            tpr.harga_produk,
                            tm.nama_merk  
                        FROM mandir36_db_ecat_staging.tmp_produk_spk_pl AS tps
                        LEFT JOIN mandir36_db_ecat_staging.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk_pl
                        LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                        LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                        LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                        WHERE sr.id_spk_pl = '$id_spk_pl'";
    $result_select_trans = mysqli_query($koneksi, $query_select_trans);

    // Loop untuk setiap baris data yang akan dicancel
    while($row = mysqli_fetch_assoc($result_select_trans)) {
        $id_spk_pl = $row['id_spk_pl'];
        $id_produk = $row['id_produk_ecat'];
        $qty = $row['qty'];
        $harga = $row['harga'];
        $created_date = date("Y-m-d H:i:s");

        $idTrxCancel = mysqli_real_escape_string($koneksi, uuid());

        // Simpan data yang dicancel ke tabel trx_cancel
        $query_insert_cancel = "INSERT INTO trx_cancel (id_trx_cancel, id_spk_ecat, id_produk, qty, harga, created_date) VALUES ('$idTrxCancel', '$id_spk_pl', '$id_produk', '$qty', '$harga', '$created_date')";
        $result_insert_cancel = mysqli_query($koneksi, $query_insert_cancel);

    }

    // Perbarui status_spk_ecat berdasarkan input dari field notes
    $query_update_status = "UPDATE tb_spk_pl SET status_spk_pl = 'Cancel', notes = '$notes' WHERE id_spk_pl = '$id_spk_pl'";
    $result_update_status = mysqli_query($koneksi, $query_update_status);

    // Update alasan cancel di tb_spk_ecat
    $query_update_notes = "UPDATE tb_spk_pl SET notes = '$notes' WHERE id_spk_pl = '$id_spk_pl'";
    $result_update_notes = mysqli_query($koneksi, $query_update_notes);

    // Setelah semua data berhasil dimasukkan ke trx_cancel dan status diperbarui, hapus dari transaksi_produk_ecat
    $query_delete_trans = "DELETE FROM tmp_produk_spk_pl WHERE id_spk_pl = '$id_spk_pl'";
    $result_delete_trans = mysqli_query($koneksi, $query_delete_trans);

    if($result_delete_trans) {
        echo "<script>alert('Berhasil melakukan cancel'); window.location.href = '../data_spk_pl.php';</script>";
    } else {
        echo "<script>alert('Gagal melakukan cancel'); window.location.href = '../data_spk_pl.php';</script>";
    }
}

// Fungsi untuk menghasilkan UUID dalam format string
function uuid() {
    $data = random_bytes(12); 
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
    return 'TRXC' . vsprintf('%s%s-%s', str_split(bin2hex($data), 4));
}
// Tutup koneksi database jika sudah tidak digunakan
mysqli_close($koneksi);
?>
