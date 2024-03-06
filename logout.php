<?php
session_start();
include "koneksi.php";

// Hancurkan semua variabel sesi
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>
