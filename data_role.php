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
<style>
    .capitalize {
        text-transform: capitalize;
    }
</style>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Role</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 40%;">Nama Role</th>
                                                <th scope="col" style="width: 40%;">Tanggal Dibuat</th>
                                                <th scope="col" style="width: 15%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_role
                                                $query = "SELECT * FROM tb_role";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);


                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['role'] . "</td>"; 
                                                    echo "<td>" . $row['created_date'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                data-id='" . $row['id_role'] . "'    
                                                                data-role='" . $row['role'] . "'
                                                                data-updatedby='" . $row['updated_by'] . "'
                                                                data-updated='" . $row['updated_date'] . "'>
                                                                <i class='bx bx-edit-alt'></i>
                                                            </button>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_role'] . "'>
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


    <!-- Modal Input -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Role</h5>
            </div>
            <div class="modal-body">
                <!-- Formulir untuk menambah data role -->
                <form action="proses/proses_role.php" method="POST">
                <?php 
                  $uuid = generateUUID(); 
                  $hari = date('d');
                  $tahun = date('y');
                  $roleuuid = "ROLE$uuid$hari$tahun";
                ?>
                    <input type="hidden" class="form-control" name="id_role" id="id" value = "<?php echo $roleuuid ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama Role *</label>
                            <input type="text" name="role" class="form-control capitalize" placeholder="Tulis Nama Role" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-role">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/vendor/selectize-js/dist/js/selectize.min.js"></script>
    <script>
        $('.normalize2').selectize();
    </script>
    

    <?php
function generateUUID() {
    // Generate 16 bytes of random data
    $data = random_bytes(16);

    // Set the version (4) and variant (0100)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert the binary data to a hexadecimal string
    $uuid = vsprintf('%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
}

?>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_role.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Role</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus Role :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-role" id="modalDeleteBtn">Ya, Hapus</button>
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

            $('#addRoleForm').on('submit', function(event) {
        event.preventDefault();

        // Mengambil data formulir
        var formData = $("#addRoleForm").serialize();

        $('#modalCenter').modal('hide');
        });

        // Plugins Search Select
        $('.normalize').selectize();


        // Function DELETE
        $(document).on('click', '.btn-delete', function() {
        var roleId = $(this).data('id');
        var role = $(this).closest('tr').find('td:nth-child(2)').text();

        // Set ID dan nama role untuk digunakan di tombol "Ya, Hapus"
        $('#modalDeleteBtn').data('id', roleId);
        $('#modalDeleteBtn').data('role', role);

        // Set pesan konfirmasi dengan nama instansi yang akan dihapus
        var modalText = "Apakah anda yakin hapus data Role '<b>" + role + "</b>'?";
        $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="roleIdInput" name="id_role" value="' + roleId + '" style="display:none;">');

        $('#modalDelete').on('hidden.bs.modal', function() {
        });

        $('#modalDelete').modal('show');
        });


        $('#modalDeleteBtn').on('click', function () {
            var roleId = $(this).data('id');
            var role = $(this).data('role');

            $('#modalDelete').modal('hide');

            // Lakukan operasi hapus di sini menggunakan customerId 
            // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
            console.log("Menghapus data dengan ID:", roleId);
            console.log("Instansi yang dihapus:", role);
        });
    });
    </script>
</body>
</html>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTitle">Edit Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="proses/proses_role.php" method="POST">
                    <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_role" name="id_role" class="form-control" value="<?php echo $data_lama['id_role']; ?>" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Role</label>
                                <input type="text" id="role" name="role" class="form-control capitalize" required>
                            </div>
                        </div>
                        <input type="text" name="update" class="form-control" value="<?php echo date('d/m/y h:i:s') ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-role">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Handler Tombol Edit
    $('.btn-edit').on('click', function () {
        // Mendapatkan data dari tombol yang ditekan
        var id = $(this).data('id');
        var role = $(this).data('role');
        var createdby = $(this).data('createdby');
        var created = $(this).data('created');
        var updateby = $(this).data('updateby');
        var updated = $(this).data('updated');

        // Set values for the edit form
        $('#id_role').val(id);
        $('#role').val(role);

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });
    $('.normalize').selectize();
        </script>


