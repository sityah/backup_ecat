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
                            <h5 class="card-header text-center"><b>DETAIL PRODUK SPK PL</b></h5>
                            <div class="card-body border m-2">
                            <div class="mt-4 text-end me-3">
                                <button type="button" class="btn btn-secondary mb-3">Penunjukkan Langsung</button>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <?php
                                    include "koneksi.php";

                                    if (isset($_GET['id_spk_pl'])) {
                                        $id_spk_pl = $_GET['id_spk_pl'];

                                        $sql = "SELECT
                                                tb_spk_pl.tgl_pesanan_pl,
                                                tb_spk_pl.no_spk_pl,
                                                tb_spk_pl.tgl_spk_pl,
                                                tb_spk_pl.no_po,
                                                tb_spk_pl.fee_marketing,
                                                tb_sales_ecat.nama_sales,
                                                tb_perusahaan.nama_perusahaan,
                                                tb_perusahaan.alamat_perusahaan,
                                                tb_provinsi.nama_provinsi
                                            FROM
                                                tb_spk_pl
                                            JOIN
                                                tb_sales_ecat ON tb_spk_pl.id_sales = tb_sales_ecat.id_sales
                                            JOIN
                                                tb_perusahaan ON tb_spk_pl.id_perusahaan = tb_perusahaan.id_perusahaan
                                            JOIN
                                                tb_provinsi ON tb_perusahaan.id_provinsi = tb_provinsi.id_provinsi
                                            WHERE
                                                tb_spk_pl.id_spk_pl = '$id_spk_pl'";

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
                                                            <td class="mb-3" style="width: 180px">Tgl. SPK</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["tgl_spk_pl"] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="mb-3" style="width: 180px">No. PO</td>
                                                            <td class="p-2 py-0">:</td>
                                                            <td>' . $row["no_po"] . '</td>
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
                            <form id="insertForm" method="post" action="proses/proses_pesanan_pl.php">
                                <input type="hidden" name="id_spk_pl" value="<?php echo $id_spk_pl; ?>">
                                <div class="card-body border mt-2 mb-4">
                                    <div class="row mb-4">
                                        <div class="table-responsive">
                                            <button type="button" class="btn btn-primary mb-3" onclick="window.location.href = 'data_spk_pl.php';"><i class="tf-icons bx bxs-chevrons-left"></i> Kembali</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahData">Tambah Data</button>
                                            <button type="button" class="btn btn-outline-primary mb-3" onclick="cetakSPK()">Cetak SPK</button>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk memeriksa apakah data sesuai dengan kriteria
                                                $query_check = "SELECT 
                                                                    sr.id_spk_pl,
                                                                    sr.status_cetak,
                                                                    tps.status_tmp
                                                                FROM tb_spk_pl AS sr
                                                                JOIN tmp_produk_spk_pl AS tps ON sr.id_spk_pl = tps.id_spk_pl
                                                                WHERE sr.id_spk_pl = '$id_spk_pl' AND tps.status_tmp = '1'";
                                                $result_check = mysqli_query($koneksi, $query_check);
                                                $data_check = mysqli_fetch_assoc($result_check);
                                                // Jika data sesuai kriteria, tombol akan ditampilkan dan bisa diklik
                                                if ($data_check && $data_check['status_cetak'] == '1') {
                                            ?>
                                                    <!-- Button Proses Pesanan -->
                                                    <button type="button" class="btn btn-outline-primary mb-3" id="btnProsesPesanan" data-spkid="<?php echo $id_spk_pl; ?>" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">Proses Pesanan</button>
                                            <?php
                                                }
                                                mysqli_close($koneksi);
                                            ?>
                                            <!-- Modal Konfirmasi -->
                                            <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Proses Pesanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin memproses pesanan ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <!-- Tombol Ya, Proses Pesanan -->
                                                            <button type="submit" class="btn btn-primary">Ya, Proses Pesanan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-striped" id="selectedProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 5%;">No</th>
                                                        <th scope="col" style="width: 30%;">Nama Produk</th>
                                                        <th scope="col" style="width: 10%;">Satuan</th>
                                                        <th scope="col" style="width: 15%;">Merk</th>
                                                        <th scope="col" style="width: 15%;">Harga</th>
                                                        <th scope="col" style="width: 10%;">Quantity</th>
                                                        <th scope="col" style="width: 15%;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        include "koneksi.php";
                                                        $query = "SELECT 
                                                                    sr.id_spk_pl,
                                                                    tps.id_tmp_pl,
                                                                    tps.id_produk_ecat,
                                                                    spr.stock, 
                                                                    tpr.nama_produk, 
                                                                    tpr.satuan,
                                                                    tps.qty,
                                                                    tps.status_tmp,
                                                                    tpr.harga_produk,
                                                                    tm.nama_merk  
                                                                FROM mandir36_db_ecat_staging.tmp_produk_spk_pl AS tps
                                                                LEFT JOIN mandir36_db_ecat_staging.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk_pl
                                                                LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                                                                LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                                                                LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                                                                WHERE sr.id_spk_pl = '$id_spk_pl' AND tps.status_tmp = 1";
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
                                                                    <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                        data-id='" . $row['id_tmp_pl'] . "'    
                                                                        data-produk='" . $row['nama_produk'] . "'
                                                                        data-satuan='" . $row['satuan'] . "'
                                                                        data-merk='" . $row['nama_merk'] . "'
                                                                        data-harga='" . $row['harga_produk'] . "'
                                                                        data-stock='" . $row['stock'] . "'
                                                                        data-qty='" . $row['qty'] . "'>
                                                                        <i class='bx bx-edit-alt'></i>
                                                                    </button>
                                                                    <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_tmp_pl'] . "' data-nama='" . $row['nama_produk'] . "'>
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
                            <form id="updateQtyForm" method="post" action="update_qty_pl.php">
                                <input type="hidden" name="id_spk_pl" value="<?php echo $id_spk_pl; ?>">
                                <?php
                                include "koneksi.php";
                                $sql = "SELECT 
                                            sr.id_spk_pl,
                                            tps.id_tmp_pl,
                                            tps.id_produk_ecat,
                                            spr.stock, 
                                            tpr.nama_produk, 
                                            tpr.satuan,
                                            tps.qty,
                                            tps.status_tmp,
                                            tpr.harga_produk,
                                            tm.nama_merk  
                                        FROM mandir36_db_ecat_staging.tmp_produk_spk_pl AS tps
                                        LEFT JOIN mandir36_db_ecat_staging.tb_spk_pl AS sr ON sr.id_spk_pl = tps.id_spk_pl
                                        LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                                        LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                                        LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                                        WHERE sr.id_spk_pl = '$id_spk_pl' AND tps.status_tmp = 0";
                                $result = mysqli_query($koneksi2, $sql);

                                // Memeriksa apakah ada data yang ditemukan
                                if (mysqli_num_rows($result) > 0) {
                                    $counter = 1;
                                    echo '<h2 class="text-center mb-4" style="font-size: 20px;">Tambah Produk Pesanan</h2>';
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
                                            <div class="col-sm-1 mb-2">
                                                <div class="form-control text-center bg-light"><b>Aksi</b></div>
                                            </div>
                                        </div>
                                    </div>';
                                    
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Mengisi nilai input dengan data yang diambil
                                        echo '
                                        <div class="card-body p-2">
                                            <div class="row p-1">
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control text-center bg-light mobile" id="no_' . $counter . '" value="' . $counter . '" readonly>
                                                </div>
                                                <div class="col-sm-3 mb-2">
                                                    <input type="text" class="form-control bg-light" id="nama_produk_' . $counter . '" value="' . $row["nama_produk"] . '" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control bg-light text-center mobile-text" id="satuan_' . $counter . '" value="' . $row["satuan"] . '" readonly>
                                                </div>
                                                <div class="col-sm-2 mb-2">
                                                    <input type="text" class="form-control bg-light text-center mobile-text" id="nama_merk_' . $counter . '" value="' . $row["nama_merk"] . '" readonly>
                                                </div>
                                                <div class="col-sm-2 mb-2">
                                                    <input type="text" class="form-control bg-light text-end mobile-text" id="harga_' . $counter . '" value="' . $row["harga_produk"] . '" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control bg-light text-end mobile-text" id="stok_' . $counter . '" value="' . $row["stock"] . '" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <input type="number" class="form-control text-end mobile-text" name="new_qty[]" id="newQtyInput_' . $counter . '">
                                                    <input type="hidden" name="id_tmp_pl[]" value="' . $row["id_tmp_pl"] . '">
                                                </div>
                                                <div class="col-sm-1 mb-2 text-center">
                                                    <button type="submit" class="btn btn-danger btn-sm delete-data" data-id="' . $row["id_tmp_pl"] . '"><i class="bi bi-trash"></i></button>
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
                                                <button type="submit" class="btn btn-primary">Simpan</button>
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
        // Fungsi untuk mengubah format teks menjadi format angka
        function formatNumber(input) {
            return Number(input).toLocaleString('id-ID'); // Ubah 'id-ID' sesuai dengan kode negara Anda untuk format angka yang diinginkan
        }

        // Ambil semua elemen input untuk harga produk
        var hargaInputs = document.querySelectorAll('[id^="harga_"]');

        // Iterasi melalui setiap elemen input harga produk
        hargaInputs.forEach(function(inputElement) {
            // Ambil nilai teks dari input
            var textValue = inputElement.value;
            
            // Ubah nilai teks menjadi format angka dan masukkan kembali ke dalam input
            inputElement.value = formatNumber(textValue);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectedProductsTable').DataTable();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan elemen-elemen yang diperlukan
            var qtyInputs = document.querySelectorAll('input[name="new_qty[]"]');
            var stockInputs = document.querySelectorAll('input[id^="stok_"]');
            
            // Menambahkan event listener pada setiap input qty
            qtyInputs.forEach(function(input, index) {
                input.addEventListener('input', function() {
                    var maxStock = parseInt(stockInputs[index].value); // Mendapatkan stok maksimal
                    var enteredQty = parseInt(input.value); // Mendapatkan jumlah yang diinput
                    
                    // Memastikan jumlah yang diinput tidak melebihi stok maksimal
                    if (enteredQty > maxStock) {
                        input.value = maxStock; // Mengatur jumlah yang diinput menjadi stok maksimal
                    }
                });
            });
        });
    </script>

    <script>
        function cetakSPK() {
            // Mendapatkan id_spk_pl dari URL
            var id_spk_pl = "<?php echo isset($_GET['id_spk_pl']) ? $_GET['id_spk_pl'] : ''; ?>";
            // Redirect ke halaman cetak_spk_ecat.php dengan menyertakan id_spk_pl
            window.location.href = "cetak_spk_pl.php?id_spk_pl=" + id_spk_pl;
        }
    </script>
    <script>
        // Fungsi untuk menampilkan modal konfirmasi
        function tampilkanModal() {
            $('#konfirmasiModal').modal('show');
        }

        // Fungsi untuk mengirimkan formulir setelah konfirmasi
        function kirimForm() {
            document.getElementById('insertForm').submit();
            $('#konfirmasiModal').modal('hide');
        }
    </script>
    <script>
        $(document).ready(function(){
            $('.delete-data').click(function(e){
                e.preventDefault();
                var id_tmp_pl = $(this).data('id');
                var confirm_delete = confirm("Anda yakin ingin menghapus data?");
                if(confirm_delete){
                    $.ajax({
                        type: "POST",
                        url: "update_qty_pl.php",
                        data: {delete_id:id_tmp_pl},
                        dataType: 'json',
                        success: function(response){
                            if(response.success){
                                // Refresh atau perbarui tampilan jika diperlukan
                                location.reload();
                            } else {
                                alert("Gagal menghapus data. Silakan coba lagi.");
                            }
                        },
                        error: function(xhr, status, error){
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="proses/aksi_spk_pl.php">
                    <input type="hidden" name="id_spk_pl" value="<?php echo $id_spk_pl; ?>">
                    <input type="hidden" name="id_tmp_pl" value="<?php echo $id_tmp_pl; ?>">
                    <input type="hidden" name="nama_produk" value="<?php echo $nama_produk; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_tmp_pl" id="idToDelete">
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

<!-- Modal pilih Produk -->
<div class="modal fade" id="tambahData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="refreshPage()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
        <table class="table table-striped" id="pl_modal">
        <thead>
            <tr class="text-white" style="background-color: #051683;">
                <th class="text-center p-3" style="width: 5%; color: #ffffff;">No</th>
                <th class="text-center p-3" style="width: 40%; color: #ffffff;">Nama Produk</th>
                <th class="text-center p-3" style="width: 15%; color: #ffffff;">Satuan</th>
                <th class="text-center p-3" style="width: 10%; color: #ffffff;">Merk</th>
                <th class="text-center p-3" style="width: 20%; color: #ffffff;">Stock</th>
                <th class="text-center p-3" style="width: 10%; color: #ffffff;">Aksi</th>
            </tr>
        </thead>
            <tbody id="productTableBody">
                <?php
                include "koneksi.php";
                //$id = $_GET['id'];
                $selected_produk = [];
               // $id_spk = $id_spk_reg;
                $no = 1;

                $sql = "SELECT 
                            COALESCE(tpr.id_produk_ecat) AS id_produk,
                            COALESCE(tpr.nama_produk) AS nama_produk,
                            COALESCE(mr_tpr.nama_merk) AS nama_merk,
                            tpr.satuan,
                            spr.id_stock_prod_ecat,
                            spr.stock,
                            tkp.min_stock, 
                            tkp.max_stock
                        FROM stock_produk_ecat AS spr
                        LEFT JOIN tb_produk_ecat AS tpr ON (tpr.id_produk_ecat = spr.id_produk_ecat)
                        LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                        LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                        ORDER BY nama_produk ASC";

                $query = mysqli_query($koneksi2, $sql);

                while ($data = mysqli_fetch_array($query)) {
                    $id_produk = $data['id_produk'];
                    $id_produk_substr = substr($id_produk, 0, 2);
                    $isChecked = in_array($id_produk, $selected_produk);
                    $isDisabled = false;

                    if ($data['stock'] == 0) {
                        $isDisabled = true; 
                    }
                ?>
                    <tr>
                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                        <td class="text-nowrap"><?php echo $data['nama_produk']; ?></td>
                        <td class="text-center text-nowrap">
                            <?php 
                            if($id_produk_substr == 'BR'){
                                echo $data['satuan'];
                            } else {
                                echo "Set";
                            }
                            ?>
                        </td>
                        <td class="text-center text-nowrap"><?php echo $data['nama_merk']; ?></td>
                        <td class="text-center text-nowrap"><?php echo number_format($data['stock']); ?></td>
                        <td class="text-center text-nowrap">
                            <?php
                            // Tambahkan logika PHP untuk memeriksa apakah produk sudah ada dalam tabel tmp_produk_spk_ecat
                            $query_check_product = "SELECT COUNT(*) as count FROM mandir36_db_ecat_staging.tmp_produk_spk_pl WHERE id_spk_pl = '$id_spk_pl' AND id_produk_ecat = '$id_produk'";
                            $result_check_product = mysqli_query($koneksi, $query_check_product);
                            $row_check_product = mysqli_fetch_assoc($result_check_product);
                            $count = $row_check_product['count'];

                            // Jika produk sudah ada, tambahkan atribut hidden pada button
                            if ($count > 0) {
                                $hidden_attribute = "hidden";
                            } else {
                                $hidden_attribute = "";
                            }
                            ?>
                            <button class="btn-pilih btn btn-primary btn-sm" data-id="<?php echo $id_produk; ?>" data-spk="<?php echo $id_spk_pl; ?>" <?php echo ($isChecked || $isDisabled) ? 'disabled' : ''; echo $hidden_attribute; ?>>Pilih</button>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php } ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    new DataTable('#pl_modal');
</script>
<script>
  $(document).ready(function() {
    // Mendefinisikan variabel global untuk menyimpan data produk dan informasi pagination
    var productsData = [];
    var currentPage = 1;
    var productsPerPage = 10; // Ubah sesuai kebutuhan Anda

    // Fungsi untuk menampilkan produk pada halaman tertentu
    function displayProducts(page) {
      var startIndex = (page - 1) * productsPerPage;
      var endIndex = startIndex + productsPerPage;
      var displayedProducts = productsData.slice(startIndex, endIndex);

      var tableBody = $('#productTableBody');
      tableBody.empty();

      $.each(displayedProducts, function(index, product) {
        var row = '<tr>' +
                    '<td class="text-center text-nowrap">' + product.no + '</td>' +
                    '<td class="text-nowrap">' + product.nama_produk + '</td>' +
                    '<td class="text-center text-nowrap">' + product.satuan + '</td>' +
                    '<td class="text-center text-nowrap">' + product.nama_merk + '</td>' +
                    '<td class="text-center text-nowrap">' + product.stock + '</td>' +
                    '<td class="text-center text-nowrap">' +
                      '<button class="btn-pilih btn btn-primary btn-sm" data-id="' + product.id_produk + '" data-spk="' + product.id_spk_pl + '">Pilih</button>' +
                    '</td>' +
                  '</tr>';
        tableBody.append(row);
      });
    }

    // Fungsi untuk membuat pagination
    function setupPagination(totalProducts) {
      var totalPages = Math.ceil(totalProducts / productsPerPage);
      var pagination = $('#pagination');
      pagination.empty();

      for (var i = 1; i <= totalPages; i++) {
        var pageLink = '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
        pagination.append(pageLink);
      }

      // Tambahkan event listener untuk setiap halaman
      pagination.find('a').click(function() {
        currentPage = parseInt($(this).data('page'));
        displayProducts(currentPage);
      });
    }

    // Memuat data produk dari server
    function loadProducts() {
      $.ajax({
        type: 'GET',
        url: 'load_products.php', // Ganti dengan URL yang sesuai
        success: function(response) {
          productsData = response.products;
          setupPagination(productsData.length);
          displayProducts(currentPage);
        },
        error: function() {
          alert('Terjadi kesalahan saat memuat data produk.');
        }
      });
    }

    // Memuat data produk saat dokumen siap
    loadProducts();

    // Event handler untuk tombol pilih
    $(document).on('click', '.btn-pilih', function() {
      var id_spk = $(this).data('spk');
      var id_produk = $(this).data('id');
      var clickedButton = $(this);

      // Lakukan operasi pemilihan produk
      $.ajax({
        type: 'POST',
        url: 'simpan_produk_pl.php',
        data: {
          id_spk: id_spk,
          id_produk: id_produk
        },
        success: function(response) {
            clickedButton.hide();
        },
        error: function() {
          alert('Terjadi kesalahan saat menyimpan data produk.');
        }
      });
    });
  });
</script>
<script>
    function refreshPage() {
        location.reload();
    }
</script>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Produk SPK</h5>
            </div>
            <form action="proses/aksi_spk_pl.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_tmp_pl" name="id_tmp_pl" class="form-control" value="<?php echo $row['id_tmp_pl']; ?>" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" id="produk" name="nama_produk" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Satuan</label>
                                <input type="text" id="satuan" name="satuan" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Merk</label>
                                <input type="text" id="merk" name="nama_merk" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" id="harga" name="harga_produk" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" id="stock" name="stock" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="text" id="qty" name="qty" class="form-control">
                                <input type="hidden" id="max_stock" name="max_stock">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-qty">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Handler Tombol Edit
    $('.btn-edit').on('click', function () {
        var id = $(this).data('id');
        var produk = $(this).data('produk');
        var satuan = $(this).data('satuan');
        var merk = $(this).data('merk');
        var harga = $(this).data('harga');
        var stock = $(this).data('stock'); 
        var qty = $(this).data('qty');

        // Set values for the edit form
        $('#id_tmp_pl').val(id);
        $('#produk').val(produk);
        $('#satuan').val(satuan);
        $('#merk').val(merk);
        $('#harga').val(harga);
        $('#qty').val(qty);
        $('#stock').val(stock);
        $('#max_stock').val(stock); 

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });

    $('#modalEdit').on('input', '#qty', function() {
        var maxStock = parseInt($('#max_stock').val());
        var enteredQty = parseInt($(this).val()); 
        
        if (enteredQty > maxStock) {
            $(this).val(maxStock); 
        }
    });
</script>

