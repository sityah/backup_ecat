<?php include "akses.php" ?>

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
    <style>
    #ecat th, #ecat td {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #id_kota_kab_select,
    #id_kota_kab_label {
        display: none; /* Sembunyikan kolom kota/kabupaten dan label awalnya */
    }
    .capitalize {
        text-transform: capitalize;
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
                            <h5 class="card-header">Data Sales</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 15%;">Nama Sales</th>
                                                <th scope="col" style="width: 20%;">Nama Perusahaan</th>
                                                <th scope="col" style="width: 15%;">Wilayah</th>
                                                <th scope="col" style="width: 15%;">Telepon</th>
                                                <th scope="col" style="width: 15%;">Email</th>
                                                <th scope="col" style="width: 5%;">Jenis Sales</th>
                                                <th scope="col" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_sales_ecat
                                                $query = "SELECT 
                                                tb_sales_ecat.*, 
                                                tb_kota.nama_kota_kab, 
                                                tb_provinsi.nama_provinsi, 
                                                tb_perusahaan.nama_perusahaan, 
                                                tb_perusahaan.alamat_perusahaan 
                                                FROM tb_sales_ecat
                                                LEFT JOIN tb_kota ON tb_sales_ecat.id_kota_kab = tb_kota.id_kota_kab
                                                LEFT JOIN tb_provinsi ON tb_sales_ecat.id_provinsi = tb_provinsi.id_provinsi
                                                LEFT JOIN tb_perusahaan ON tb_sales_ecat.id_perusahaan = tb_perusahaan.id_perusahaan";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);

                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Set status default (jika data tidak ditemukan)
                                                    $status_aktif_checked = '';
                                                    $status_nonaktif_checked = '';

                                                // Memeriksa apakah data lama ada
                                                    // Set nilai status berdasarkan data lama
                                                    if ($row['status_sales'] == 'Aktif') {
                                                        $status_aktif_checked = 'checked';
                                                    } elseif ($row['status_sales'] == 'Nonaktif') {
                                                        $status_nonaktif_checked = 'checked';
                                                    }

                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_sales'] . "</td>"; 
                                                    echo "<td>" . $row['nama_perusahaan'] . "</td>";
                                                    echo "<td>" . $row['nama_provinsi'] . "</td>"; 
                                                    echo "<td>" . $row['no_telp_sales'] . "</td>"; 
                                                    echo "<td>" . $row['email_sales'] . "</td>"; 
                                                    echo "<td>" . $row['jenis_sales'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-info btn-sm mt-2 btn-details'
                                                                data-sales='" . $row['nama_sales'] . "'
                                                                data-jenis='" . $row['jenis_sales'] . "'
                                                                data-instansi='" . $row['nama_perusahaan'] . "'
                                                                data-npwp='" . $row['no_npwp'] . "'
                                                                data-kota='" . $row['nama_kota_kab'] . "'
                                                                data-wilayah='" . $row['nama_provinsi'] . "'
                                                                data-telp='" . $row['no_telp_sales'] . "'
                                                                data-email='" . $row['email_sales'] . "'
                                                                data-status='" . $row['status_sales'] . "'
                                                                data-createdby='" . $row['created_by'] . "'
                                                                data-created='" . $row['created_date'] . "'
                                                                data-updateby='" . $row['update_by'] . "'
                                                                data-update='" . $row['update_date'] . "'>
                                                                <i class='bx bx-info-circle'></i>
                                                            </button>
                                                            <a href='edit_sales.php?id=" . $row['id_sales'] . "' class='btn btn-warning btn-sm mt-2 btn-edit'><i class='bx bx-edit-alt'></i></a>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_sales'] . "'>
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
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Input -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Sales - E-Catalogue</h5>
            </div>
            <hr class="m-2" />
            <div class="modal-body">
                <!-- Formulir untuk menambah data sales -->
                <form action="proses/proses_sales.php" method="POST">
                <?php 
                  $uuid = generateUUID(); 
                  $hari = date('d');
                  $tahun = date('y');
                  $sluuid = "SL$uuid$hari$tahun";
                ?>
                    <input type="hidden" class="form-control" name="id_sales" id="id" value = "<?php echo $sluuid ?>">
                    <input type="hidden" name="status_sales" value="Aktif">
                    <label><strong>Jenis Sales</strong></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_sales" id="inlineRadio1" value="Pribadi" required>
                            <label class="form-check-label" for="inlineRadio1">Pribadi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_sales" id="inlineRadio2" value="Instansi" required>
                            <label class="form-check-label" for="inlineRadio2">Instansi / Perusahaan</label>
                        </div>
                    <div class="row mb-3 mt-2">
                        <div class="col">
                            <label class="form-label"><strong>Nama Sales *</strong></label>
                            <input type="text" name="nama_sales" class="form-control capitalize" placeholder="Masukkan Nama Lengkap">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>Nama Perusahaan *</strong></label>
                            <input type="hidden" name="id_perusahaan" class="form-control" required>
                            <input type="text" name="nama_perusahaan" class="form-control" data-bs-toggle="modal" data-bs-target="#pilihPerusahaan" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>No NPWP </strong>(opsional)</label>
                            <input type="text" name="no_npwp" class="form-control" pattern="[0-9]+" placeholder="Contoh: xx.yyy.yyy-z.xxx.yyy">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>Alamat *</strong></label>
                            <textarea class="form-control" name="alamat" id="alamat"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>Alamat *</strong></label>
                            <textarea class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" ></textarea>
                        </div>
                    </div>
                    <div id="selectData" class="mb-3">
                        <!-- Provinsi -->
                        <div class="col-sm mb-3">
                            <label class="form-label"><strong>Wilayah / Provinsi *</strong></label>
                            <select class="form-select" id="id_provinsi_select" name="id_provinsi_select" required>
                                <option value="">Pilih Wilayah/Provinsi</option>
                                <?php
                                include "koneksi.php";
                                $query_provinsi = "SELECT * FROM tb_provinsi";
                                $result_provinsi = mysqli_query($koneksi, $query_provinsi);
                                while ($data_provinsi = mysqli_fetch_array($result_provinsi)) {
                                    echo '<option value="' . $data_provinsi['id_provinsi'] . '">' . $data_provinsi['nama_provinsi'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Kota/Kabupaten -->
                        <div class="col-sm mb-3">
                            <label id="id_kota_kab_label" class="form-label"><strong>Kota / Kabupaten *</strong></label>
                            <select name="id_kota_kab_select" id="id_kota_kab_select" class="form-select" required>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>No Telp *</strong></label>
                            <input type="text" name="no_telp_sales" class="form-control" pattern="[0-9]+" minlength="11" maxlength="13" placeholder="Contoh: 0856xxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><strong>Email</strong></label>
                            <input type="text" name="email_sales" class="form-control" pattern=".+@.+" placeholder="name@example.com" oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" id="tutupmodalCenter" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-sales">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.getElementById('tutupmodalCenter').addEventListener('click', function() {
            // Reload halaman
            location.reload();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mendapatkan elemen radio button jenis sales
            var jenisSalesRadio = document.querySelectorAll('input[name="jenis_sales"]');
            // Mendapatkan elemen field nama perusahaan dan alamat perusahaan
            var namaPerusahaanField = document.querySelector('input[name="nama_perusahaan"]');
            var alamatPerusahaanField = document.querySelector('textarea[name="alamat_perusahaan"]');
            var alamatField = document.querySelector('textarea[name="alamat"]');

            // Fungsi untuk menyembunyikan field nama perusahaan dan alamat perusahaan
            function hideFields() {
                namaPerusahaanField.parentElement.parentElement.style.display = 'none'; 
                alamatPerusahaanField.parentElement.parentElement.style.display = 'none';
                alamatField.parentElement.parentElement.style.display = 'none';
            }

            // Fungsi untuk menampilkan field nama perusahaan dan alamat perusahaan
            function showFields() {
                namaPerusahaanField.parentElement.parentElement.style.display = ''; 
                alamatPerusahaanField.parentElement.parentElement.style.display = '';
                alamatField.parentElement.parentElement.style.display = '';
            }

            // Memanggil fungsi hideFields saat halaman dimuat
            hideFields();

            // Menambahkan event listener untuk setiap radio button
            jenisSalesRadio.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    if (this.value === 'Pribadi') {
                        hideFields(); 
                    } else {
                        showFields(); 
                    }
                    if (this.value === 'Instansi') {
                        alamatField.parentElement.parentElement.style.display = 'none';
                    } else {
                        alamatField.parentElement.parentElement.style.display = '';
                    }
                });
            });
        });
    </script>



    <?php
    function generateUUID() {
    // Generate 16 bytes of random data
    $data = random_bytes(16);

    // Set the version (4) and variant (0100)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert the binary data to a hexadecimal string
    $uuid = vsprintf('%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
    }

    ?>

    <!-- Modal Details -->
    <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Detail Data Sales</h5>
                </div>
                <div class="modal-body">
               <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <tr>
                        <td class="col-4"><strong>Nama Sales</strong></td>
                        <td id="dataSales"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Jenis Sales</strong></td>
                        <td id="dataJenis"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Nama Institusi</strong></td>
                        <td id="dataInstansi"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>NPWP</strong></td>
                        <td id="dataNpwp"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Kota / Kab</strong></td>
                        <td id="dataKota"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Wilayah / Provinsi</strong></td>
                        <td id="dataWilayah"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>No. Telp</strong></td>
                        <td id="dataTelpSales"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Email</strong></td>
                        <td id="dataEmailSales"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Status</strong></td>
                        <td id="dataStatus"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Dibuat Oleh</strong></td>
                        <td id="dataCreatedBy"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Dibuat Tanggal</strong></td>
                        <td id="dataCreated"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Diubah Oleh</strong></td>
                        <td id="dataUpdateBy"></td>
                      </tr>
                      <tr>
                        <td class="col-4"><strong>Diubah Tanggal</strong></td>
                        <td id="dataUpdate"></td>
                      </tr>
                    </table>
               </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_sales.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Sales</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Sales :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-sales" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable
            new DataTable('#ecat');

        // Menangani perubahan pada pilihan provinsi
        $('#id_provinsi_select').selectize();

        // Fungsi untuk mendapatkan HTML default kota/kabupaten
        function getDefaultKotaKabHtml() {
            return '<option value=""></option>' + defaultProvinsiAData;
        }

        // Simpan data default provinsi A
        var defaultProvinsiAData = $('#id_kota_kab_select').html();

        $('#id_provinsi_select').change(function() {
            var selectedProvinsi = $(this).val();
            var kotaKabSelect = $('#id_kota_kab_select');
            var kotaKabLabel = $('#id_kota_kab_label');

            // Periksa apakah selectize telah diinisialisasi sebelumnya
            if (kotaKabSelect[0].selectize) {
                // Hancurkan instance selectize sebelum inisialisasi baru
                kotaKabSelect[0].selectize.destroy();
            }

            // Reset data kota/kabupaten ke data default jika tidak ada provinsi yang dipilih
            if (!selectedProvinsi) {
                kotaKabSelect.html(getDefaultKotaKabHtml());
                // Inisialisasi atau perbarui selectize setelah mengubah opsi
                kotaKabSelect.hide();
                kotaKabLabel.hide();
                return;
            }

            // Pastikan provinsi yang dipilih tidak kosong
            // Mengirim permintaan ke server untuk mendapatkan data kota/kabupaten
            $.post('get_kota_kabupaten.php', { id_provinsi_select: selectedProvinsi }, function(data) {
                // Memperbarui opsi kota/kabupaten
                kotaKabSelect.html(getDefaultKotaKabHtml() + data);

                kotaKabSelect.show();
                kotaKabLabel.show();

                // Inisialisasi atau perbarui selectize setelah mengubah opsi
                kotaKabSelect.selectize();
            }).fail(function() {
                // Tangani kesalahan jika ada
                console.error('Gagal mendapatkan data kota/kabupaten.');
            });
        });

        // Inisialisasi DataTable pada halaman pertama load
        new DataTable('#ecat');

    //     // Function DETAILS
    //     $('.btn-details').on('click', function() {
    //         var sales = $(this).data('sales');
    //         var jenis = $(this).data('jenis');
    //         var instansi = $(this).data('instansi');
    //         var npwp = $(this).data('npwp');
    //         var kota = $(this).data('kota');
    //         var wilayah = $(this).data('wilayah');
    //         var telp = $(this).data('telp');
    //         var email = $(this).data('email');
    //         var status = $(this).data('status');
    //         var createdby = $(this).data('createdby');
    //         var created = $(this).data('created');
    //         var updateby = $(this).data('updateby');
    //         var update = $(this).data('update');

    //         $('#dataSales').text(sales);
    //         $('#dataJenis').text(jenis);
    //         $('#dataInstansi').text(instansi);
    //         $('#dataNpwp').text(npwp);
    //         $('#dataKota').text(kota);
    //         $('#dataWilayah').text(wilayah);
    //         $('#dataTelpSales').text(telp);
    //         $('#dataEmailSales').text(email);
    //         $('#dataStatus').text(status);
    //         $('#dataCreatedBy').text(createdby);
    //         $('#dataCreated').text(created);
    //         $('#dataUpdateBy').text(updateby);
    //         $('#dataUpdate').text(update);

    //         $('#modalToggle').modal('show'); 
    //     });
    // });

    //     // Function DELETE
    //     $('.btn-delete').on('click', function() {
    //         var salesId = $(this).data('id');
    //         var namaInstitusi = $(this).closest('tr').find('td:nth-child(2)').text(); // Ganti dengan selector yang sesuai
        
    //         // Set ID dan nama instansi untuk digunakan di tombol "Ya, Hapus"
    //         $('#modalDeleteBtn').data('id', salesId);
    //         $('#modalDeleteBtn').data('instansi', namaInstitusi);
        
    //         // Set pesan konfirmasi dengan nama instansi yang akan dihapus
    //         var modalText = "Apakah anda yakin hapus data Sales '<b>" + namaInstitusi + "</b>'?";
    //         $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="salesIdInput" name="id_sales" value="' + salesId + '" style="display:none;">');
        
    //         $('#modalDelete').on('hidden.bs.modal', function() {
    //         });
        
    //         $('#modalDelete').modal('show');
    //     });
        
    //     $('#modalDeleteBtn').on('click', function() {
    //         var salesId = $(this).data('id');
    //         var namaInstitusi = $(this).data('instansi');
        
    //         $('#modalDelete').modal('hide');
        
    //         // Lakukan operasi hapus di sini menggunakan customerId 
    //         // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
    //         console.log("Menghapus pelanggan dengan ID:", salesId);
    //         console.log("Instansi yang dihapus:", namaInstitusi);
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#ecat').DataTable();

        // Function DETAILS
        $('#ecat').on('click', '.btn-details', function() {
            var sales = $(this).data('sales');
            var jenis = $(this).data('jenis');
            var instansi = $(this).data('instansi');
            var npwp = $(this).data('npwp');
            var kota = $(this).data('kota');
            var wilayah = $(this).data('wilayah');
            var telp = $(this).data('telp');
            var email = $(this).data('email');
            var status = $(this).data('status');
            var createdby = $(this).data('createdby');
            var created = $(this).data('created');
            var updateby = $(this).data('updateby');
            var update = $(this).data('update');

            $('#dataSales').text(sales);
            $('#dataJenis').text(jenis);
            $('#dataInstansi').text(instansi);
            $('#dataNpwp').text(npwp);
            $('#dataKota').text(kota);
            $('#dataWilayah').text(wilayah);
            $('#dataTelpSales').text(telp);
            $('#dataEmailSales').text(email);
            $('#dataStatus').text(status);
            $('#dataCreatedBy').text(createdby);
            $('#dataCreated').text(created);
            $('#dataUpdateBy').text(updateby);
            $('#dataUpdate').text(update);

            $('#modalToggle').modal('show'); 
        });

        // Function DELETE
        $('#ecat').on('click', '.btn-delete', function() {
            var salesId = $(this).data('id');
            var namaInstitusi = $(this).closest('tr').find('td:nth-child(2)').text(); // Ganti dengan selector yang sesuai
        
            // Set ID dan nama instansi untuk digunakan di tombol "Ya, Hapus"
            $('#modalDeleteBtn').data('id', salesId);
            $('#modalDeleteBtn').data('instansi', namaInstitusi);
        
            // Set pesan konfirmasi dengan nama instansi yang akan dihapus
            var modalText = "Apakah anda yakin hapus data Sales '<b>" + namaInstitusi + "</b>'?";
            $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="salesIdInput" name="id_sales" value="' + salesId + '" style="display:none;">');
        
            $('#modalDelete').on('hidden.bs.modal', function() {
            });
        
            $('#modalDelete').modal('show');
        });
        
        $('#modalDeleteBtn').on('click', function() {
            var salesId = $(this).data('id');
            var namaInstitusi = $(this).data('instansi');
        
            $('#modalDelete').modal('hide');
        
            // Lakukan operasi hapus di sini menggunakan customerId 
            // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
            console.log("Menghapus pelanggan dengan ID:", salesId);
            console.log("Instansi yang dihapus:", namaInstitusi);
        });

        // Fungsi untuk memperbarui details setelah tabel dirender ulang
        table.on('draw.dt', function () {
            $('#ecat').on('click', '.btn-details', function() {
                var sales = $(this).data('sales');
                var jenis = $(this).data('jenis');
                var instansi = $(this).data('instansi');
                var npwp = $(this).data('npwp');
                var kota = $(this).data('kota');
                var wilayah = $(this).data('wilayah');
                var telp = $(this).data('telp');
                var email = $(this).data('email');
                var status = $(this).data('status');
                var createdby = $(this).data('createdby');
                var created = $(this).data('created');
                var updateby = $(this).data('updateby');
                var update = $(this).data('update');

                $('#dataSales').text(sales);
                $('#dataJenis').text(jenis);
                $('#dataInstansi').text(instansi);
                $('#dataNpwp').text(npwp);
                $('#dataKota').text(kota);
                $('#dataWilayah').text(wilayah);
                $('#dataTelpSales').text(telp);
                $('#dataEmailSales').text(email);
                $('#dataStatus').text(status);
                $('#dataCreatedBy').text(createdby);
                $('#dataCreated').text(created);
                $('#dataUpdateBy').text(updateby);
                $('#dataUpdate').text(update);

                $('#modalToggle').modal('show'); 
            });
        });
    });
