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

        if (isset($_POST["simpan-perusahaan"])) {
            // Ambil id_user dari sesi saat ini
            $id_user = $_SESSION['tiket_id'];
        
            // Query untuk mendapatkan nama_user berdasarkan id_user
            $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
            $row_user = mysqli_fetch_assoc($query_user);
            $nama_user = $row_user['nama_user'];

            $id_perusahaan = $_POST['id_perusahaan'];
            $nama_perusahaan = $_POST['nama_perusahaan'];
            $id_provinsi = $_POST['id_provinsi_select'];
            $id_kota_kab = $_POST['id_kota_kab_select'];
            $jenis_perusahaan = $_POST['jenis_perusahaan'];
            $alamat_perusahaan = $_POST['alamat_perusahaan'];
            $no_telp_perusahaan = $_POST['no_telp_perusahaan'];
            $email_perusahaan = $_POST['email_perusahaan'];

            $cek_perusahaan = mysqli_query($koneksi, "SELECT nama_perusahaan FROM tb_perusahaan WHERE nama_perusahaan = '$nama_perusahaan'");

            if ($cek_perusahaan->num_rows > 0) {
                $_SESSION['info'] = 'Data Gagal Disimpan';
                header("Location:../data_perusahaan.php");
            } else {
                // Membuat folder baru
                $path = "../Perusahaan/" . $nama_perusahaan; 
                mkdir($path, 0777, true);

                // Query SQL untuk memasukkan data ke database
                $query_insert = "INSERT INTO tb_perusahaan
                                    (id_perusahaan, id_kota_kab, id_provinsi, jenis_perusahaan, nama_perusahaan, alamat_perusahaan, no_telp_perusahaan, email_perusahaan, created_by) 
                                    VALUES ('$id_perusahaan', '$id_kota_kab', '$id_provinsi', '$jenis_perusahaan', '$nama_perusahaan', '$alamat_perusahaan', '$no_telp_perusahaan', '$email_perusahaan', '$nama_user')";

                // Eksekusi query insert
                $result_insert = mysqli_query($koneksi, $query_insert);

                if ($result_insert) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil ditambahkan!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_perusahaan.php";
                            });
                          </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menambahkan data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_perusahaan.php";
                            });
                          </script>';
                }
            } 

        } elseif (isset($_POST["edit-perusahaan"])) {
            // Ambil id_user dari sesi saat ini
            $id_user = $_SESSION['tiket_id'];

            // Query untuk mendapatkan nama_user berdasarkan id_user
            $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
            $row_user = mysqli_fetch_assoc($query_user);
            $nama_user = $row_user['nama_user'];

            $id_perusahaan = $_POST['id_perusahaan'];
            $nama_perusahaan = $_POST['nama_perusahaan'];
            $alamat_perusahaan = $_POST['alamat_perusahaan'];
            $no_telp_perusahaan = $_POST['no_telp_perusahaan'];
            $email_perusahaan = $_POST['email_perusahaan'];

            // Mengambil data lama dari database
            $query = "SELECT * FROM tb_perusahaan WHERE id_perusahaan = '$id_perusahaan'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_assoc($result);

            $updated = mysqli_query($koneksi, "UPDATE tb_perusahaan
            SET
            nama_perusahaan  = '$nama_perusahaan', 
            alamat_perusahaan  = '$alamat_perusahaan',
            no_telp_perusahaan  = '$no_telp_perusahaan',
            email_perusahaan  = '$email_perusahaan',
            update_by = '$nama_user'
            WHERE id_perusahaan='$id_perusahaan'");

            if ($updated) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../data_perusahaan.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_perusahaan.php";
                        });
                    </script>';
            }

        } elseif (isset($_POST["delete-perusahaan"])) {
            $id_perusahaan = $_POST['id_perusahaan'];

            // Hapus data sales berdasarkan ID
            $delete = mysqli_query($koneksi, "DELETE FROM tb_perusahaan WHERE id_perusahaan='$id_perusahaan'");

            if ($delete) {
                // Hapus folder terkait jika ada
                $path = "../Perusahaan/" . $id_perusahaan; 
                if (file_exists($path) && is_dir($path)) {
                    rmdir($path);
                }

                echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_perusahaan.php";
                            });
                        </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menghapus data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_perusahaan.php";
                        });
                    </script>';
            }
        }
    ?>
</body>
</html>