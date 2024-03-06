<?php
session_start();
include "../koneksi.php";

if(isset($_POST['cancel-spk'])) {
    $id_spk_ecat = $_POST['id_spk_ecat'];
    $no_spk_ecat = $_POST['no_spk_ecat'];
    $notes = $_POST['notes'];

    // Ambil data yang akan dicancel dari transaksi_produk_ecat
    $query_select_trans = "SELECT 
                            sr.id_spk_ecat,
                            tps.id_tmp_ecat,
                            tps.id_produk_ecat,
                            spr.stock, 
                            tpr.nama_produk, 
                            tpr.satuan,
                            tps.qty,
                            tps.status_tmp,
                            tpr.harga_produk,
                            tm.nama_merk  
                        FROM db_ecat.tmp_produk_spk_ecat AS tps
                        LEFT JOIN db_ecat.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk_ecat
                        LEFT JOIN db_inventory.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                        LEFT JOIN db_inventory.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                        LEFT JOIN db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                        WHERE sr.id_spk_ecat = '$id_spk_ecat'";
    $result_select_trans = mysqli_query($koneksi, $query_select_trans);

    // Loop untuk setiap baris data yang akan dicancel
    while($row = mysqli_fetch_assoc($result_select_trans)) {
        $id_spk_ecat = $row['id_spk_ecat'];
        $id_produk = $row['id_produk_ecat'];
        $qty = $row['qty'];
        $harga = $row['harga'];
        $created_date = date("Y-m-d H:i:s");

        $idTrxCancel = mysqli_real_escape_string($koneksi, uuid());

        // Simpan data yang dicancel ke tabel trx_cancel
        $query_insert_cancel = "INSERT INTO trx_cancel (id_trx_cancel, id_spk_ecat, id_produk, qty, harga, created_date) VALUES ('$idTrxCancel', '$id_spk_ecat', '$id_produk', '$qty', '$harga', '$created_date')";
        $result_insert_cancel = mysqli_query($koneksi, $query_insert_cancel);

    }

    // Perbarui status_spk_ecat berdasarkan input dari field notes
    $query_update_status = "UPDATE tb_spk_ecat SET status_spk_ecat = 'Cancel', notes = '$notes' WHERE id_spk_ecat = '$id_spk_ecat'";
    $result_update_status = mysqli_query($koneksi, $query_update_status);

    // Update alasan cancel di tb_spk_ecat
    $query_update_notes = "UPDATE tb_spk_ecat SET notes = '$notes' WHERE id_spk_ecat = '$id_spk_ecat'";
    $result_update_notes = mysqli_query($koneksi, $query_update_notes);

    // Setelah semua data berhasil dimasukkan ke trx_cancel dan status diperbarui, hapus dari transaksi_produk_ecat
    $query_delete_trans = "DELETE FROM tmp_produk_spk_ecat WHERE id_spk_ecat = '$id_spk_ecat'";
    $result_delete_trans = mysqli_query($koneksi, $query_delete_trans);

    if($result_delete_trans) {
        echo "<script>alert('Berhasil melakukan cancel'); window.location.href = '../data_spk.php';</script>";
    } else {
        echo "<script>alert('Gagal melakukan cancel'); window.location.href = '../data_spk.php';</script>";
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
