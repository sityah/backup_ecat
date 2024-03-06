<?php
include "koneksi.php";

// Menampilkan opsi kota/kabupaten berdasarkan provinsi
if (isset($_POST['id_provinsi_select'])) {
    $selectedProvinsi = $_POST['id_provinsi_select'];

    $query_kota_kab = "SELECT * FROM tb_kota WHERE id_provinsi = '$selectedProvinsi'";
    $result_kota_kab = mysqli_query($koneksi, $query_kota_kab);

    while ($data_kota_kab = mysqli_fetch_array($result_kota_kab)) {
        echo '<option value="' . $data_kota_kab['id_kota_kab'] . '">' . $data_kota_kab['nama_kota_kab'] . '</option>';
    }
    exit(); 
}
?>
