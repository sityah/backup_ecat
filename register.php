<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <style>
        .capitalize {
        text-transform: capitalize;
    }
    </style>
</head>
<!-- Content -->

<div class="container-fluid">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg width="25"></svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">E-Catalog</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <form id="formAuthentication" class="mb-3" method="POST" action="proses/proses_user.php">
                        <?php
                        $uuid = uniqid();
                        $hari = date('d');
                        $tahun = date('y');
                        $useruuid = "USER$uuid$hari$tahun";
                        ?>
                        <input type="hidden" class="form-control" name="id_user" value="<?php echo $useruuid ?>">
                        <input type="hidden" name="status_user" value="Aktif">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control capitalize" pattern="[A-Za-z]+" id="name" name="nama_user"
                                placeholder="Masukkan Nama Lengkap" autofocus />
                        </div>
                        <div class="col-sm mb-3">
                            <label class="form-label"><strong>Jenis Kelamin</strong></label>
                            <select class="form-select normalize" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="1">Laki-Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" pattern=".+@.+" placeholder="Masukkan Email" oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="col-sm mb-3">
                            <label class="form-label"><strong>Level Akses</strong></label>
                            <select class="form-select normalize" name="id_role" required>
                                <option value="">Pilih Level Akses</option>
                                <?php
                                include "koneksi.php";
                                $query_roles = "SELECT id_role, role FROM tb_role";
                                $result_roles = mysqli_query($koneksi, $query_roles);

                                while ($row_role = mysqli_fetch_assoc($result_roles)) {
                                    echo "<option value='" . $row_role['id_role'] . "'>" . $row_role['role'] . "</option>";
                                }
                                mysqli_close($koneksi);
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Masukkan username" autofocus />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <small class="text-muted">Password harus terdiri dari setidaknya 6 karakter dengan kombinasi huruf dan angka.</small>
                            <div class="invalid-feedback">
                                Password tidak memenuhi persyaratan.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100" name="simpan-register">Register</button>
                    </form>
                    <p class="text-center">
                        <span>Already have an account?</span>
                        <a href="login.php">
                            <span>Login</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>

<?php include "page/script.php"; ?>

<script>
    $('.normalize').selectize();
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

</html>
