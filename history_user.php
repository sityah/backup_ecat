<?php
include "akses.php";
?>

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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
    .dataTables_scrollHeadInner table {
        width: 100% !important;
        box-sizing: border-box;
    }
    .table thead th:nth-child(2) {
    width: 500px ; 
    }
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        white-space: nowrap;
    }
</style>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">History User</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama User</th>
                                                <th scope="col">Login Time</th>
                                                <th scope="col">Logout Time</th>
                                                <th scope="col">IP Login</th>
                                                <th scope="col">Jenis Perangkat</th>
                                                <th scope="col">Lokasi</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                $query = "SELECT user_history.id_history, 
                                                tb_user.nama_user, 
                                                user_history.login_time, 
                                                user_history.logout_time, 
                                                user_history.ip_login, 
                                                user_history.jenis_perangkat, 
                                                user_history.lokasi,
                                                user_history.status
                                            FROM user_history
                                            JOIN tb_user ON user_history.id_user = tb_user.id_user";
                                                $result = mysqli_query($koneksi, $query);

                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>"; 
                                                    echo "<td>" . $row['login_time'] . "</td>"; 
                                                    echo "<td>" . $row['logout_time'] . "</td>"; 
                                                    echo "<td>" . htmlspecialchars($row['ip_login']) . "</td>"; 
                                                    echo "<td>" . htmlspecialchars($row['jenis_perangkat']) . "</td>"; 
                                                    echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";  
                                                
                                                    // Menentukan warna dan label berdasarkan status
                                                    $statusText = htmlspecialchars($row['status']);
                                                    $statusBadgeClass = ($row['status'] === 'Online') ? 'badge bg-label-success' : 'badge bg-label-danger';
                                                
                                                    echo "<td><span class='$statusBadgeClass'>$statusText</span></td>";
                                                
                                                    // Check if the logged-in user is viewing their own history
                                                    $loggedInUserId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
                                                    $isCurrentUser = ($loggedInUserId !== null && $row['id_user'] == $loggedInUserId);
                                                
                                                    echo "<td>";
                                                
                                                    // Check if the logged-in user is NOT viewing their own history
                                                    if (!$isCurrentUser) {
                                                        // Check if current IP is not equal to ip_login
                                                        $currentIp = $_SERVER['REMOTE_ADDR'];
                                                        $displayLogoutButton = ($currentIp !== $row['ip_login']) && ($row['status'] !== 'Offline');
                                                
                                                        if ($displayLogoutButton) {
                                                            echo "<a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#logoutModal{$row['id_history']}' onclick=\"\">Logout</a>";
                                                        } else {
                                                            echo "-";
                                                        }
                                                    } else {
                                                        // User is viewing their own history, don't show logout button
                                                        echo "-";
                                                    }
                                                
                                                    echo "</td>";
                                                    echo "</tr>";

                                                    // Modal untuk konfirmasi logout
                                                    echo "<div class='modal fade' id='logoutModal{$row['id_history']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                            <div class='modal-dialog'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header'>
                                                                        <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi Logout</h5>
                                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                    </div>
                                                                    <div class='modal-body'>
                                                                        Apakah Anda yakin ingin logout dengan IP {$row['ip_login']} ?
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                                                        <a href='logout_paksa.php?id_off={$row['id_history']}' class='btn btn-danger'>Ya, Logout</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>";
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

    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('table').each(function () {
                new DataTable($(this)[0],{
                scrollX: true,
            });
            });
        });
    </script>
</body>
</html>
