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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h5 class="card-header text-center"><b>DETAIL INVOICE PENUNJUKKAN LANGSUNG</b></h5>
                            <div class="card-body border m-2">
                            <div class="mt-4 text-end me-3">
                                <button type="button" class="btn btn-secondary mb-3">Penunjukkan Langsung</button>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_inv_pl'])) {
                                        $id_inv_pl = $_GET['id_inv_pl'];

                                        $sql = "SELECT
                                                tb_spk_pl.tgl_pesanan_pl,
                                                COALESCE(GROUP_CONCAT(tb_spk_pl.no_spk_pl SEPARATOR ', '), 'N/A') AS no_spk_pl,
                                                tb_spk_pl.no_po,
                                                tb_spk_pl.fee_marketing,
                                                tb_sales_ecat.nama_sales,
                                                tb_perusahaan.nama_perusahaan,
                                                tb_perusahaan.alamat_perusahaan,
                                                tb_provinsi.nama_provinsi,
                                                inv_pl.no_inv_pl,
                                                inv_pl.tgl_inv_pl,
                                                inv_pl.notes
                                            FROM
                                                inv_pl
                                            LEFT JOIN
                                                tb_spk_pl ON inv_pl.id_inv_pl = tb_spk_pl.id_inv_pl
                                            LEFT JOIN
                                                tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                                            LEFT JOIN
                                                tb_perusahaan ON tb_spk_pl.id_perusahaan = tb_perusahaan.id_perusahaan
                                            LEFT JOIN
                                                tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                            WHERE
                                                inv_pl.id_inv_pl = '$id_inv_pl' AND
                                                tb_spk_pl.status_spk_pl = 'Invoice Dibuat'
                                            GROUP BY
                                                inv_pl.id_inv_pl";

                                        $result = mysqli_query($koneksi, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            echo '
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table> 
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. Pesanan</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_pesanan_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">No. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_spk_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">No. Invoice</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_inv_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Tgl. Invoice</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_inv_pl"] . '</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="card-body border m-1 flex-wrap-table" style="flex: 1;">
                                                    <table>
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
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Satuan Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_perusahaan"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Wilayah Kerja</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["nama_provinsi"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">Note Invoice</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["notes"] . '</td>
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

                            <form id="insertForm" method="post" action="proses/proses_kirim_pl.php">
                                <input type="hidden" id="no_inv_pl" name="no_inv_pl" value="<?php echo $id_inv_pl; ?>">
                                <div class="card-body border mt-2 mb-4">
                                    <div class="row mb-4">
                                        <div class="table-responsive">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div class="">
                                                    <button type="button" class="btn btn-primary" onclick="window.location.href = 'spk_pl_invoice_dicetak.php';">
                                                        <i class="tf-icons bx bxs-chevrons-left"></i> Kembali
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahData">
                                                        <i class="tf-icons bx bx-plus-circle"></i> Tambah SPK
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary" id="btnProsesPesanan" data-inv="<?php echo $id_inv_pl; ?>" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                                                        <i class="tf-icons bx bx-package"></i> Proses Dikirim
                                                    </button>
                                                    <!-- Modal Proses Kirim -->
                                                    <div class="modal fade" id="inputNamaPetugasModal" tabindex="-1" aria-labelledby="inputNamaPetugasModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="inputNamaPetugasModalLabel">Proses Dikirim</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form id="inputNamaPetugasForm" method="post" action="proses/proses_kirim_pl.php">
                                                                    <input type="hidden" id="id_inv_pl" name="id_inv_pl" value="<?php echo $id_inv_pl; ?>">
                                                                    <input type="hidden" class="form-control" name="id_status_kirim">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"><strong>Jenis Pengiriman</strong></label>
                                                                            <select class="form-select" id="id_status_kirim" name="jenis_pengiriman">
                                                                                <option value="">Pilih Jenis Pengiriman</option>
                                                                                <option value="1">Diambil Langsung</option>
                                                                                <option value="2">Driver</option>
                                                                                <option value="3">Ekspedisi</option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="langsungForm">
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_langsung" name="tgl_kirim_langsung" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div id="driverForm">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Pilih Driver</strong></label>
                                                                                <select class="form-select" id="id_driver" name="id_driver">
                                                                                    <option value="">Pilih Driver</option>
                                                                                    <?php
                                                                                    include "koneksi.php";
                                                                                    $query_driver = "SELECT id_driver, nama_driver FROM tb_driver";
                                                                                    $result_driver = mysqli_query($koneksi, $query_driver);
                                                                                    while ($data_driver = mysqli_fetch_array($result_driver)) {
                                                                                        echo '<option value="' . $data_driver['id_driver'] . '">' . $data_driver['nama_driver'] . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_driver" name="tgl_kirim_driver" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div id="ekspedisiForm" style="display: none;">
                                                                            <input type="hidden" id="id_status_kirim" name="id_status_kirim">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Pilih Ekspedisi</strong></label>
                                                                                <select class="form-select" id="id_ekspedisi" name="id_ekspedisi">
                                                                                    <option value="">Pilih Ekspedisi</option>
                                                                                    <?php
                                                                                        include "koneksi.php";
                                                                                        $query_ekspedisi = "SELECT id_ekspedisi, nama_ekspedisi FROM ekspedisi";
                                                                                        $result_ekspedisi = mysqli_query($koneksi, $query_ekspedisi);
                                                                                        while ($data_ekspedisi = mysqli_fetch_array($result_ekspedisi)) {
                                                                                            echo '<option value="' . $data_ekspedisi['id_ekspedisi'] . '">' . $data_ekspedisi['nama_ekspedisi'] . '</option>';
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Dikirim Oleh</strong></label>
                                                                                <input type="text" id="dikirim_oleh" name="dikirim_oleh" class="form-control">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong>Penanggung Jawab</strong></label>
                                                                                <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="form-control">
                                                                            </div>
                                                                            <div class="col mb-3">
                                                                                <label class="form-label">Tanggal Kirim</label>
                                                                                <input type="date" id="tgl_kirim_ekspedisi" name="tgl_kirim_ekspedisi" class="form-control">
                                                                            </div>
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
                                                </div>
                                                <?php
                                                    include "koneksi.php";

                                                    $query_spk_id = "SELECT tb_spk_pl.id_spk_pl 
                                                                    FROM inv_pl 
                                                                    LEFT JOIN tb_spk_pl ON inv_pl.id_inv_pl = tb_spk_pl.id_inv_pl 
                                                                    WHERE tb_spk_pl.id_inv_pl = '$id_inv_pl'";
                                                    $result_spk_id = mysqli_query($koneksi, $query_spk_id);
                                                    $nama_petugas_array = array(); 

                                                    // Hasil query untuk mendapatkan semua nama petugas yang terkait dengan no_inv_pl
                                                    while ($row_spk_id = mysqli_fetch_assoc($result_spk_id)) {
                                                        $spkId = $row_spk_id['id_spk_pl'];
                                                        
                                                        // Mengambil nama petugas dari tb_spk_pl berdasarkan id_spk_pl
                                                        $query_petugas = "SELECT petugas_pl FROM tb_spk_pl WHERE id_spk_pl = '$spkId'";
                                                        $result_petugas = mysqli_query($koneksi, $query_petugas);
                                                        $row_petugas = mysqli_fetch_assoc($result_petugas);
                                                        $nama_petugas_array[] = $row_petugas['petugas_pl']; 
                                                    }

                                                    // Menghapus duplikat dan menggabungkan nama petugas dalam satu string
                                                    $nama_petugas_unique = implode(", ", array_unique($nama_petugas_array));

                                                    // Menampilkan badge dengan nama petugas
                                                    echo "<button type='button' class='btn btn-secondary badge'>";
                                                    echo "<i class='bx bxs-user'></i> <b>Petugas : $nama_petugas_unique</b>";
                                                    echo "</button>";

                                                    mysqli_close($koneksi);
                                                ?>
                                            </div>
                                            <table class="table table-striped" id="selectedProductsTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No. SPK</th>
                                                        <th>Nama Produk</th>
                                                        <th>Satuan</th>
                                                        <th>Merk</th>
                                                        <th>Harga</th>
                                                        <th>Quantity</th>
                                                        <th>Total Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        include "koneksi.php";
                                                        $query = "SELECT 
                                                                    sr.id_spk_pl,
                                                                    sr.status_spk_pl,
                                                                    tps.id_transaksi_pl,
                                                                    sr.no_spk_pl,
                                                                    tps.nama_produk_spk,
                                                                    tps.harga,
                                                                    tps.total_harga,
                                                                    tps.id_produk,
                                                                    spr.stock, 
                                                                    tpr.nama_produk, 
                                                                    tpr.satuan,
                                                                    tps.qty,
                                                                    tps.status_trx,
                                                                    tpr.harga_produk,
                                                                    tm.nama_merk
                                                                FROM 
                                                                    db_ecat.transaksi_produk_pl AS tps
                                                                LEFT JOIN 
                                                                    db_ecat.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk
                                                                LEFT JOIN 
                                                                    db_inventory.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                                                LEFT JOIN 
                                                                    db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                                                WHERE 
                                                                    tps.status_trx = 1 AND sr.id_inv_pl = (SELECT id_inv_pl FROM inv_pl WHERE id_inv_pl = '$id_inv_pl')";
                                                        $result = mysqli_query($koneksi, $query);

                                                        // Hasil query
                                                        $no = 1;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>";
                                                            echo "<th scope='row'>" . $no++ . "</th>";
                                                            echo "<td>" . $row['no_spk_pl'] . "</td>";
                                                            echo "<td>" . $row['nama_produk_spk'] . "</td>"; 
                                                            echo "<td>" . $row['satuan'] . "</td>";  
                                                            echo "<td>" . $row['nama_merk'] . "</td>"; 
                                                            echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>"; 
                                                            echo "<td>" . $row['qty'] . "</td>"; 
                                                            echo "<td>" . number_format($row['total_harga'], 0, ',', '.') . "</td>"; 
                                                            echo "<td>
                                                                    <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                        data-id='" . $row['id_transaksi_pl'] . "'    
                                                                        data-nama='" . $row['nama_produk_spk'] . "'
                                                                        data-harga='" . $row['harga'] . "'>
                                                                        <i class='bx bx-edit-alt'></i>
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
                            <form id="updateQtyForm" method="post" action="proses/proses_detail_dicetak_pl.php">
                                <input type="hidden" name="id_inv_pl" value="<?php echo $id_inv_pl; ?>">
                                <?php
                                include "koneksi.php";
                                $sql = "SELECT 
                                            sr.id_spk_pl,
                                            sr.status_spk_pl,
                                            tps.id_transaksi_pl,
                                            tps.nama_produk_spk,
                                            tps.harga,
                                            tps.id_produk,
                                            spr.stock, 
                                            tpr.nama_produk, 
                                            tpr.satuan,
                                            tps.qty,
                                            tps.status_trx,
                                            tpr.harga_produk,
                                            tm.nama_merk
                                        FROM 
                                            db_ecat.transaksi_produk_pl AS tps
                                        LEFT JOIN 
                                            db_ecat.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk
                                        LEFT JOIN 
                                            db_inventory.stock_produk_ecat AS spr ON tps.id_produk = spr.id_produk_ecat
                                        LEFT JOIN 
                                            db_inventory.tb_produk_ecat AS tpr ON tps.id_produk = tpr.id_produk_ecat
                                        LEFT JOIN 
                                            db_inventory.tb_merk AS tm ON tpr.id_merk = tm.id_merk
                                        WHERE 
                                            tps.status_trx = 0 
                                            AND sr.id_inv_pl = '$id_inv_pl' 
                                            AND sr.status_spk_pl = 'Invoice Dibuat'";
                                $result = mysqli_query($koneksi, $sql);

                                // Memeriksa apakah ada data yang ditemukan
                                if (mysqli_num_rows($result) > 0) {
                                    $counter = 1;
                                    echo '<h2 class="text-center mb-4" style="font-size: 20px;">Edit Produk Pesanan</h2>';
                                    // Menampilkan label kolom
                                    echo '
                                    <div class="card-body p-2">
                                        <div class="row p-1">
                                            <div class="col-sm-1 mb-2">
                                                <div class="form-control text-center bg-light"><b>No.</b></div>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <div class="form-control text-center bg-light"><b>Nama Produk</b></div>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <div class="form-control text-center bg-light"><b>Satuan</b></div>
                                            </div>
                                            <div class="col-sm-2 mb-2">
                                                <div class="form-control text-center bg-light"><b>Merk</b></div>
                                            </div>
                                            <div class="col-sm-2 mb-2">
                                                <div class="form-control text-center bg-light"><b>Harga</b></div>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <div class="form-control text-center bg-light"><b>Stok</b></div>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <div class="form-control text-center bg-light"><b>Qty</b></div>
                                            </div>
                                        </div>
                                    </div>';
                                    
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                        <div class="card-body p-2">
                                            <div class="row p-1">
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control text-center bg-light mobile" id="no_' . $counter . '" value="' . $counter . '" readonly>
                                                </div>
                                                <div class="col-sm-3 mb-2">
                                                    <input type="text" class="form-control bg-light" name="nama_produk[]" id="newProdukInput_' . $counter . '" value="' . $row["nama_produk_spk"] . '">
                                                    <input type="hidden" name="id_transaksi_pl[]" value="' . $row["id_transaksi_pl"] . '">
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control bg-light text-center mobile-text" id="satuan_' . $counter . '" value="' . $row["satuan"] . '" readonly>
                                                </div>
                                                <div class="col-sm-2 mb-2">
                                                    <input type="text" class="form-control bg-light text-center mobile-text" id="nama_merk_' . $counter . '" value="' . $row["nama_merk"] . '" readonly>
                                                </div>
                                                <div class="col-sm-2 mb-2">
                                                    <input type="text" class="form-control bg-light text-end mobile-text number_format" id="harga_' . $counter . '" name="harga_produk[]" value="' . number_format($row["harga"]) . '">
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control bg-light text-end mobile-text" id="stok_' . $counter . '" value="' . $row["stock"] . '" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control bg-light text-end mobile-text" id="qty_' . $counter . '" value="' . $row["qty"] . '" readonly>
                                                </div>
                                            </div>
                                        </div>';
                                        $counter++;
                                    }
                                    
                                    // Tombol simpan
                                    echo '
                                    <div class="card-body p-2">
                                        <div class="row p-1">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                                            </div>
                                        </div>
                                    </div>';
                                }

                                mysqli_close($koneksi);
                                ?>
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
        function addThousandSeparator(input) {
            // Get input value and remove non-numeric characters
            let value = input.value.replace(/\D/g, '');
            
            // Add thousand separator using regex
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            
            // Set formatted value back to the input field
            input.value = value;
        }

        // Get all input elements with class 'form-control' and 'bg-light'
        let inputs = document.querySelectorAll('.number_format');

        // Loop through each input element
        inputs.forEach(function(input) {
            // Add event listener for 'input' event
            input.addEventListener('input', function() {
                // Call addThousandSeparator function passing the input element
                addThousandSeparator(this);
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectedProductsTable').DataTable({
                scrollX: true
            });
        });
    </script>
    <!-- <script>
        $('#normalize').selectize({ normalize: true });
    </script> -->
    <script>
        const btnProsesPesanan = document.getElementById('btnProsesPesanan');

        btnProsesPesanan.addEventListener('click', function() {
            const inputNamaPetugasModal = new bootstrap.Modal(document.getElementById('inputNamaPetugasModal'));
            inputNamaPetugasModal.show();
        });
    </script>
    <script>
       // Mengatur tampilan field berdasarkan pilihan jenis_pengiriman saat modal dibuka
        document.addEventListener('DOMContentLoaded', function() {
            var driverForm = document.getElementById('driverForm');
            var ekspedisiForm = document.getElementById('ekspedisiForm');
            var langsungForm = document.getElementById('langsungForm');
            var jenisPengirimanSelect = document.getElementById('id_status_kirim');

            // Sembunyikan semua form kecuali form untuk Diambil Langsung
            driverForm.style.display = 'none';
            ekspedisiForm.style.display = 'none';
            langsungForm.style.display = 'none';

            // Periksa jenis_pengiriman yang dipilih saat modal dibuka
            if (jenisPengirimanSelect.value === '1') { // Jika memilih "Diambil Langsung"
                langsungForm.style.display = 'block';
            }
        });

        // Event listener untuk mengubah tampilan field saat jenis_pengiriman berubah
        document.getElementById('id_status_kirim').addEventListener('change', function() {
            var driverForm = document.getElementById('driverForm');
            var ekspedisiForm = document.getElementById('ekspedisiForm');
            var langsungForm = document.getElementById('langsungForm');

            if (this.value === '1') { // Jika memilih "Diambil Langsung"
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'block';
            } else if (this.value === '2') { // Jika memilih "Driver"
                driverForm.style.display = 'block';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'none';
            } else if (this.value === '3') { // Jika memilih "Ekspedisi"
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'block';
                langsungForm.style.display = 'none';
            } else {
                // Sembunyikan kedua form jika memilih jenis pengiriman lainnya
                driverForm.style.display = 'none';
                ekspedisiForm.style.display = 'none';
                langsungForm.style.display = 'none';
            }
        });
    </script>

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
                        <input type="hidden" name="id_transaksi_pl" id="idToDelete">
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

<!-- Modal Tambah SPK -->
<div class="modal fade" id="tambahData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data SPK</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="refreshPage()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <?php
                include "koneksi.php";
                $sql = "SELECT * FROM tb_spk_pl WHERE id_inv_pl = '$id_inv_pl'";
                $query = mysqli_query($koneksi, $sql);
                $totalData = mysqli_num_rows($query);
            ?>
            <table class="table table-striped" id="ecat_modal">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col" style="width: 15%;">No. SPK</th>
                        <th scope="col" style="width: 15%;">Tgl. SPK</th>
                        <th scope="col" style="width: 15%;">Nama Sales</th>
                        <th scope="col" style="width: 15%;">Total SPK</th>
                        <th scope="col" style="width: 15%;">Pilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "koneksi.php";

                    if (isset($_GET['id_inv_pl'])) {
                        $id_inv_pl = $_GET['id_inv_pl'];

                        $querySPK = "SELECT 
                                        tb_spk_pl.id_spk_pl, 
                                        tb_spk_pl.id_sales, 
                                        tb_spk_pl.id_inv_pl, 
                                        tb_spk_pl.no_spk_pl, 
                                        tb_spk_pl.tgl_spk_pl,
                                        tb_spk_pl.total_spk_pl,  
                                        tb_spk_pl.status_spk_pl,
                                        tb_sales_ecat.nama_sales
                                    FROM 
                                        tb_spk_pl
                                    JOIN 
                                        tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                                    WHERE 
                                        tb_spk_pl.id_sales IN (SELECT id_sales FROM tb_spk_pl WHERE id_inv_pl = '$id_inv_pl')
                                        AND tb_spk_pl.status_spk_pl = 'Siap Kirim'";
                        $resultSPK = mysqli_query($koneksi, $querySPK);

                        if ($resultSPK) {
                            $no = 1;
                            while ($rowSPK = mysqli_fetch_assoc($resultSPK)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $rowSPK['no_spk_pl'] . "</td>";
                                echo "<td>" . $rowSPK['tgl_spk_pl'] . "</td>";
                                echo "<td>" . $rowSPK['nama_sales'] . "</td>";
                                echo "<td>" . number_format($rowSPK['total_spk_pl'], 0, ',', '.') . "</td>";
                                echo "<td><input type='checkbox' class='form-check-input spk-checkbox' data-sales='" . $rowSPK['id_sales'] . "' data-no-inv='" . $id_inv_pl . "' data-spk='" . $rowSPK['id_spk_pl'] . "'></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data SPK yang ditemukan</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nomor Invoice tidak ditemukan</td></tr>";
                    }

                    mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    new DataTable('#ecat_modal');
</script>
<script>
    function refreshPage() {
        location.reload();
    }
</script>
<script>
    $('#btnSimpan').click(function () {
        var selectedSPK = [];
        $('.spk-checkbox:checked').each(function() {
            var id_sales = $(this).data('sales');
            var no_inv = $(this).data('no-inv');
            var id_spk_pl = $(this).data('spk');
            selectedSPK.push({
                id_sales: id_sales,
                id_inv_pl: no_inv,
                id_spk_pl: id_spk_pl
            });
        });

        // Menggunakan variabel totalData untuk membatasi jumlah maksimal SPK yang dapat dipilih
        if (selectedSPK.length > 0) {
            console.log("Jumlah total data SPK berdasarkan id_inv_pl: <?php echo $totalData; ?>");
            if (selectedSPK.length + <?php echo $totalData; ?> <= 5) {
                $.ajax({
                    type: "POST",
                    url: "proses/proses_pilih_spk_pl.php",
                    data: { spk_data: selectedSPK },
                    success: function (response) {
                        $('#tambahData').modal('hide'); 
                        Swal.fire({ 
                            icon: 'success',
                            title: 'Berhasil Tambah SPK!'
                        }).then(function() {
                            location.reload(); 
                        });
                    }
                });
            } else {
                $('#tambahData').modal('hide');
                Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Anda sudah mencapai batas maksimum tambah SPK!",
            }).then((result) => {
                if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
                    location.reload();
                }
            });
            }
        } else {
            alert("Silakan pilih setidaknya satu SPK.");
        }
    });
</script>

</body>
</html>
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Produk SPK</h5>
            </div>
            <form action="proses/edit_produk_pl.php" method="POST">
                <input type="hidden" name="id_inv_pl" value="<?php echo $id_inv_pl; ?>">
                <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_transaksi_pl" name="id_transaksi_pl" class="form-control" value="<?php echo $row['id_transaksi_pl']; ?>" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" id="nama" name="nama_produk_spk" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" id="harga" name="harga" class="form-control">
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

<script>
    // Fungsi untuk mengonversi angka menjadi format yang sesuai
    function formatAngka(angka) {
        // Memeriksa apakah nilai input adalah angka atau string kosong
        if (!angka || isNaN(angka)) {
            return ''; // Mengembalikan string kosong jika input tidak valid
        }

        // Mengonversi angka menjadi format mata uang dengan menggunakan Intl.NumberFormat
        var formattedAngka = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(angka);

        // Menghapus penambahan ,00 di akhir nilai
        if (formattedAngka.slice(-3) === ',00') {
            formattedAngka = formattedAngka.slice(0, -3);
        }

        return formattedAngka;
    }

    // Handler Tombol Edit
    $('.btn-edit').on('click', function () {
        var id = $(this).data('id');
        var produk = $(this).data('nama');
        // Parse harga to ensure it's treated as a number
        var harga = parseFloat($(this).data('harga'));

        $('#id_transaksi_pl').val(id);
        $('#nama').val(produk);
        
        // Memformat harga ke dalam format mata uang
        var formattedHarga = formatAngka(harga);
        $('#harga').val(formattedHarga);

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });

    // Event listener untuk memperbarui format harga saat input berubah
    $('#harga').on('input', function() {
        // Menghapus karakter selain angka dari input
        var nilaiInput = hapusKarakterTidakValid($(this).val());
        
        // Mengonversi nilai input ke dalam format angka yang sesuai
        var formattedNilai = formatAngka(nilaiInput);

        // Memasukkan nilai yang telah diformat kembali ke dalam input
        $(this).val(formattedNilai);
    });

    // Fungsi untuk menghapus semua karakter selain angka dari input
    function hapusKarakterTidakValid(str) {
        return str.replace(/\D/g, '');
    }
</script>

