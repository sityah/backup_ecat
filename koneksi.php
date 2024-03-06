<?php
// $host = "localhost"; 
// $username = "root";  
// $password = "";  
// $database = "db_ecat";  

$host = "anzio-db.id.domainesia.com";//nama server	
$username = "mandir36_staging";//usernya
$password = "mandir36_staging";//password
$database = "mandir36_db_ecat_staging";//database

$host2 = "anzio-db.id.domainesia.com"; 
$username2 = "mandir36_staging";  
$password2 = "mandir36_staging";  
$database2 = "mandir36_staging"; 



// Buat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$koneksi2 = mysqli_connect($host2, $username2, $password2, $database2);

// Cek koneksi ke database kedua
if (!$koneksi2) {
    die("Koneksi ke database kedua gagal: " . mysqli_connect_error());
}
?>
