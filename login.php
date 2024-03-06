<?php
session_start();
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
</head>
<body>

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg width="25" viewBox="0 0 25 42" version="1.1">
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">E-Catalog</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Welcome to E-Catalog! 👋</h4>
                    <form id="formAuthentication" class="mb-3" method="POST" action="proses_login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Email or Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Email atau Username" autofocus required />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <!-- Pesan kesalahan -->
                        <?php
                        if (isset($_SESSION['login_error'])) {
                            echo '<p style="color: red; font-size: 14px; font-weight;">' . $_SESSION['login_error'] . '</p>';
                            unset($_SESSION['login_error']); 
                        }
                        ?>
                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "page/script.php"; ?>

</body>
</html>
