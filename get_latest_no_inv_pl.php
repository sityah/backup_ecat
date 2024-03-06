<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_ecat";

// Buat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan nomor urut terakhir dari tb_spk_ecat
$query = "SELECT MAX(no_inv_pl) as last_inv_pl FROM inv_pl";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Mendapatkan nomor urut terakhir
    $lastInvPl = $row['last_inv_pl'];

    // Mengembalikan nomor urut terakhir dengan format lengkap
    echo $lastInvPl;
} else {
    // Jika terjadi kesalahan dalam query
    echo "Error: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
