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
    .flex-wrap-table td {
        font-size: 15px; 
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
                        <div class="card mb-4 p-2">
                            <h5 class="card-header text-center"><b>DETAIL INVOICE E-CATALOG</b></h5>
                            <div class="card-body border m-2">
                            <div class="d-flex justify-content-between">
                                <div class="col-6 col-md-2 mt-2 ms-0 d-flex align-items-center">
                                    <div class="demo-inline-spacing mt-4 ms-1">
                                        <span class="badge bg-label-dark"><b>ID PAKET PROYEK :</b> FKS-P2306-5392109</span>
                                    </div>
                                </div>
                                <div class="mt-4 me-3">
                                    <button type="button" class="btn btn-secondary mb-3">E-Catalog</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="card-body border m-1 flex-wrap-table">
                                    <table>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Tgl. Pesanan</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['no_inv'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">No. SPK</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['tgl_inv'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">No. Invoice</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['no_awb'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Tgl. Invoice</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['shipping_by'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Order Via</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['shipping_by'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Nama Paket</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['nama_sp'] ?></td> -->
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-body border m-1 flex-wrap-table">
                                <table>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Nama Sales</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['alamat'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Fee Marketing (%)</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['tgl_est'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 130px">Nama Satker</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['status_pengiriman'] ?> <?php echo $data['tgl_terima'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 100px">Kota & Wilayah</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['keterangan'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 100px">Note Invoice</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['keterangan'] ?></td> -->
                                        </tr>
                                        <tr>
                                            <td class="mb-3" style="width: 100px">Jenis Pengiriman</td>
                                            <td class="p-2 py-0" style="width: 100px; white-space: nowrap;">:</td>
                                            <!-- <td class="p-2" style="width: 350px">: <?php echo $data['keterangan'] ?></td> -->
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            </div>
                            <div class="card-body border mt-2">
                                <div class="row mb-4">
                                    <div class="table-responsive">
                                    <div class="d-flex justify-content-between">
                                        <div class="mt-4 me-3 ms-1">
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="" data-bs-target="#">Halaman Sebelumnya</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="" data-bs-target="#">Ubah Driver</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="" data-bs-target="#">Cetak Invoice</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="" data-bs-target="#">Download PDF</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="" data-bs-target="#">Cetak Kwitansi</button>
                                        </div>
                                        <div class="mt-4 me-3 ms-2 ms-auto d-flex flex-column align-items-start">
                                            <small class="text-light fw-bold mb-2" style="color: your_color_here;">Data ditampilkan :</small>
                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Pilih data ditampilkan</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" data-value="totalInvoice">Total Invoice</a></li>
                                                <li><a class="dropdown-item" href="#" data-value="totalFeeMarketing">Total Fee Marketing</a></li>
                                                <li><a class="dropdown-item" href="#" data-value="totalAkhir">Total Akhir</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-2 col-md-2 total-card" id="totalInvoiceCard">
                                            <div class="card border d-flex flex-column">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="text-center">
                                                        <span class="fw d-block mb-1">Total Invoice</span>
                                                        <h3 class="card-title mb-2">100,000,000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 total-card" id="totalFeeMarketingCard">
                                            <div class="card border d-flex flex-column">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="text-center">
                                                        <span class="fw d-block mb-1">Total Fee Marketing (20%)</span>
                                                        <h3 class="card-title mb-2">50,000,000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 total-card" id="totalAkhirCard">
                                            <div class="card border d-flex flex-column">
                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                    <div class="text-center">
                                                        <span class="fw d-block mb-1">Total Akhir</span>
                                                        <h3 class="card-title mb-2">75,000,000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="mt-0 text-left me-3 ms-2">
                                            <button type="button" class="btn btn-secondary mb-3">Nama Petugas : Adit, Anam, Rudi </button>
                                        </div>
                                        <table class="table table-striped" id="ecat">
                                            <thead>
                                                <tr>
                                                    <th><div>No</div></th>
                                                    <th><div>No SPK</div></th>
                                                    <th><div>Nama Produk</div></th>
                                                    <th><div>Satuan</div></th>
                                                    <th><div>Merk</div></th>
                                                    <th><div>Harga</div></th>
                                                    <th><div>Qty Order</div></th>
                                                    <th><div>Total</div></th>
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
    </div>


    <?php include "page/script.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function () {
        $('#ecat').DataTable();

        // Hide all cards initially except for Total Invoice
        $('.total-card').hide();
        $('#totalInvoiceCard').show();

        // Dropdown menu click event
        $('.dropdown-item').on('click', function () {
            var selectedValue = $(this).data('value');

            // Hide all cards
            $('.total-card').hide();

            // Show the selected card
            $('#' + selectedValue + 'Card').show();

        });

    });
</script>
</body>

</html>
