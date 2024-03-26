<?php include "akses.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <!-- Layout container -->
            <div class="layout-page">
                <?php include "page/navbar.php"; ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                         <div id="coordinates-container"></div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </div>

<?php include "page/script.php"; ?>
</body>
</html>