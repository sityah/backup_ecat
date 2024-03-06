<?php include "akses.php" ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalogue</title>
    <?php include "page/header.php"; ?>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4 p-2">
                            <h5 class="card-header text-center"><b>DETAIL PRODUK SPK E-CATALOG</b></h5>
                            <div class="card-body border m-2">
                            <div class="mt-4 text-end me-3">
                                <button type="button" class="btn btn-secondary mb-3">E-Catalog</button>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_spk_ecat'])) {
                                        $spkId = $_GET['id_spk_ecat'];

                                        $sql = "
                                                SELECT
                                                tb_spk_ecat.tgl_pesanan_ecat,
                                                tb_spk_ecat.no_spk_ecat,
                                                tb_spk_ecat.tgl_spk_ecat,
                                                tb_spk_ecat.no_paket,
                                                tb_spk_ecat.nama_paket,
                                                tb_spk_ecat.fee_marketing,
                                                tb_sales_ecat.nama_sales,
                                                tb_perusahaan.nama_perusahaan,
                                                tb_perusahaan.alamat_perusahaan,
                                                tb_provinsi.nama_provinsi
                                            FROM
                                                tb_spk_ecat
                                            JOIN
                                                tb_sales_ecat ON tb_spk_ecat.id_sales = tb_sales_ecat.id_sales
                                            JOIN
                                                tb_perusahaan ON tb_spk_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                                            JOIN
                                                tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                            WHERE
                                                tb_spk_ecat.id_spk_ecat = '$spkId'
                                    
                                        ";

                                        $result = mysqli_query($koneksi, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            echo '
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table> 
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. Pesanan</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_pesanan_ecat"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">No. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_spk_ecat"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_spk_ecat"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">ID Paket</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_paket"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Nama Paket</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_paket"] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Satuan Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_perusahaan"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Alamat Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["alamat_perusahaan"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Wilayah Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_provinsi"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Sales</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_sales"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Fee Marketing (%)</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["fee_marketing"] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            ';
                                        }
                                    } else {
                                        echo "Tidak ada data yang ditemukan";
                                    }
                                    
                                    mysqli_close($koneksi);

                                ?>
                            </div>
                            <form id="insertForm" method="post" action="proses/update_nama_petugas.php">
                                <input type="hidden" name="id_spk_ecat" value="<?php echo $spkId; ?>">
                                <div class="card-body border mt-2 mb-4">
                                    <div class="row mb-4">
                                        <div class="table-responsive">
                                            <button type="button" class="btn btn-primary mb-3" onclick="window.location.href = 'spk_dalam_proses.php';"><i class="tf-icons bx bxs-chevrons-left"></i> Kembali</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" id="btnProsesPesanan" data-spkid="<?php echo $spkId; ?>" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                                                <i class="tf-icons bx bx-package"></i> Siap Kirim
                                            </button>
                                            
                                            <!-- Modal Input Nama Petugas -->
                                            <div class="modal fade" id="inputNamaPetugasModal" tabindex="-1" aria-labelledby="inputNamaPetugasModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="inputNamaPetugasModalLabel">Input Nama Petugas</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="inputNamaPetugasForm" method="post" action="proses/update_nama_petugas.php">
                                                            <input type="hidden" name="spkId" value="<?php echo $spkId; ?>">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="namaPetugas" class="form-label">Nama Petugas</label>
                                                                    <input type="text" class="form-control" id="namaPetugas" name="namaPetugas" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" id="siapDikirimBtn">Siap Dikirim</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-striped" id="selectedProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 5%;">No</th>
                                                        <th scope="col" style="width: 35%;">Nama Produk</th>
                                                        <th scope="col" style="width: 10%;">Satuan</th>
                                                        <th scope="col" style="width: 15%;">Merk</th>
                                                        <th scope="col" style="width: 15%;">Harga</th>
                                                        <th scope="col" style="width: 15%;">Quantity</th>
                                                        <th scope="col" style="width: 5%;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        include "koneksi.php";
                                                        $query = "SELECT 
                                                                    sr.id_spk_ecat,
                                                                    sr.status_spk_ecat,
                                                                    tps.id_transaksi_ecat,
                                                                    tps.id_produk,
                                                                    spr.stock, 
                                                                    tpr.nama_produk, 
                                                                    tpr.satuan,
                                                                    tps.qty,
                                                                    tps.status_trx,
                                                                    tpr.harga_produk,
                                                                    tm.nama_merk
                                                                FROM 
                                                                    db_ecat.transaksi_produk_ecat AS tps
                                                                LEFT JOIN 
                                                                    db_ecat.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk
                                                                LEFT JOIN 
                                                                    db_inventory.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                                                WHERE 
                                                                    sr.id_spk_ecat = '$spkId' AND sr.status_spk_ecat = 'Dalam Proses'";
                                                        $result = mysqli_query($koneksi, $query);

                                                        // Hasil query
                                                        $no = 1;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>";
                                                            echo "<th scope='row'>" . $no++ . "</th>";
                                                            echo "<td>" . $row['nama_produk'] . "</td>"; 
                                                            echo "<td>" . $row['satuan'] . "</td>";  
                                                            echo "<td>" . $row['nama_merk'] . "</td>"; 
                                                            echo "<td>" . number_format($row['harga_produk'], 0, ',', '.') . "</td>"; 
                                                            echo "<td>" . $row['qty'] . "</td>"; 
                                                            echo "<td>
                                                                    <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_transaksi_ecat'] . "' data-nama='" . $row['nama_produk'] . "'>
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
                            </form>
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
    <script>
        function formatNumber(input) {
            return Number(input).toLocaleString('id-ID'); 
        }

        var hargaInputs = document.querySelectorAll('[id^="harga_"]');

        hargaInputs.forEach(function(inputElement) {
            var textValue = inputElement.value;
            
            inputElement.value = formatNumber(textValue);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectedProductsTable').DataTable();
        });
    </script>
    <script>
        const btnProsesPesanan = document.getElementById('btnProsesPesanan');

        btnProsesPesanan.addEventListener('click', function() {
            const inputNamaPetugasModal = new bootstrap.Modal(document.getElementById('inputNamaPetugasModal'));
            inputNamaPetugasModal.show();
        });
    </script>


    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="proses/dalam_proses.php">
                    <input type="hidden" name="id_spk_ecat" value="<?php echo $id_spk_ecat; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_transaksi_ecat" id="idToDelete">
                        <input type="hidden" id="namaProdukToDelete" name="nama_produk">
                        Apakah Anda yakin ingin menghapus produk <strong><span id="productName"></span></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" name="delete-produk">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).on("click", ".btn-delete", function() {
            var idToDelete = $(this).data('id'); 
            var namaProduk = $(this).data('nama');
            $("#idToDelete").val(idToDelete); 
            $("#namaProdukToDelete").val(namaProduk); 
            $("#productName").text(namaProduk);
            $("#deleteModal").modal('show');
        });
    </script>
</body>
</html>