<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "mandir36_db_ecat_staging";

// Buat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan nomor urut terakhir dari tb_spk_ecat
$query = "SELECT MAX(no_inv_ecat) as last_inv_ecat FROM inv_ecat";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Mendapatkan nomor urut terakhir
    $lastInvEcat = $row['last_inv_ecat'];

    // Mengembalikan nomor urut terakhir dengan format lengkap
    echo $lastInvEcat;
} else {
    // Jika terjadi kesalahan dalam query
    echo "Error: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
