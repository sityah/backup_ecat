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

        date_default_timezone_set('Asia/Jakarta');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["simpan-sales"])) {
                // Ambil id_user dari sesi saat ini
                $id_user = $_SESSION['tiket_id'];
        
                // Query untuk mendapatkan nama_user berdasarkan id_user
                $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
                $row_user = mysqli_fetch_assoc($query_user);
                $nama_user = $row_user['nama_user'];
        
                $id_sales = $_POST['id_sales'];
                $status_sales = $_POST['status_sales'];
                $id_provinsi = $_POST['id_provinsi_select'];
                $id_kota_kab = $_POST['id_kota_kab_select'];
                $nama_sales = $_POST['nama_sales'];
                $alamat = $_POST['alamat'];
                $jenis_sales = $_POST['jenis_sales'];
                $id_perusahaan = $_POST['id_perusahaan']; 
                $no_npwp = $_POST['no_npwp'];
                $no_telp_sales = $_POST['no_telp_sales'];
                $email_sales = $_POST['email_sales'];
                $created_date = date("Y-m-d H:i:s");
        
                // Menghapus folder yang terbuat sebelumnya
                $path = "Sales/" . $id_sales;
                if (is_dir($path)) {
                    rmdir($path);
                }
        
                $result_perusahaan = mysqli_query($koneksi, "SELECT nama_perusahaan FROM tb_perusahaan WHERE id_perusahaan = '$id_perusahaan'");
        
                if ($result_perusahaan) {
                    $row_perusahaan = mysqli_fetch_assoc($result_perusahaan);
        
                    // Membuat folder baru
                    mkdir($path, 0777, true);
        
                    // Query SQL untuk memasukkan data ke database
                    $query_insert = "INSERT INTO tb_sales_ecat
                                        (id_sales, id_provinsi, id_kota_kab, nama_sales, alamat, jenis_sales, id_perusahaan, no_npwp, no_telp_sales, email_sales, status_sales, created_date, created_by) 
                                        VALUES ('$id_sales', '$id_provinsi', '$id_kota_kab', '$nama_sales', '$alamat', '$jenis_sales', '$id_perusahaan','$no_npwp', '$no_telp_sales', '$email_sales', '$status_sales', '$created_date', '$nama_user')";
        
                    // Eksekusi query insert
                    $result_insert = mysqli_query($koneksi, $query_insert);
        
                    if ($result_insert) {
                        echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Data berhasil ditambahkan!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../data_sales.php";
                                });
                              </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Gagal menambahkan data!",
                                    icon: "error"
                                }).then(function() {
                                    window.location.href = "../data_sales.php";
                                });
                              </script>';
                    }
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menambahkan data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_sales.php";
                            });
                          </script>';
                }
            }

            // Edit
            elseif (isset($_POST["edit-sales"])) {
                // Ambil id_user dari sesi saat ini
                $id_user = $_SESSION['tiket_id'];

                // Query untuk mendapatkan nama_user berdasarkan id_user
                $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
                $row_user = mysqli_fetch_assoc($query_user);
                $nama_user = $row_user['nama_user'];

                $id_sales = $_POST['id_sales'];
                $id_provinsi = $_POST['selectProvinsi'];
                $id_kota_kab = $_POST['selectKota'];
                $nama_sales = $_POST['nama_sales'];
                $alamat = $_POST['alamat'];
                $jenis_sales = $_POST['jenis_sales'];
                $id_perusahaan = $_POST['id_perusahaan'];
                $no_npwp = $_POST['no_npwp'];
                $no_telp_sales = $_POST['no_telp_sales'];
                $email_sales = $_POST['email_sales'];
                $status_sales = $_POST['status_sales'];
                $update = date("Y-m-d H:i:s");  

                $update_query = "UPDATE tb_sales_ecat 
                                SET
                                nama_sales  = '$nama_sales', 
                                jenis_sales = '$jenis_sales',
                                id_provinsi  = '$id_provinsi', 
                                id_kota_kab = '$id_kota_kab',
                                id_perusahaan = '$id_perusahaan',
                                no_npwp = '$no_npwp',
                                alamat = '$alamat',
                                no_telp_sales = '$no_telp_sales',
                                email_sales = '$email_sales',
                                status_sales = '$status_sales',
                                update_date = '$update',
                                update_by = '$nama_user' 
                                WHERE id_sales='$id_sales'";

                $update = mysqli_query($koneksi, $update_query);

                if ($update) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil diedit!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_sales.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal mengedit data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_sales.php";
                            });
                        </script>';
                }

            // Delete
            } elseif (isset($_POST["delete-sales"])) {
                $id_sales = $_POST['id_sales'];

                // Hapus data sales berdasarkan ID
                $delete = mysqli_query($koneksi, "DELETE FROM tb_sales_ecat WHERE id_sales='$id_sales'");

                if ($delete) {
                    // Hapus folder terkait jika ada
                    $path = "../Sales/" . $id_sales;
                    if (file_exists($path) && is_dir($path)) {
                        rmdir($path);
                    }

                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_sales.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_sales.php";
                            });
                        </script>';
                }
            }
        }
    ?>
</body>
</html>

	