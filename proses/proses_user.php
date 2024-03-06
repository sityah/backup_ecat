<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
        session_start();
        include "../koneksi.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["simpan-register"])) {
                $id_user = $_POST['id_user'];
                $id_role = $_POST['id_role'];
                $nama_user = $_POST['nama_user'];
                $jenis_kelamin = $_POST['jenis_kelamin'];
                $email = $_POST['email'];
                $username = $_POST['username'];
                $raw_password = $_POST['password']; 
                $status_user = $_POST['status_user'];
            
                // Prepared statement untuk mencegah SQL injection
                $query_insert = "INSERT INTO tb_user (id_user, id_role, nama_user, jenis_kelamin, email, username, password, status_user, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                
                $stmt = mysqli_prepare($koneksi, $query_insert);
                
                if ($stmt) {
                    // Hash password sebelum disimpan ke database
                    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
                    
                    // Bind parameter ke prepared statement
                    mysqli_stmt_bind_param($stmt, "ssssssss", $id_user, $id_role, $nama_user, $jenis_kelamin, $email, $username, $hashed_password, $status_user);
                    
                    // Eksekusi prepared statement
                    mysqli_stmt_execute($stmt);
                    
                    // Periksa hasil eksekusi
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $_SESSION['status1'] = 'success';
                        header("Location:../data_user.php");
                    } else {
                        $_SESSION['status1'] = 'error';
                        header("Location:../register.php");
                    }
                    
                    // Tutup prepared statement
                    mysqli_stmt_close($stmt);
                } else {
                    // Handle kesalahan jika prepared statement gagal
                    $_SESSION['error'] = 'error';
                    header("Location:../register.php");
                }
                
                // Tutup koneksi database
                mysqli_close($koneksi);
                        

            //Edit
        } elseif (isset($_POST["edit-user"])) {
            $id_user = $_POST['id_user'];
            $id_role = $_POST['selectRole'];
            $nama_user = $_POST['nama_user'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $raw_password = $_POST['password']; // Password dalam bentuk teks biasa

            // Hash password sebelum menyimpannya di database
            $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

            $status_user = $_POST['status_user'];

            // Perhatikan bahwa kita tidak memasukkan kolom `updated_date` secara langsung ke dalam query SQL
            $updated_query = "UPDATE tb_user 
                SET
                nama_user  = '$nama_user', 
                id_role  = '$id_role',
                jenis_kelamin  = '$jenis_kelamin',
                email  = '$email',
                username  = '$username',
                password = '$hashed_password',
                status_user = '$status_user'
                WHERE id_user='$id_user'";

            $updated = mysqli_query($koneksi, $updated_query);

            if ($updated) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../data_user.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_user.php";
                        });
                    </script>';
            }

            //Delete
            } elseif (isset($_POST["delete-user"])) {
                $id_user = $_POST['id_user'];

                // Hapus data sales berdasarkan ID
                $delete = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user='$id_user'");

                if ($delete) {
                    // Hapus folder terkait jika ada
                    $path = "../User/" . $id_user;
                    if (file_exists($path) && is_dir($path)) {
                        rmdir($path);
                    }

                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_user.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_user.php";
                            });
                        </script>';
                }
            }
        }

        function isValidPasswordFormat($password) {
            // Tambahkan logika validasi sesuai kebutuhan
            // Contoh: minimal 6 karakter dengan kombinasi huruf dan angka
            $regex = '/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]{6,}$/';
            return preg_match($regex, $password);
        }
    ?>
</body>
</html>