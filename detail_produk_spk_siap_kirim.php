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
                            <div class="mt-4 text-center">
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit Details</button>
                            </div>
                            <form id="insertForm" method="post" action="proses/update_nama_petugas.php">
                                <input type="hidden" name="id_spk_ecat" value="<?php echo $spkId; ?>">
                                <div class="card-body border mt-2 mb-4">
                                    <div class="row mb-4">
                                        <div class="table-responsive">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = 'spk_siap_kirim.php';"><i class="tf-icons bx bxs-chevrons-left"></i> Kembali</button>
                                                <?php
                                                    // Mengambil nama petugas dari tb_spk_ecat
                                                    include "koneksi.php";
                                                    $query_petugas = "SELECT petugas_ecat FROM tb_spk_ecat WHERE id_spk_ecat = '$spkId'";
                                                    $result_petugas = mysqli_query($koneksi, $query_petugas);
                                                    $row_petugas = mysqli_fetch_assoc($result_petugas);
                                                    $nama_petugas = $row_petugas['petugas_ecat'];
                                                    echo "<button type='button' class='btn btn-secondary badge'>";
                                                    echo "<i class='bx bxs-user'></i> <b>Petugas : $nama_petugas</b>";
                                                    echo "</button>";
                                                    mysqli_close($koneksi);
                                                ?>
                                            </div>

                                            <table class="table table-striped" id="selectedProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 5%;">No</th>
                                                        <th scope="col" style="width: 40%;">Nama Produk</th>
                                                        <th scope="col" style="width: 10%;">Satuan</th>
                                                        <th scope="col" style="width: 10%;">Merk</th>
                                                        <th scope="col" style="width: 10%;">Harga</th>
                                                        <th scope="col" style="width: 10%;">Quantity</th>
                                                        <th scope="col" style="width: 15%;">Total Harga</th>
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
                                                                    tps.total_harga,
                                                                    tpr.harga_produk,
                                                                    tm.nama_merk
                                                                FROM 
                                                                    mandir36_db_ecat_staging.transaksi_produk_ecat AS tps
                                                                LEFT JOIN 
                                                                    mandir36_db_ecat_staging.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk
                                                                LEFT JOIN 
                                                                    mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                                                WHERE 
                                                                    sr.id_spk_ecat = '$spkId' AND tps.status_trx = 0";
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
                                                            echo "<td>" . number_format($row['total_harga'], 0, ',', '.') . "</td>"; 
                                                            echo "<td>" . $row['qty'] . "</td>"; 
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

    <?php
        include "koneksi.php"; 

        // Ambil id_spk_ecat dari URL
        $id_spk_ecat = $_GET['id_spk_ecat'];

        // Buat query SQL untuk mengambil data lama dari database
        $query_select = "SELECT * FROM tb_spk_ecat WHERE id_spk_ecat = '$id_spk_ecat'";
        $result_select = mysqli_query($koneksi, $query_select);

        // Cek apakah data ditemukan
        if(mysqli_num_rows($result_select) > 0) {
            $data = mysqli_fetch_assoc($result_select);
            // Memasukkan nilai-nilai dari data lama ke dalam variabel
            $tgl_spk_ecat = $data['tgl_spk_ecat'];
            $id_sales = $data['id_sales'];
            $fee_marketing = $data['fee_marketing'];
        }

        // Buat query SQL untuk mendapatkan daftar nama sales yang aktif
        $query_sales = "SELECT id_sales, nama_sales FROM tb_sales_ecat WHERE status_sales = 'Aktif'";
        $result_sales = mysqli_query($koneksi, $query_sales);
    ?>
    <!-- Modal Edit Details -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTitle">Edit Details</h5>
                </div>
                <form action="proses/edit_details.php" method="POST">
                    <input type="hidden" name="id_spk_ecat" value="<?php echo $id_spk_ecat; ?>">
                    <div class="modal-body">
                        <div class="mb-3 mt-2">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Tanggal SPK</label>
                                    <input type="date" id="tgl_spk_ecat" name="tgl_spk_ecat" class="form-control" value="<?php echo $tgl_spk_ecat; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Nama Sales *</label>
                                    <select class="form-select normalize" name="id_sales" required>
                                        <option value="">Pilih Sales</option>
                                        <?php
                                        // Sekarang, dalam loop ini, Anda dapat menetapkan atribut 'selected' untuk opsi yang cocok dengan data lama
                                        while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                                            $selected = ($row_sales['id_sales'] == $id_sales) ? "selected" : "";
                                            echo "<option value='" . $row_sales['id_sales'] . "' $selected>" . $row_sales['nama_sales'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Fee Marketing</label>
                                    <input type="text" id="fee_marketing" name="fee_marketing" class="form-control" value="<?php echo $fee_marketing; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit-produk">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="proses/dalam_proses.php">
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