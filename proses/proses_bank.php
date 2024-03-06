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

        if (isset($_POST["simpan-bank"])) {
            $id_bank = $_POST['id_bank'];
            $nama_bank = $_POST['nama_bank'];
            $no_rekening = $_POST['no_rekening'];
            $atas_nama = $_POST['atas_nama'];

            $cek_bank = mysqli_query($koneksi, "SELECT nama_bank FROM tb_bank WHERE nama_bank = '$nama_bank'");

            if ($cek_bank->num_rows > 0) {
                $_SESSION['info'] = 'Data Gagal Disimpan';
                header("Location:../data_bank.php");
            } else {
                // Membuat folder baru
                $path = "../Bank/" . $id_bank;
                mkdir($path, 0777, true);

                // Query SQL untuk memasukkan data ke database
                $query_insert = "INSERT INTO tb_bank
                                    (id_bank, nama_bank, no_rekening, atas_nama) 
                                    VALUES ('$id_bank', '$nama_bank', '$no_rekening', '$atas_nama')";

                // Eksekusi query insert
                $result_insert = mysqli_query($koneksi, $query_insert);

                if ($result_insert) {
                    echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil ditambahkan!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_bank.php";
                            });
                          </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal menambahkan data!",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "../data_bank.php";
                            });
                          </script>';
                }
            }

        } elseif (isset($_POST["edit-bank"])) {
            $id_bank = $_POST['id_bank'];
            $nama_bank = $_POST['nama_bank'];
            $no_rekening = $_POST['no_rekening'];
            $atas_nama = $_POST['atas_nama'];

            // Mengambil data lama dari database
            $query = "SELECT * FROM tb_bank WHERE id_bank = '$id_bank'";
            $result = mysqli_query($koneksi, $query);
            $data_lama = mysqli_fetch_assoc($result);

            // Gunakan operator SET dengan benar di dalam query UPDATE
            $update_query = "UPDATE tb_bank 
                SET
                nama_bank  = '$nama_bank', 
                no_rekening = '$no_rekening',
                atas_nama = '$atas_nama'
                WHERE id_bank='$id_bank'";

            $update = mysqli_query($koneksi, $update_query);

            if ($update) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data berhasil diedit!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../data_bank.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal mengedit data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_bank.php";
                        });
                    </script>';
            }

        } elseif (isset($_POST["delete-bank"])) {
            $id_bank = $_POST['id_bank'];

            // Hapus data sales berdasarkan ID
            $delete = mysqli_query($koneksi, "DELETE FROM tb_bank WHERE id_bank='$id_bank'");

            if ($delete) {
                // Hapus folder terkait jika ada
                $path = "../Bank/" . $id_bank; // Assuming 'Bank' folder is in the parent directory
                if (file_exists($path) && is_dir($path)) {
                    rmdir($path);
                }

                echo '<script>
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "../data_bank.php";
                            });
                        </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menghapus data!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_bank.php";
                        });
                    </script>';
            }
        }
    ?>
</body>
</html>