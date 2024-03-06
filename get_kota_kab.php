<?php
include "koneksi.php";

header('Content-Type: application/json');

$response = array();

if (isset($_POST['provinsi_id'])) {
    $provinsi_id = $_POST['provinsi_id'];

    // Query untuk mendapatkan data kota berdasarkan provinsi
    $kota_query = "SELECT * FROM tb_kota WHERE id_provinsi = '$provinsi_id'";
    $result_kota = $koneksi->query($kota_query);

    if ($result_kota) {
        // Inisialisasi array untuk menyimpan data kota
        $data_kota = array();

        // Ambil data kota dan tambahkan ke array
        while ($row_kota = mysqli_fetch_assoc($result_kota)) {
            $data_kota[] = $row_kota;
        }

        // Set respons dengan data kota
        $response['success'] = true;
        $response['data'] = $data_kota;
    } else {
        // Set respons dengan informasi kesalahan query
        $response['success'] = false;
        $response['error'] = 'Query Error: ' . mysqli_error($koneksi);
    }

    // Tutup koneksi
    $koneksi->close();
} else {
    // Set respons dengan informasi kesalahan
    $response['success'] = false;
    $response['error'] = 'Invalid Request';
}

// Kembalikan respons dalam format JSON
echo json_encode($response);
?>
