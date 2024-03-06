<?php include "akses.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php
        date_default_timezone_set('Asia/Jakarta');
    ?>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data User</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" onclick="window.location.href='register.php';">Tambah Data User</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 20%;">Nama User</th>
                                                <th scope="col" style="width: 15%;">Email</th>
                                                <th scope="col" style="width: 15%;">Username</th>
                                                <th scope="col" style="width: 10%;">Role</th>
                                                <th scope="col" style="width: 15%;">Tanggal Dibuat</th>
                                                <th scope="col" style="width: 10%;">Status</th>
                                                <th scope="col" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_role
                                                $query = "SELECT tb_user.*, tb_role.role FROM tb_user
                                                LEFT JOIN tb_role ON tb_user.id_role = tb_role.id_role";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);


                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_user'] . "</td>"; 
                                                    echo "<td>" . $row['email'] . "</td>"; 
                                                    echo "<td>" . $row['username'] . "</td>"; 
                                                    echo "<td>" . $row['role'] . "</td>"; 
                                                    echo "<td>" . $row['created_date'] . "</td>"; 
                                                    echo "<td>" . $row['status_user'] . "</td>"; 
                                                    echo "<td>
                                                            <a href='edit_user.php?id=" . $row['id_user'] . "' class='btn btn-warning btn-sm mt-2 btn-edit'><i class='bx bx-edit-alt'></i></a>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_user'] . "'>
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                        </td>";
                                                    echo "</tr>";
                                                }

                                                mysqli_close($koneksi);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_user.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data User</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus User :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-user" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function () {
        $('table').each(function () {
            new DataTable($(this)[0]);
        });

            $('#addUserForm').on('submit', function(event) {
        event.preventDefault();

        // Mengambil data formulir
        var formData = $("#addUserForm").serialize();

        $('#modalCenter').modal('hide');
        });

        // Plugins Search Select
        $('.normalize').selectize();


        // Function DELETE
        $(document).on('click', '.btn-delete', function() {
        var userId = $(this).data('id');
        var userName = $(this).closest('tr').find('td:nth-child(2)').text();

        // Set ID dan nama role untuk digunakan di tombol "Ya, Hapus"
        $('#modalDeleteBtn').data('id', userId);
        $('#modalDeleteBtn').data('user', userName);

        // Set pesan konfirmasi dengan nama instansi yang akan dihapus
        var modalText = "Apakah anda yakin hapus data User '<b>" + userName + "</b>'?";
        $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="userIdInput" name="id_user" value="' + userId + '" style="display:none;">');

        $('#modalDelete').on('hidden.bs.modal', function() {
        });

        $('#modalDelete').modal('show');
        });


        $('#modalDeleteBtn').on('click', function () {
            var userId = $(this).data('id');
            var userName = $(this).data('user');

            $('#modalDelete').modal('hide');

            // Lakukan operasi hapus di sini menggunakan customerId 
            // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
            console.log("Menghapus data dengan ID:", userId);
            console.log("Instansi yang dihapus:", userName);
        });
    });
    </script>
</body>
</html>