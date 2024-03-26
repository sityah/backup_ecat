<?php include "akses.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <style>
        /* Tambahkan CSS berikut untuk mengatur lebar maksimum pada kolom tabel */
        #ecat th, #ecat td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
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
                        <div class="card mb-4">
                            <h5 class="card-header"><b>Transaksi E-Cat Customer</b></h5>
                            <div class="card-body">
                            <div class="row mb-4">
                                <!-- Filter Tanggal dan Filter Status -->
                                <div class="row mb-4">
                                    <div class="col-md-3 mb-3">
                                        <label>Filter Sesuai Periode :</label><br>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" style="min-width: 300px" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php
                                                // Menentukan teks yang ditampilkan berdasarkan nilai dari parameter date_range
                                                $selectedOption = isset($_GET['date_range']) ? $_GET['date_range'] : 'today';
                                                if ($selectedOption === "today") {
                                                echo "Hari ini";
                                                } elseif ($selectedOption === "weekly") {
                                                echo "Minggu ini";
                                                } elseif ($selectedOption === "monthly") {
                                                echo "Bulan ini";
                                                } elseif ($selectedOption === "lastMonth") {
                                                echo "Bulan Kemarin";
                                                } elseif ($selectedOption === "year") {
                                                echo "Tahun ini";
                                                } elseif ($selectedOption === "lastyear") {
                                                echo "Tahun Lalu";
                                                } else {
                                                echo "Pilih Tanggal";
                                                }
                                            ?>
                                            </button>
                                            <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                                <form action="" method="GET" class="form-group newsletter-group" id="resetLink">
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'today' ? 'active' : ''; ?>" href="?date_range=today">Hari ini</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'weekly' ? 'active' : ''; ?>" href="?date_range=weekly">Minggu ini</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'monthly' ? 'active' : ''; ?>" href="?date_range=monthly">Bulan ini</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastMonth' ? 'active' : ''; ?>" href="?date_range=lastMonth">Bulan Kemarin</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'year' ? 'active' : ''; ?>" href="?date_range=year">Tahun ini</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastyear' ? 'active' : ''; ?>" href="?date_range=lastyear">Tahun Lalu</a>
                                                    <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'pilihTanggal' ? 'active' : ''; ?>">Pilih Tanggal</a>
                                                </form>
                                                <li><hr class="dropdown-divider"></li>
                                                <form action="" method="GET" class="form-group newsletter-group" id="dateForm">
                                                    <div class="row p-2">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="start_date">From</label>
                                                        <input type="date" id="startDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="start_date">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="end_date">To</label>
                                                        <input type="date" id="endDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="end_date">
                                                    </div>
                                                    <input type="hidden" name="date_range" value="pilihTanggal">
                                                    </div>
                                                    
                                                    <!-- Add the submit button with name="tampilkan" -->
                                                    <a href="finance-inv.php?date_range=weekly" name="tampilkan" class="custom-dropdown-item dropdown-item rounded bg-danger text-white" id="resetLink">Reset</a>
                                                </form>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const endDateInput = document.getElementById('endDate');
                                                        const startDateInput = document.getElementById('startDate');
                                                        const dateForm = document.getElementById('dateForm');
                                                        const resetLink = document.getElementById('resetLink');

                                                        // Cek apakah data tanggal tersimpan di localStorage
                                                        const savedStartDate = localStorage.getItem('startDate');
                                                        const savedEndDate = localStorage.getItem('endDate');

                                                        if (savedStartDate) {
                                                            startDateInput.value = savedStartDate;
                                                        }

                                                        if (savedEndDate) {
                                                            endDateInput.value = savedEndDate;
                                                        }

                                                        startDateInput.addEventListener('change', () => {
                                                            const startDateValue = new Date(startDateInput.value);
                                                            const maxEndDateValue = new Date(startDateValue);
                                                            maxEndDateValue.setDate(maxEndDateValue.getDate() + 30);

                                                            endDateInput.value = ''; // Reset nilai endDate

                                                            endDateInput.min = startDateValue.toISOString().split('T')[0];
                                                            endDateInput.max = maxEndDateValue.toISOString().split('T')[0];

                                                            endDateInput.disabled = false; // Aktifkan kembali input endDate
                                                        });

                                                        endDateInput.addEventListener('change', () => {
                                                            const startDateValue = new Date(startDateInput.value);
                                                            const endDateValue = new Date(endDateInput.value);

                                                            const daysDifference = Math.floor((endDateValue - startDateValue) / (1000 * 60 * 60 * 24));

                                                            if (daysDifference > 30) {
                                                                endDateInput.value = '';
                                                            }

                                                            startDateInput.value = startDateValue.toISOString().split('T')[0]; // Menampilkan pada field startDate
                                                            endDateInput.value = endDateValue.toISOString().split('T')[0]; // Menampilkan pada field endDate

                                                            const queryParams = new URLSearchParams({
                                                                start_date: startDateValue.toISOString().split('T')[0],
                                                                end_date: endDateValue.toISOString().split('T')[0],
                                                                date_range: 'pilihTanggal'
                                                            });

                                                            const newUrl = `invoice-komplain.php?${queryParams.toString()}`;

                                                            dateForm.action = newUrl;
                                                            dateForm.submit();

                                                            // Simpan tanggal ke localStorage
                                                            localStorage.setItem('startDate', startDateInput.value);
                                                            localStorage.setItem('endDate', endDateInput.value);
                                                        });

                                                        resetLink.addEventListener('click', () => {
                                                            // Hapus data dari localStorage
                                                            localStorage.removeItem('startDate');
                                                            localStorage.removeItem('endDate');

                                                            // Hapus nilai dari field input
                                                            startDateInput.value = '';
                                                            endDateInput.value = '';
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div> 
                                    <!-- Filter Wilayah (Provinsi) -->
                                    <div class="col-md-2">
                                        <label>Filter Wilayah :</label>
                                        <select class="form-select normalize2" name="id_provinsi" required>
                                            <option value="">Pilih Wilayah</option>
                                            <?php 
                                                include "koneksi.php";
                                                $query_provinsi = "SELECT * from tb_provinsi";
                                                $result_provinsi = mysqli_query($koneksi, $query_provinsi);
                                                    while ($data_provinsi = mysqli_fetch_array($result_provinsi )){?>
                                                <option value="<?php echo $data_provinsi['id_provinsi']?>"><?php echo $data_provinsi['nama_provinsi']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>   
                                </div>   
                                
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1">Total TS</span>
                                                <h3 class="card-title mb-2">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1">Total Customer</span>
                                                <h3 class="card-title mb-2">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1">Total Nominal TS</span>
                                                <h3 class="card-title mb-2">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1">Total Fee Marketing</span>
                                                <h3 class="card-title mb-2">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1 text-xs">Total Pending TS</span>
                                                <h3 class="card-title mb-2 text-xs">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <span class="fw d-block mb-1">Total Cancel TS</span>
                                                <h3 class="card-title mb-2">1,000</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th><div>No</div></th>
                                                <th><div>Nama Institusi</div></th>
                                                <th><div>Wilayah</div></th>
                                                <th><div>Total Transaksi PL</div></th>
                                                <th><div>Total Transaksi LKPP</div></th>
                                                <th><div>Transaksi Selesai</div></th>
                                                <th><div>Transaksi Pending</div></th>
                                                <th><div>Total Nominal TS</div></th>
                                                <th><div>Total Nominal Pending</div></th>
                                                <th><div>Total Tagihan TS</div></th>
                                                <th><div>Aksi</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
        $('table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
        } );
    </script>
</body>
</html>
