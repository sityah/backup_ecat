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
        include "koneksi.php";

        date_default_timezone_set('Asia/Jakarta');

        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST["simpan-cs"])) {
                // Ambil id_user dari sesi saat ini
                $id_user = $_SESSION['tiket_id'];
            
                // Query untuk mendapatkan nama_user berdasarkan id_user
                $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
                $row_user = mysqli_fetch_assoc($query_user);
                $nama_user = $row_user['nama_user'];
            
                // Lakukan penyimpanan data
                $id_customer = $_POST['id_customer'];
                $status_cs = $_POST['status_cs'];
                $nama_cp = $_POST['nama_cp'];
                $id_perusahaan = $_POST['id_perusahaan']; 
                $npwp = $_POST['no_npwp'];
                $telp = $_POST['telp'];
                $email = $_POST['email'];
                $created_date = date("Y-m-d H:i:s");
            
                // Menghapus folder yang terbuat sebelumnya
                $path = "Customer/" . $id_customer;
                if (is_dir($path)) {
                    rmdir($path);
                }
            
                // Mengambil nama_perusahaan dari tb_perusahaan berdasarkan id_perusahaan
                $result_perusahaan = mysqli_query($koneksi, "SELECT nama_perusahaan FROM tb_perusahaan WHERE id_perusahaan = '$id_perusahaan'");
            
                if ($result_perusahaan) {
                    $row_perusahaan = mysqli_fetch_assoc($result_perusahaan);
                    $nama_perusahaan = $row_perusahaan['nama_perusahaan'];
            
                    // Membuat folder baru
                    mkdir($path, 0777, true);
            
                    // Query SQL untuk memasukkan data ke database
                    $query_insert = "INSERT INTO tb_customer
                                        (id_customer, nama_contact_person, id_perusahaan, no_npwp_instansi, no_telp_cs, email_cs, status_cs, created_date, created_by) 
                                        VALUES ('$id_customer', '$nama_cp', '$id_perusahaan', '$npwp', '$telp', '$email', '$status_cs', '$created_date', '$nama_user')";
            
                    // Eksekusi query insert
                    $result_insert = mysqli_query($koneksi, $query_insert);
            
                    if ($result_insert) {
                        echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Data berhasil ditambahkan!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "data_customer.php";
                                });
                              </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Gagal menambahkan data!",
                                    icon: "error"
                                }).then(function() {
                                    window.location.href = "data_customer.php";
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
                                window.location.href = "data_customer.php";
                            });
                          </script>';
                }
            }
            
        // Check if the request is to edit customer data
        elseif (isset($_POST["edit-cs"])) {
            // Ambil id_user dari sesi saat ini
            $id_user = $_SESSION['tiket_id'];

            // Query untuk mendapatkan nama_user berdasarkan id_user
            $query_user = mysqli_query($koneksi, "SELECT nama_user FROM tb_user WHERE id_user = '$id_user'");
            $row_user = mysqli_fetch_assoc($query_user);
            $nama_user = $row_user['nama_user'];

            $id_customer = $_POST['id_customer'];
            $nama_cp = $_POST['nama_contact_person'];
            $id_perusahaan = $_POST['id_perusahaan'];
            $npwp = $_POST['no_npwp_instansi'];
            $telp = $_POST['no_telp_cs'];
            $email = $_POST['email_cs'];
            $status_cs = $_POST['status_cs'];
            $updated = date("Y-m-d H:i:s");  

            // Menggunakan operator SET dengan benar di dalam query UPDATE
            $updated_query = " UPDATE tb_customer SET
                                        nama_contact_person  = '$nama_cp', 
                                        id_perusahaan = '$id_perusahaan',
                                        no_npwp_instansi = '$npwp',
                                        no_telp_cs = '$telp',
                                        email_cs = '$email',
                                        status_cs = '$status_cs',
                                        updated_date = '$updated',
                                        update_by = '$nama_user'
                                        WHERE id_customer='$id_customer'";

            $updated = mysqli_query($koneksi, $updated_query);

            if ($updated) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "data_customer.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "data_customer.php";
                        });
                    </script>';
            }
        

        // Delete
        } elseif (isset($_POST["delete-cs"])) {
            $id_customer = $_POST['id_customer'];

            // Hapus data customer berdasarkan ID
            $delete = mysqli_query($koneksi, "DELETE FROM tb_customer WHERE id_customer='$id_customer'");

            if ($delete) {
                $path = "Customer/" . $id_customer;
                if (is_dir($path)) {
                    // Hapus folder dan isinya
                    $files = glob($path . '/*');
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                    rmdir($path);
                }
        
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil dihapus!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "data_customer.php";
                        });
                      </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menghapus data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "data_customer.php";
                        });
                      </script>';
            }
        
            }
        }
        mysqli_close($koneksi);
    ?>
</body>
</html>

