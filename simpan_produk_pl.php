<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_spk']) && isset($_POST['id_produk'])) {
        $id_spk_pl = $_POST['id_spk'];
        $id_produk_ecat = $_POST['id_produk'];

        $uuid = mysqli_real_escape_string($koneksi, uuid());

        $query_insert = "INSERT INTO tmp_produk_spk_pl (id_tmp_pl, id_spk_pl, id_produk_ecat, qty) VALUES ('$uuid', '$id_spk_pl', '$id_produk_ecat', '0')";
        $result = mysqli_query($koneksi, $query_insert);

        if (!$result) {
            echo "Terjadi kesalahan saat menyimpan data produk: " . mysqli_error($koneksi);
            exit(); 
        }
    } else {
        echo "ID SPK dan ID produk tidak ditemukan dalam permintaan.";
    }

    if (isset($_POST['id_tmp_pl'])) {
        $id_tmp_pl = $_POST['id_tmp_pl'];

        $query_delete = "DELETE FROM tmp_produk_spk_pl WHERE id_tmp_pl = '$id_tmp_pl'";
        $result_delete = mysqli_query($koneksi, $query_delete);

        if (!$result_delete) {
            echo "Terjadi kesalahan saat menghapus data produk: " . mysqli_error($koneksi);
            exit();
        }
    }

    echo "Operasi berhasil dilakukan."; 
    echo "Metode permintaan yang tidak valid.";
}

function uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s', str_split(bin2hex($data), 4));
}
?>
