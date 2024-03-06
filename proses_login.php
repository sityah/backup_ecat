<?php
session_start(); // memulai sebuah sesi

$UUID = 'HIS' . generate_uuid();
$encoded_id = base64_encode($UUID);
// Menampilkan IP, Jenis Perangkat, Lokasi
$ip_address = $_SERVER['REMOTE_ADDR'];
$os = $_SERVER['HTTP_USER_AGENT'];

$device = "Desktop";
if (preg_match("/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/i", $os)) {
    $device = "Mobile";
}
// echo "Jenis Perangkat: $device";

// Menampilkan Lokasi
$url = 'http://ip-api.com/json/' . $ip_address;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$location = json_decode($result);


$url = 'http://ip-api.com/json/' . $ip_address;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$location = json_decode($result);
$locationString = json_encode($location);
$locationString = '';
$locationString .= $location->city . ',' . $location->country . PHP_EOL;

// ============================================================================
include "koneksi.php";

if (isset($_POST['login'])) {
    // Ambil data dari formulir login
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk mencari data user dari database
    $query = "SELECT * FROM tb_user 
              WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah username ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data password dari database
        $row = mysqli_fetch_assoc($result);
        $password_hash = $row['password'];

        // Verifikasi password
        if (password_verify($password, $password_hash)) {
            // Password benar, simpan data user ke session dan arahkan ke halaman index
            //ambil data dari nama kolom operator
            $_SESSION['tiket_id'] = $row['id_user'];
            $_SESSION['tiket_user'] = $row['username'];
            $_SESSION['tiket_pass'] = $row['password'];
            $_SESSION['tiket_nama'] = $row['nama_user'];
            $_SESSION['tiket_role'] = $row['id_role'];
            $_SESSION['tiket_jenkel'] = $row['jenis_kelamin'];
            $_SESSION['perangkat'] = $os;
            $_SESSION['jenis_perangkat'] = $device;
            $_SESSION['ip'] = $ip_address;
            $_SESSION['encoded_id'] = $encoded_id;
            $_SESSION['id_history'] = $UUID;
            
            // Query untuk mendapatkan role berdasarkan id_role
            $id_role = $row['id_role'];
            $query_role = "SELECT role FROM tb_role WHERE id_role = '$id_role'";
            $result_role = mysqli_query($koneksi, $query_role);
        
            // Periksa apakah query berhasil
            if ($result_role) {
                $row_role = mysqli_fetch_assoc($result_role);
                $_SESSION['nama_role'] = $row_role['role'];
            } else {
                // Handle kesalahan jika diperlukan
                // Misalnya, set default role jika query tidak berhasil
                $_SESSION['nama_role'] = 'Role not available';
            }
            
            $id_role =  $_SESSION['tiket_role'];


            // Update User Login Session
            $id_history =  $_SESSION['encoded_id'];
            $id_user = $_SESSION['tiket_id'];
            
            $online = 'Online';
            $timezone = time() + (60 * 60 * 7);
            $today = gmdate('d/m/Y G:i:s', $timezone);

            // Cek History terlebih dahulu
            // Cek apakah data sudah ada berdasarkan id_user dan ip_login
            $checkQuery = "SELECT * FROM user_history WHERE id_user = '$id_user' AND ip_login = '$ip_address' AND jenis_perangkat = '$device'";
            $checkResult = mysqli_query($koneksi, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                // Data sudah ada, lakukan UPDATE
                $updateQuery = "UPDATE user_history 
                                SET 
                                    id_history = '$UUID',
                                    login_time = '$today',
                                    logout_time = '',
                                    perangkat = '$os',
                                    jenis_perangkat = '$device',
                                    lokasi = '$locationString',
                                    status = '$online'
                                WHERE id_user = '$id_user' AND ip_login = '$ip_address'";
                
                $updateResult = mysqli_query($koneksi, $updateQuery);
                // $sql_role = " SELECT u.id_role, d.id_role, d.role FROM tb_user AS u 
                //                 JOIN tb_role AS d ON (u.id_role = d.id_role)
                //                 WHERE u.id_role = '$id_role'";
                // $query_role = mysqli_query($koneksi, $sql_role) or die(mysqli_error($koneksi));
                // $data_role = mysqli_fetch_array($query_role);
                // $role = $data_role['role']; 
                // echo $role;
                // if($role == 'Finance'){
                //     header("Location: finance/index.php");
                // } else if ($role == 'Driver'){
                //     header("Location: driver/index.php");
                // } else if ($role == 'Admin Gudang'){
                    header("Location: index.php");
                 
            } else {
                // Data belum ada, lakukan INSERT
                // Simpan History
                $history = mysqli_query($koneksi, "INSERT INTO user_history 
                                        (id_history, id_user, login_time, ip_login, perangkat, jenis_perangkat, lokasi, status) 
                                        VALUES 
                                        ('$UUID', '$id_user', '$today', '$ip_address', '$os', '$device', '$locationString', '$online')");

                // $sql_role = " SELECT u.id_user_role, d.id_user_role, d.role FROM user AS u 
                //                 JOIN user_role AS d ON (u.id_user_role = d.id_user_role)
                //                 WHERE u.id_user_role = '$id_role'";
                // $query_role = mysqli_query($koneksi, $sql_role) or die(mysqli_error($koneksi));
                // $data_role = mysqli_fetch_array($query_role);
                // $role = $data_role['role']; 
                // echo $role;
                // if($role == 'Finance'){
                //     header("Location: finance/index.php");
                // } else if ($role == 'Driver'){
                //     header("Location: driver/index.php");
                // } else if ($role == 'Admin Gudang'){
                //     header("Location: index.php");
                
                if($history){
                    header("Location: index.php");
                }else{
                    header("Location: login.php?gagal");
                }
            }
        } else {
            // Password salah, kembali ke halaman login
            header("Location: login.php?gagal");
        }
    } else {
        // Username tidak ditemukan, kembali ke halaman login
        header("Location: login.php?gagal");
    }
}

// <!-- Generate UUID -->

function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
// <!-- End Generate UUID -->