</script>

</body>
</html>

<!-- Modal pilih perusahaan -->
<div class="modal fade" id="pilihPerusahaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Perusahaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
        <table class="table" id="ecat_modal">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 40%;">Nama Perusahaan</th>
                    <th scope="col" style="width: 40%;">Alamat</th>
                    <th scope="col" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "koneksi.php";
                    // Query untuk mengambil data dari tabel tb_provinsi
                    $query = "SELECT id_perusahaan, nama_perusahaan, alamat_perusahaan FROM tb_perusahaan";
                    $result = mysqli_query($koneksi, $query);
                    
                    // Hasil query
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<th scope='row' style='width: 5%;'>" . $no++ . "</th>";
                    echo "<td style='width: 40%;'>" . $row['nama_perusahaan'] . "</td>"; 
                    echo "<td style='width: 40%;'>" . $row['alamat_perusahaan'] . "</td>"; 
                    echo "<td style='width: 15%;'><button type='button' class='btn btn-primary btn-sm mt-2 btn-pilih' data-id='" . $row['id_perusahaan'] . "'>Pilih</button></td>";
                    echo "</tr>";
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

<script>
    $('#pilihPerusahaan').on('show.bs.modal', function () {
        if ($('#modalCenter').hasClass('show')) {
            $('#modalCenter').modal('hide');
        }
        });

        $('#modalCenter').on('hide.bs.modal', function (e) {
            e.preventDefault();
        });

        $('#pilihPerusahaan').on('hidden.bs.modal', function () {
            $('#modalCenter').modal('show');
        });

        // Inisialisasi DataTable saat modal pilihPerusahaan ditampilkan
        $('#pilihPerusahaan').on('shown.bs.modal', function () {
            $('#ecat_modal').DataTable().draw();
        });

        // Hancurkan DataTable saat modal pilihPerusahaan disembunyikan
        $('#pilihPerusahaan').on('hidden.bs.modal', function () {
            $('#ecat_modal').DataTable().destroy();
        });

        document.getElementById('tutupmodalCenter').addEventListener('click', function() {
            // Reload halaman
            location.reload();
        });

        // Select lokasi
        $(document).on('click', '#ecat_modal tbody tr', function (e) {
            var selectedMerk = $(this).data('merk');
            $('#merk').val(selectedMerk).trigger('input'); 
            $('#pilihPerusahaan').modal('hide');
    });
</script>
<script>
    $(document).on('click', '.btn-pilih', function () {
        var selectedCompanyId = $(this).data('id');
        var selectedCompanyName = $(this).closest('tr').find('td:eq(0)').text();

        // Memeriksa apakah ada data perusahaan yang sudah terpilih sebelumnya
        var perusahaanTerpilih = $('.btn-pilih[data-terpilih="true"]');

        if (perusahaanTerpilih.length > 0) {
            // Jika ada data perusahaan yang sudah terpilih sebelumnya, tampilkan kembali tombol "Pilih"
            perusahaanTerpilih.show().data('terpilih', false);
        }

        // Sembunyikan tombol "Pilih" untuk data yang sedang dipilih
        $(this).hide().data('terpilih', true);

        // Set nilai pada form
        $('input[name="id_perusahaan"]').val(selectedCompanyId);
        $('input[name="nama_perusahaan"]').val(selectedCompanyName);

        var selectedCompanyAddress = $(this).closest('tr').find('td:eq(1)').text();
        $('textarea[name="alamat_perusahaan"]').val(selectedCompanyAddress);

        $('#pilihPerusahaan').modal('hide');
    });
</script>
<script>
    new DataTable('#ecat_modal');
</script>