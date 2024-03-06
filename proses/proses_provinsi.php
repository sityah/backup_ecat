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

        if (isset($_POST["simpan-provinsi"])) {
            $id_provinsi = $_POST['id_provinsi'];
            $nama_provinsi = $_POST['nama_provinsi'];

            $cek_provinsi = mysqli_query($koneksi, "SELECT nama_provinsi FROM tb_provinsi WHERE nama_provinsi = '$nama_provinsi'");

            if ($cek_provinsi->num_rows > 0) {
                $_SESSION['status1'] = 'error';
                header("Location:../data_provinsi.php");
            } else {
                // Membuat folder baru
                $path = "../Provinsi/" . $nama_provinsi;

                // Query SQL untuk memasukkan data ke database
                $query_insert = "INSERT INTO tb_provinsi
                                    (id_provinsi, nama_provinsi) 
                                    VALUES ('$id_provinsi', '$nama_provinsi')";

                // Eksekusi query insert
                $result_insert = mysqli_query($koneksi, $query_insert);

                if ($result_insert) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil ditambahkan!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "data_provinsi.php";
                            });
                          </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menambahkan data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "data_provinsi.php";
                            });
                          </script>';
                }
                
            }

        //Edit
        } elseif (isset($_POST["edit-provinsi"])) {
            $id_provinsi = $_POST['id_provinsi'];
            $nama_provinsi = $_POST['nama_provinsi'];
            $updated = $_POST['updated_date'];

            // Mengambil data lama dari database
            $query = "SELECT * FROM tb_provinsi WHERE id_provinsi = '$id_provinsi'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_array($result);

            // Gunakan operator SET dengan benar di dalam query UPDATE
            $update = mysqli_query($koneksi, "UPDATE tb_provinsi 
                SET
                nama_provinsi  = '$nama_provinsi', 
                updated_date = '$updated'
                WHERE id_provinsi='$id_provinsi'");

            if ($update) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../data_provinsi.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_provinsi.php";
                        });
                    </script>';
            }


        // Delete
        } elseif (isset($_POST["delete-provinsi"])) {
            $id_provinsi = $_POST['id_provinsi'];

            // Hapus data sales berdasarkan ID
            $delete = mysqli_query($koneksi, "DELETE FROM tb_provinsi WHERE id_provinsi='$id_provinsi'");

            if ($delete) {
                // Hapus folder terkait jika ada
                $path = "../Provinsi/" . $id_provinsi;
                if (file_exists($path) && is_dir($path)) {
                    rmdir($path);
                }

                echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_provinsi.php";
                            });
                        </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menghapus data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_provinsi.php";
                        });
                    </script>';
            }
        }
    ?>
</body>
</html>
