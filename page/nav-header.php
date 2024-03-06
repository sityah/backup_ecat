<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sertakan bagian head content Anda di sini -->
    <style>
        .breadcrumb {
            display: flex;
            flex-wrap: nowrap;
            white-space: nowrap;
            margin-right: auto;
        }
    </style>
</head>
<body>
<?php
// Fungsi untuk menghasilkan breadcrumb dinamis
function generateBreadcrumb() {
    echo '<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">';
    echo '<ol class="breadcrumb mb-0 p-0 ms-0">';
    echo '<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>';

    // Dapatkan nama halaman saat ini
    $currentPage = basename($_SERVER['PHP_SELF']);

    // Jika ada parameter GET, tambahkan breadcrumb untuk parameter tersebut
    if (!empty($_GET)) {
        $currentPage .= '?' . http_build_query($_GET);
    }

    // Tambahkan item breadcrumb untuk halaman saat ini
    echo '<li class="breadcrumb-item active"><a href="' . $currentPage . '">' . ucwords(str_replace('_', ' ', pathinfo($currentPage, PATHINFO_FILENAME))) . '</a></li>';

    echo '</ol>';
}

// Panggil fungsi untuk menghasilkan breadcrumb
generateBreadcrumb();
?>

<!-- Navbar dengan Profil Pengguna -->
<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Tautan "Selamat Datang" -->
        <li class="nav-item lh-1 me-3">
            <?php
            if (isset($_SESSION['tiket_nama'])) {
                $capitalizedName = ucwords($_SESSION['tiket_nama']);
                    echo "Selamat Datang, <strong>" . $capitalizedName . "</strong>";
                } else {
                    echo "Selamat Datang";
                }
            ?>
        </li>

        <!-- Profil Pengguna Dropdown -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="assets/img/avatars/2.png" alt class="w-px-40 h-auto rounded-circle" />
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="assets/img/avatars/2.png" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">
                                    <?php
                                    if (isset($_SESSION['tiket_nama'])) {
                                        echo ucwords($_SESSION['tiket_nama']);
                                    } else {
                                        echo "Nama Pengguna";
                                    }
                                    ?>
                                </span>
                                <small class="text-muted">
                                    <?php
                                    if (isset($_SESSION['nama_role'])) {
                                        $nama_role = $_SESSION['nama_role'];
                                        // Tampilkan role_name sesuai kebutuhan Anda
                                        echo "$nama_role";
                                    } else {
                                        // Jika sesi tiket_role tidak diatur
                                        echo "Role not available";
                                    }
                                    ?>
                                </small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <!-- Tautan untuk keluar -->
                <li>
                    <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/ Profil Pengguna Dropdown -->
    </ul>
</div>
<!--/ Navbar dengan Profil Pengguna -->

</nav>

</body>
</html>
