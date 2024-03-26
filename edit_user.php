<?php include "akses.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
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
                        <main id="main" class="main">
                            <section>
                                <?php
                                include "koneksi.php";
                                $id = $_GET['id'];
                                $query = "SELECT tb_user.*, tb_role.role FROM tb_user
                                    LEFT JOIN tb_role ON tb_user.id_role = tb_role.id_role
                                    WHERE id_user = '$id'";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_array($result);
                                $role_id = $data['id_role'];
                                ?>
                                <div class="card shadow p-2">
                                    <form action="proses/proses_user.php" method="POST">
                                        <div class="card-body" style="margin-top: -20px;">
                                            <div class="card-header text-center">
                                                <h5 style="margin-bottom: 30px;"><strong>FORM EDIT USER</strong></h5>
                                                <hr style="margin-bottom: 0px;">
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="card-body">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label for="statusCustomer"><strong>Status User</strong></label>
                                                            <div class="form-check form-check-inline" style="margin-left: 20px;">
                                                                <input class="form-check-input" type="radio" name="status_user" id="inlineRadio1" value="Aktif" <?php echo ($data['status_user'] == 'Aktif') ? 'checked' : ''; ?> required>
                                                                <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status_user" id="inlineRadio2" value="Tidak Aktif" <?php echo ($data['status_user'] == 'Tidak Aktif') ? 'checked' : ''; ?> required>
                                                                <label class="form-check-label" for="inlineRadio2">Tidak Aktif</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="id_user" name="id_user" class="form-control" value="<?php echo $data['id_user']; ?>" required>
                                                        <div class="mt-3">
                                                            <label for="" class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" pattern="[A-Za-z]+" id="user" name="nama_user" value="<?php echo $data['nama_user']?>">
                                                        </div>
                                                        <div class="col-sm mt-3">
                                                            <label for="selectJk" class="form-label">Jenis Kelamin:</label>
                                                            <select class="form-select" id="selectJk" name="jenis_kelamin" value="<?php echo $data['jenis_kelamin']?>">
                                                                <option value="laki-laki" <?php echo ($data['jenis_kelamin'] == 'laki-laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                                <option value="perempuan" <?php echo ($data['jenis_kelamin'] == 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="" class="form-label">Email</label>
                                                            <input type="text" class="form-control bg-white" pattern=".+@.+" id="email" name="email" value="<?php echo $data['email']?>" oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card-body">
                                                        <div class="col-sm mt-3">
                                                            <label class="form-label">Role</label>
                                                            <select class="form-select" id="selectRole" name="selectRole">
                                                                <option value="<?php echo $data['id_role']; ?>"><?php echo $data['role']; ?></option>
                                                                <?php  
                                                                include "koneksi.php";
                                                                $role_query = "SELECT * FROM tb_role";
                                                                $result_role = $koneksi->query($role_query);
                                                                while ($data_role = mysqli_fetch_array($result_role)) {
                                                                ?>
                                                                    <option value="<?php echo $data_role['id_role']; ?>"><?php echo $data_role['role']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']?>">
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="form-label" for="password">Ubah Password</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                            </div>
                                                            <small class="text-muted">Password harus terdiri dari setidaknya 6 karakter dengan kombinasi huruf dan angka.</small>
                                                            <div class="invalid-feedback">
                                                                Password tidak memenuhi persyaratan.
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>">
                                                    </div>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <button type="submit" name="edit-user" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                                    <a href="data_user.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </main><!-- End #main -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        // Inisialisasi Selectize pada elemen input
        var selectizeRole = $('#selectRole').selectize();
        var selectizeJk = $('#selectJk').selectize();

        // Menghubungkan Selectize dengan elemen <select> yang sesungguhnya
        var selectRole = selectizeRole[0].selectize;
        var selectJk = selectizeJk[0].selectize;

        // Set nilai awal untuk selectProvinsi
        selectRole.setValue('<?php echo $role_id; ?>');

        // Manual trigger perubahan untuk memicu pemilihan kota
        selectRole.on('change', function(){
            var selectedRole = selectRole.getValue();
        });

        // Pilih Provinsi secara otomatis untuk memicu perubahan
        selectRole.trigger('change');
    });
</script>
<script>
    document.getElementById('formAuthentication').addEventListener('submit', function (event) {
        var passwordInput = document.getElementById('password');
        var password = passwordInput.value;

        // Contoh validasi di sisi client (JavaScript)
        if (!isValidPassword(password)) {
            passwordInput.setCustomValidity('Password tidak memenuhi persyaratan.');
            event.preventDefault();
        } else {
            passwordInput.setCustomValidity('');
        }
    });

    function isValidPassword(password) {
        // Tambahkan logika validasi sesuai kebutuhan
        // Contoh: minimal 6 karakter dengan kombinasi huruf dan angka
        var regex = /^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]{6,}$/;
        return regex.test(password);
    }
</script>
