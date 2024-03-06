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
            if (isset($_POST["simpan-role"])) {
                $id_role = $_POST['id_role'];
                $role = $_POST['role'];

                $cek_role = mysqli_query($koneksi, "SELECT role FROM tb_role WHERE role = '$role'");

                if ($cek_role->num_rows > 0) {
                    $_SESSION['info'] = 'Data Gagal Disimpan';
                    header("Location:../data_role.php");
                } else {
                    // Membuat folder baru
                    $path = "../Role/" . $role;

                    // Query SQL untuk memasukkan data ke database
                    $query_insert = "INSERT INTO tb_role (id_role, role, created_date) VALUES ('$id_role', '$role', NOW())";

                    // Eksekusi query insert
                    $result_insert = mysqli_query($koneksi, $query_insert);

                    if ($result_insert) {
                        echo '<script>
                                Swal.fire({
                                    title: "Sukses!",
                                    text: "Data berhasil ditambahkan!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "../data_role.php";
                                });
                              </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Gagal menambahkan data!",
                                    icon: "error"
                                }).then(function() {
                                    window.location.href = "../data_role.php";
                                });
                              </script>';
                    }
                }

            //Edit
            } elseif (isset($_POST["edit-role"])) {
                $id_role = $_POST['id_role'];
                $role = $_POST['role'];

                // Gunakan operator SET dengan benar di dalam query UPDATE
                $updated = mysqli_query($koneksi, "UPDATE tb_role 
                    SET
                    role  = '$role'
                    WHERE id_role='$id_role'");

                if ($updated) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil diedit!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_role.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal mengedit data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_role.php";
                            });
                        </script>';
                }


            // Delete
            } elseif (isset($_POST["delete-role"])) {
                $id_role = $_POST['id_role'];

                // Hapus data sales berdasarkan ID
                $delete = mysqli_query($koneksi, "DELETE FROM tb_role WHERE id_role='$id_role'");

                if ($delete) {
                    // Hapus folder terkait jika ada
                    $path = "../Role/" . $id_role;
                    if (file_exists($path) && is_dir($path)) {
                        rmdir($path);
                    }

                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_role.php";
                            });
                        </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menghapus data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_role.php";
                            });
                        </script>';
                }
            }
        }
    ?>
</body>
</html>