<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/logo-kma.png" rel="icon">
</head>

<body>
<?php
// Fungsi untuk melakukan logout
function logoutUser($userId, $idHistory, $koneksi)
{
    date_default_timezone_set('Asia/Jakarta');

    // Dapatkan waktu logout
    $logoutTime = date('Y-m-d H:i:s');

    // Update waktu logout dan status di tabel user_history
    $updateQuery = "UPDATE user_history SET logout_time = '$logoutTime', status = 'Offline' WHERE id_user = '$userId' AND id_history = '$idHistory' AND status = 'Online'";
    $result = mysqli_query($koneksi, $updateQuery);

    return $result;
}

// Periksa apakah sesi sudah dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah pengguna telah login
if (empty($_SESSION['tiket_user'])) {
    // Redirect ke halaman logout.php
    header("location: logout.php");
} else {
    include "koneksi.php";
    
    // Ambil status pengguna dari database
    $id_user = $_SESSION['tiket_id'];
    $ip = $_SESSION['ip'];
    $id_history = $_SESSION['id_history'];

    // Periksa apakah sesi sudah berakhir (30 menit tidak ada aktivitas)
    $session_time = 1800; // 30 menit
    $current_time = time();

    if (isset($_SESSION['last_activity']) && ($current_time - $_SESSION['last_activity']) > $session_time) {
        // Jika sesi telah berakhir, hancurkan sesi dan redirect ke logout.php
        session_unset();
        session_destroy();
        header("location: logout.php");
    } else {
        // Perbarui waktu aktivitas terakhir setiap kali ada aktivitas
        $_SESSION['last_activity'] = $current_time;

        // Ambil status pengguna dari database
        $query = "SELECT status FROM user_history WHERE id_history = '$id_history' AND id_user = '$id_user' AND ip_login = '$ip'";
        $result = $koneksi->query($query);

        // Periksa apakah query berhasil dijalankan
        if ($result) {
            $row = $result->fetch_assoc();
            $status = $row['status'];

            // Periksa status pengguna
            if ($status == "Offline") {
                // Status pengguna tidak aktif, hancurkan sesi dan redirect ke logout.php
                session_unset();
                session_destroy();
                header("location: logout.php");
            }
        } else {
            die("Query gagal: " . $koneksi->error);
        }
    }

    // Tutup koneksi database
    $koneksi->close();
}
?>

<script>
    // var countdown = <?php echo $session_time; ?>;
    
    // function updateCountdown() {
    //     var minutes = Math.floor(countdown / 60);
    //     var seconds = countdown % 60;

    //     // Format menit dan detik dalam bentuk MM:SS
    //     var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

    //     document.getElementById('countdown').innerHTML = formattedTime;

    //     if (countdown > 0) {
    //         countdown--;
    //         setTimeout(updateCountdown, 1000);
    //     } else {
    //         // Redirect ke halaman logout.php setelah hitungan mundur selesai
    //         window.location.href = 'logout.php';
    //     }
    // }

    // // Memanggil fungsi updateCountdown saat halaman dimuat
    // document.addEventListener('DOMContentLoaded', function () {
    //     updateCountdown();
    // });
</script>
</body>

</html>