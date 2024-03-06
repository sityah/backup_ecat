<?php
session_start();
include "../koneksi.php";

// Periksa apakah data yang diperlukan dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah id_inv_ecat dan id_driver dikirim
    if (isset($_POST["id_inv_ecat"]) && isset($_POST["id_driver"])) {
        // Tangkap nilai id_inv_ecat dan id_driver dari form
        $id_inv_ecat = $_POST["id_inv_ecat"];
        $id_driver = $_POST["id_driver"];

        // Lakukan kueri SQL untuk memperbarui id_driver di tabel status_kirim
        $query = "UPDATE status_kirim SET id_driver = '$id_driver' WHERE id_inv_ecat = '$id_inv_ecat'";
        
        // Jalankan kueri
        if (mysqli_query($koneksi, $query)) {
            // Jika kueri berhasil dijalankan, Anda dapat menampilkan pesan sukses atau melakukan tindakan lainnya
            echo "Data berhasil diperbarui.";
        } else {
            // Jika terjadi kesalahan saat menjalankan kueri, tampilkan pesan kesalahan
            echo "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
    } else {
        // Jika id_inv_ecat atau id_driver tidak diterima, tampilkan pesan kesalahan
        echo "ID inv atau ID driver tidak ditemukan.";
    }
}
?>
