<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete_id'])) {
        $id_tmp_pl_to_delete = $_POST['delete_id'];

        $query_delete = "DELETE FROM tmp_produk_spk_pl WHERE id_tmp_pl = ?";
        $stmt = mysqli_prepare($koneksi, $query_delete);
        mysqli_stmt_bind_param($stmt, 'i', $id_tmp_pl_to_delete);
        $success = mysqli_stmt_execute($stmt);
        
        if($success) {
            echo json_encode(array("success" => true));
            exit; 
        } else {
            echo json_encode(array("success" => false, "message" => "Gagal menghapus data."));
            exit;
        }
    }

    $id_tmp_pl_array = $_POST['id_tmp_pl'];
    $new_qty_array = $_POST['new_qty'];

    for ($i = 0; $i < count($id_tmp_pl_array); $i++) {
        $id_tmp_pl = mysqli_real_escape_string($koneksi, $id_tmp_pl_array[$i]);
        $new_qty = mysqli_real_escape_string($koneksi, $new_qty_array[$i]);

        // Perbarui qty di dalam database
        $query_update = "UPDATE tmp_produk_spk_pl SET qty = '$new_qty', status_tmp = 1 WHERE id_tmp_pl = '$id_tmp_pl'";
        $result_update = mysqli_query($koneksi, $query_update);

        if (!$result_update) {
            echo "Terjadi kesalahan saat memperbarui qty untuk produk dengan ID $id_tmp_pl: " . mysqli_error($koneksi);
            exit(); 
        }
    }

    $id_spk_pl = $_POST['id_spk_pl']; 
    header("Location: detail_produk_spk_pl.php?id_spk_pl=$id_spk_pl");
    exit();
} else {
    echo "Metode permintaan tidak valid.";
}

mysqli_close($koneksi);
?>
