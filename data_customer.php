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
</head>
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
    #ecat_modal th {
        white-space: nowrap;
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include "page/sidebar.php"; ?>
            <div class="layout-page">
                <?php include "page/nav-header.php"; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Customer</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 15%;">Contact Person</th>
                                                <th scope="col" style="width: 20%;">Nama Perusahaan</th>
                                                <th scope="col" style="width: 10%;">Telepon</th>
                                                <th scope="col" style="width: 15%;">Email</th>
                                                <th scope="col" style="width: 10%;">Status</th>
                                                <th scope="col" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_customer
                                                $query = "SELECT 
                                                tb_customer.*, 
                                                tb_perusahaan.nama_perusahaan, 
                                                tb_perusahaan.alamat_perusahaan
                                              FROM tb_customer
                                              LEFT JOIN tb_perusahaan ON tb_customer.id_perusahaan = tb_perusahaan.id_perusahaan";
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
                                                    if ($row['status_cs'] == 'Aktif') {
                                                        $status_aktif_checked = 'checked';
                                                    } elseif ($row['status_cs'] == 'Nonaktif') {
                                                        $status_nonaktif_checked = 'checked';
                                                    }
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_contact_person'] . "</td>"; 
                                                    echo "<td>" . $row['nama_perusahaan'] . "</td>"; 
                                                    echo "<td>" . $row['no_telp_cs'] . "</td>"; 
                                                    echo "<td>" . $row['email_cs'] . "</td>"; 
                                                    echo "<td>" . $row['status_cs'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-info btn-sm mt-2 btn-details'
                                                                data-cp='" . $row['nama_contact_person'] . "'
                                                                data-satker='" . $row['nama_perusahaan'] . "'
                                                                data-npwp='" . $row['no_npwp_instansi'] . "'
                                                                data-perusahaan='" . $row['nama_perusahaan'] . "'
                                                                data-telp='" . $row['no_telp_cs'] . "'
                                                                data-email='" . $row['email_cs'] . "'
                                                                data-status='" . $row['status_cs'] . "'
                                                                data-createdby='" . $row['created_by'] . "'
                                                                data-created='" . $row['created_date'] . "'
                                                                data-updateby='" . $row['update_by'] . "'
                                                                data-updated='" . $row['updated_date'] . "'>
                                                                <i class='bx bx-info-circle'></i>
                                                            </button>
                                                            <a href='edit_cs.php?id=" . $row['id_customer'] . "' class='btn btn-warning btn-sm mt-2 btn-edit'><i class='bx bx-edit-alt'></i></a>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_customer'] . "'>
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
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Data Customer - E-Catalogue</h5>
                </div>
                <hr class="m-2" />
                <div class="modal-body">
                    <!-- Formulir untuk menambah data customer -->
                    <form action="proses_customer.php" method="POST">
                    <?php 
                    $uuid = generateUUID(); 
                    $hari = date('d');
                    $tahun = date('y');
                    $csuuid = "CS$uuid$hari$tahun";
                    ?>
                        <input type="hidden" class="form-control" name="id_customer" id="id" value = "<?php echo $csuuid ?>">
                        <input type="hidden" name="status_cs" value="Aktif">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><strong>Nama Contact Person *</strong></label>
                                <input type="text" name="nama_cp" class="form-control capitalize" placeholder="Masukkan Nama Lengkap" required>
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
                                <label class="form-label"><strong>No NPWP *</strong></label>
                                <input type="text" name="no_npwp" class="form-control" pattern="[0-9]+" placeholder="Masukkan Nomor NPWP" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><strong>Alamat Perusahaan *</strong></label>
                                <textarea class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" readonly required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><strong>No Telp *</strong></label>
                                <input type="text" name="telp" class="form-control" pattern="[0-9]+" minlength="11" maxlength="13" placeholder="Contoh: 0856xxxxxxxxx" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><strong>Email</strong></label>
                                <input type="text" name="email" class="form-control" pattern=".+@.+" placeholder="name@example.com" required oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" id="tutupmodalCenter" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="simpan-cs">Save changes</button>
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
                    <h5 class="modal-title" id="modalToggleLabel">Detail Data Customer</h5>
                </div>
                <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                    <tr>
                        <td class="col-4"><strong>Nama Contact Person</strong></td>
                        <td id="dataCp"></td>
                    </tr>
                    <tr>
                        <td class="col-4"><strong>Nama Satker / Institusi</strong></td>
                        <td id="dataSatker"></td>
                    </tr>
                    <tr>
                        <td class="col-4"><strong>NPWP Institusi</strong></td>
                        <td id="dataNpwp"></td>
                    </tr>
                    <tr>
                        <td class="col-4"><strong>No. Telp</strong></td>
                        <td id="dataTelp"></td>
                    </tr>
                    <tr>
                        <td class="col-4"><strong>Email</strong></td>
                        <td id="dataEmail"></td>
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
                        <td id="dataUpdated"></td>
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
                <form action="proses_customer.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Customer</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Customer :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-cs" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#ecat').DataTable();

            // Function DETAILS
            $('#ecat').on('click', '.btn-details', function() {
                var cp = $(this).data('cp');
                var satker = $(this).data('satker');
                var npwp = $(this).data('npwp');
                var kota = $(this).data('kota');
                var wilayah = $(this).data('wilayah');
                var telp = $(this).data('telp');
                var email = $(this).data('email');
                var status = $(this).data('status');
                var createdby = $(this).data('createdby');
                var created = $(this).data('created');
                var updateby = $(this).data('updateby');
                var updated = $(this).data('updated');

                $('#dataCp').text(cp);
                $('#dataSatker').text(satker);
                $('#dataNpwp').text(npwp);
                $('#dataKota').text(kota);
                $('#dataWilayah').text(wilayah);
                $('#dataTelp').text(telp);
                $('#dataEmail').text(email);
                $('#dataStatus').text(status);
                $('#dataCreatedBy').text(createdby);
                $('#dataCreated').text(created);
                $('#dataUpdateBy').text(updateby);
                $('#dataUpdated').text(updated);

                $('#modalToggle').modal('show');
            });

            // Fungsi untuk memperbarui details setelah tabel dirender ulang
            table.on('draw.dt', function () {
                $('[data-bs-toggle="modal"]').on('click', function () {
                    var $this = $(this);
                    var cp = $this.data('cp');
                    var satker = $this.data('satker');
                    var npwp = $this.data('npwp');
                    var kota = $this.data('kota');
                    var wilayah = $this.data('wilayah');
                    var telp = $this.data('telp');
                    var email = $this.data('email');
                    var status = $this.data('status');
                    var createdby = $this.data('createdby');
                    var created = $this.data('created');
                    var updateby = $this.data('updateby');
                    var updated = $this.data('updated');

                    $('#dataCp').text(cp);
                    $('#dataSatker').text(satker);
                    $('#dataNpwp').text(npwp);
                    $('#dataKota').text(kota);
                    $('#dataWilayah').text(wilayah);
                    $('#dataTelp').text(telp);
                    $('#dataEmail').text(email);
                    $('#dataStatus').text(status);
                    $('#dataCreatedBy').text(createdby);
                    $('#dataCreated').text(created);
                    $('#dataUpdateBy').text(updateby);
                    $('#dataUpdated').text(updated);

                    $('#modalToggle').modal('show');
                });
            });
        });

        // Function DELETE
        $('.btn-delete').on('click', function() {
            var customerId = $(this).data('id');
            var namaInstansi = $(this).closest('tr').find('td:nth-child(2)').text(); // Ganti dengan selector yang sesuai

            // Set ID dan nama instansi untuk digunakan di tombol "Ya, Hapus"
            $('#modalDeleteBtn').data('id', customerId);
            $('#modalDeleteBtn').data('instansi', namaInstansi);

            // Set pesan konfirmasi dengan nama instansi yang akan dihapus
            var modalText = "Apakah anda yakin hapus data Customer '<b>" + namaInstansi + "</b>'?";
            $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="customerIdInput" name="id_customer" value="' + customerId + '" style="display:none;">');

            $('#modalDelete').on('hidden.bs.modal', function() {
            });

            $('#modalDelete').modal('show');
        });

        $('#modalDeleteBtn').on('click', function() {
            var customerId = $(this).data('id');
            var namaInstansi = $(this).data('instansi');

            $('#modalDelete').modal('hide');

            // Lakukan operasi hapus di sini menggunakan customerId 
            // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
            console.log("Menghapus pelanggan dengan ID:", customerId);
            console.log("Instansi yang dihapus:", namaInstansi);
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
