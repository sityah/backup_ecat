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
            if (isset($_POST["simpan-kota"])) {
                $id_kota_kab = $_POST['id_kota_kab'];
                $id_provinsi = $_POST['id_provinsi_select'];
                $nama_kota_kab = $_POST['nama_kota_kab'];

                $cek_kota = mysqli_query($koneksi, "SELECT nama_kota_kab FROM tb_kota WHERE nama_kota_kab = '$nama_kota_kab'");

                if ($cek_kota->num_rows > 0) {
                    $_SESSION['status1'] = 'Data Gagal Disimpan';
                    header("Location:../data_kota.php");
                } else {
                    // Membuat folder baru
                    $path = "../Kota/" . $id_kota_kab;
                    mkdir($path, 0777, true);

                    // Query SQL untuk memasukkan data ke database
                    $query_insert = "INSERT INTO tb_kota
                                        (id_kota_kab, id_provinsi, nama_kota_kab, created_date) 
                                        VALUES ('$id_kota_kab', '$id_provinsi', '$nama_kota_kab', NOW())";

                    // Eksekusi query insert
                    $result_insert = mysqli_query($koneksi, $query_insert);

                    if ($result_insert) {
                        echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Data berhasil ditambahkan!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../data_kota.php";
                                });
                              </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Gagal menambahkan data!",
                                    icon: "error"
                                }).then(function() {
                                    window.location.href = "../data_kota.php";
                                });
                              </script>';
                    }
                }

            // Edit
            } elseif (isset($_POST["edit-kota"])) {
                $id_kota_kab = $_POST['id_kota_kab'];
                $id_provinsi = $_POST['selectProvinsi'];
                $nama_kota_kab = $_POST['nama_kota_kab'];
                $update = date("Y-m-d H:i:s");

                $update_query = "UPDATE tb_kota 
                    SET
                    nama_kota_kab  = '$nama_kota_kab', 
                    id_provinsi  = '$id_provinsi', 
                    update_date = '$update'
                    WHERE id_kota_kab='$id_kota_kab'";

                $update = mysqli_query($koneksi, $update_query);

                if ($update) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil diedit!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_kota.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal mengedit data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_kota.php";
                            });
                        </script>';
                }
            }

            // Delete
            elseif (isset($_POST["delete-kota"])) {
                $id_kota_kab = $_POST['id_kota_kab'];

                // Hapus data sales berdasarkan ID
                $delete = mysqli_query($koneksi, "DELETE FROM tb_kota WHERE id_kota_kab='$id_kota_kab'");

                if ($delete) {
                    // Hapus folder terkait jika ada
                    $path = "../Kota/" . $id_kota_kab;
                    if (file_exists($path) && is_dir($path)) {
                        rmdir($path);
                    }

                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_kota.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_kota.php";
                            });
                        </script>';
                }
            }
        } 
    ?>
</body>
</html>