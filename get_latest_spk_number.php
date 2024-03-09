<?php
$host = "anzio-db.id.domainesia.com";//nama server	
$username = "mandir36_staging";//usernya
$password = "mandir36_staging";//password
$database = "mandir36_db_ecat_staging";//database

// Buat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan nomor urut terakhir dari tb_spk_ecat
$query = "SELECT MAX(no_spk_ecat) as last_spk_number FROM tb_spk_ecat";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Mendapatkan nomor urut terakhir
    $lastSPKNumber = $row['last_spk_number'];

    // Mengembalikan nomor urut terakhir dengan format lengkap
    echo $lastSPKNumber;
} else {
    // Jika terjadi kesalahan dalam query
    echo "Error: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
