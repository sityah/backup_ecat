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
                    <main id="main" class="main">
                        <section>
                            <?php
                            include "koneksi.php";
                            $id = $_GET['id'];
                            $query = "SELECT tb_sales_ecat.*, tb_kota.nama_kota_kab, tb_provinsi.nama_provinsi, tb_perusahaan.nama_perusahaan, tb_perusahaan.alamat_perusahaan FROM tb_sales_ecat
                                LEFT JOIN tb_kota ON tb_sales_ecat.id_kota_kab = tb_kota.id_kota_kab
                                LEFT JOIN tb_provinsi ON tb_sales_ecat.id_provinsi = tb_provinsi.id_provinsi
                                LEFT JOIN tb_perusahaan ON tb_sales_ecat.id_perusahaan = tb_perusahaan.id_perusahaan
                                WHERE id_sales = '$id'";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_array($result);
                                $provinsi_id = $data['id_provinsi'];
                                $kota_id = $data['id_kota_kab'];
                                $perusahaan_id = $data['id_perusahaan'];
                            ?>
                        <div id="" class="card shadow p-2">
                            <form action="proses/proses_sales.php" method="POST">
                            <div class="card-body" style="margin-top: -20px;">
                            <div class="card-header text-center">
                                <h5 style="margin-bottom: 30px;"><strong>FORM EDIT SALES</strong></h5>
                                <hr style="margin-bottom: 0px;">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label for="statusCustomer"><strong>Status Sales</strong></label>
                                        <div class="form-check form-check-inline" style="margin-left: 20px;">
                                            <input class="form-check-input" type="radio" name="status_sales" id="inlineRadio1" value="Aktif" <?php echo ($data['status_sales'] == 'Aktif') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_sales" id="inlineRadio2" value="Tidak Aktif" <?php echo ($data['status_sales'] == 'Tidak Aktif') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="inlineRadio2">Tidak Aktif</label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="id_sales" name="id_sales" class="form-control" value="<?php echo $data['id_sales']; ?>" required>
                                    <div class="mt-3">
                                        <label for="" class="form-label">Nama Sales</label>
                                        <input type="text" class="form-control capitalize" id="sales" name="nama_sales" value="<?php echo $data['nama_sales']?>">
                                    </div>
                                    <div class="mt-3">
                                        <label>Alamat </label>
                                        <textarea class="form-control" id="alamat" name="alamat"><?php echo $data['alamat']?></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label>Nama Perusahaan</label>
                                        <input type="hidden" id="id_perusahaan" name="id_perusahaan" class="form-control" value="<?php echo $perusahaan_id ?>" required>
                                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" data-bs-toggle="modal" data-bs-target="#selectperusahaan" readonly="readonly" value="<?php echo $data['nama_perusahaan']?>">
                                    </div>
                                    <div class="mt-3">
                                        <label for="no_spk" class="form-label">No. NPWP </label>
                                        <input type="text" class="form-control" id="npwp" name="no_npwp" pattern="[0-9]+" value="<?php echo $data['no_npwp']?>">
                                    </div>
                                    <div class="mt-3">
                                        <label>Alamat Perusahaan </label>
                                        <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" readonly="readonly"><?php echo $data['alamat_perusahaan']?></textarea>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label for=""><strong>Jenis Sales</strong></label>
                                        <div class="form-check form-check-inline" style="margin-left: 20px;">
                                            <input class="form-check-input" type="radio" name="jenis_sales" id="inlineRadio3" value="Pribadi" <?php echo ($data['jenis_sales'] == 'Pribadi') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="inlineRadio3">Pribadi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_sales" id="inlineRadio4" value="Instansi" <?php echo ($data['jenis_sales'] == 'Instansi') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="inlineRadio4">Instansi / Perusahaan</label>
                                        </div>
                                    </div>
                                    <div id="selectData" class="mt-3">
                                        <!-- Provinsi -->
                                        <div class="col-sm mb-3">
                                            <label class="form-label">Wilayah / Provinsi</label>
                                            <select class="form-select" id="selectProvinsi" name="selectProvinsi">
                                                <option value="<?php echo $data['id_provinsi']; ?>"><?php echo $data['nama_provinsi']; ?></option>
                                                <?php  
                                                include "koneksi.php";
                                                $provinsi_query = "SELECT * FROM tb_provinsi";
                                                $result_provinsi = $koneksi->query($provinsi_query);
                                                while ($data_provinsi = mysqli_fetch_array($result_provinsi)) {
                                                ?>
                                                    <option value="<?php echo $data_provinsi['id_provinsi']; ?>"><?php echo $data_provinsi['nama_provinsi']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <!-- Kota/Kabupaten -->
                                        <div class="col-sm mb-3">
                                            <label for="selectKota" class="form-label">Pilih Kota:</label>
                                            <select class="form-select" id="selectKota" name="selectKota">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="" class="form-label">No. Telp</label>
                                        <input type="text" class="form-control bg-white" id="telpSales" name="no_telp_sales" pattern="[0-9]+" minlength="11" maxlength="13" value="<?php echo $data['no_telp_sales']?>">
                                    </div>
                                    <div class="mt-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control bg-white" id="emailSales" name="email_sales" pattern=".+@.+" value="<?php echo $data['email_sales']?>" oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" name="edit-sales" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                    <a href="data_sales.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        </section>
                    </main><!-- End #main -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "page/script.php"; ?>

    <div class="modal fade" id="selectperusahaan">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Perusahaan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table" id="editCs">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th style="width: 200px">Nama Perusahaan</th>
                                    <th style="width: 250px">Alamat</th>
                                    <th style="width: 50px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "koneksi.php";
                                $query = "SELECT id_perusahaan, nama_perusahaan, alamat_perusahaan FROM tb_perusahaan";
                                $result = mysqli_query($koneksi, $query);
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row['nama_perusahaan'] ?></td>
                                        <td><?php echo $row['alamat_perusahaan']?></td>
                                        <td>
                                        <button type="button" id="pilih" class="btn btn-primary btn-sm mt-2 btn-pilih" data-id="<?php echo $row['id_perusahaan'] ?>" data-nama="<?php echo $row['nama_perusahaan'] ?>" data-alamat="<?php echo $row['alamat_perusahaan']?>">
                                            <?php echo ($row['id_perusahaan'] == $perusahaan_id) ? 'Terpilih' : 'Pilih'; ?>
                                        </button>

                                        </td>
                                    </tr>
                                    <?php $no++ ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan elemen radio button jenis sales
    var jenisSalesRadio = document.querySelectorAll('input[name="jenis_sales"]');
    // Mendapatkan elemen field nama perusahaan dan alamat perusahaan
    var namaPerusahaanField = document.getElementById('nama_perusahaan');
    var alamatPerusahaanField = document.getElementById('alamat_perusahaan');
    var alamatField = document.getElementById('alamat');

    // Fungsi untuk menyembunyikan field nama perusahaan dan alamat perusahaan
    function hideFields() {
        namaPerusahaanField.parentElement.style.display = 'none';
        alamatPerusahaanField.parentElement.style.display = 'none';
    }

    // Fungsi untuk menampilkan field nama perusahaan dan alamat perusahaan
    function showFields() {
        namaPerusahaanField.parentElement.style.display = '';
        alamatPerusahaanField.parentElement.style.display = '';
    }

    // Fungsi untuk menampilkan field nama perusahaan dan alamat perusahaan
    function hideAlamatFields() {
        alamatField.parentElement.style.display = 'none';
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
        });
    });

    if (document.querySelector('input[name="jenis_sales"]:checked').value === 'Instansi') {
        showFields();
        hideAlamatFields()
    }
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        // Inisialisasi Selectize pada elemen input
        var selectizeProvinsi = $('#selectProvinsi').selectize();
        var selectizeKota = $('#selectKota').selectize();

        // Menghubungkan Selectize dengan elemen <select> yang sesungguhnya
        var selectProvinsi = selectizeProvinsi[0].selectize;
        var selectKota = selectizeKota[0].selectize;

        // Set nilai awal untuk selectProvinsi
        selectProvinsi.setValue('<?php echo $provinsi_id; ?>');

        // Manual trigger perubahan untuk memicu pemilihan kota
        selectProvinsi.on('change', function(){
            var selectedProvinsi = selectProvinsi.getValue();
            
            // Destroy Selectize untuk selectKota
            selectKota.destroy();

            // Reinitialize Selectize untuk selectKota
            $('#selectKota').selectize({
                create: false,
                sortField: 'text',
                onChange: function(value) {
                    // Lakukan sesuatu jika nilai berubah
                }
            });

            // Menghubungkan kembali objek Selectize dengan elemen <select> yang baru
            selectKota = $('#selectKota')[0].selectize;

            $.ajax({
                url: 'get_kota_kab.php',
                type: 'POST',
                data: {provinsi_id: selectedProvinsi},
                dataType: 'json',
                success: function(response){
                    if (response.success) {
                        // Menambahkan opsi kota dari data yang diperoleh
                        $.each(response.data, function(key, value){
                            selectKota.addOption({value: value.id_kota_kab, text: value.nama_kota_kab});
                        });

                        // Set nilai awal untuk selectKota
                        selectKota.setValue('<?php echo $kota_id; ?>');

                        // Aktifkan kembali pilihan kota
                        selectKota.enable();
                    } else {
                        console.log('Error: ' + response.error);
                        alert('Terjadi kesalahan saat mengambil data kota. Silakan coba lagi.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Ajax request failed: ' + textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                    alert('Terjadi kesalahan saat melakukan permintaan data kota. Silakan coba lagi.');
                }
            });
        });

        // Pilih Provinsi secara otomatis untuk memicu perubahan
        selectProvinsi.trigger('change');
    });
</script>
<script>
    // Fungsi untuk menyembunyikan tombol "Terpilih"
    function hideTerpilihButtons() {
        $('#editCs tbody button[data-id]').each(function() {
            if ($(this).html() === 'Terpilih') {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    }

    // Panggil fungsi hideTerpilihButtons saat dokumen siap
    $(document).ready(function() {
        hideTerpilihButtons();
    });

    $('#selectperusahaan').on('click', '#pilih', function(e) {
        var idPerusahaan = $(this).data('id');
        var namaPerusahaan = $(this).data('nama');
        var alamatPerusahaan = $(this).data('alamat');

        if ($('#id_perusahaan').val() === idPerusahaan) {
            // Perusahaan sudah terpilih, kembalikan ke "Pilih"
            $('#id_perusahaan').val('');
            $('#nama_perusahaan').val('');
            $('#alamat_perusahaan').val('');

            // Mengubah tombol "Terpilih" ke "Pilih"
            $(this).html('Pilih');
            $(this).prop('disabled', false);
        } else {
            // Menandai perusahaan sebagai terpilih
            $('#id_perusahaan').val(idPerusahaan);
            $('#nama_perusahaan').val(namaPerusahaan);
            $('#alamat_perusahaan').val(alamatPerusahaan);

            // Mengubah tombol "Pilih" ke "Terpilih"
            $(this).html('Terpilih');
            $(this).prop('disabled', true);

            // Menonaktifkan tombol "Pilih" pada baris perusahaan sebelumnya (jika ada)
            $('#editCs tbody button[data-id]').each(function() {
                if ($(this).data('id') !== idPerusahaan) {
                    $(this).html('Pilih');
                    $(this).prop('disabled', false);
                }
            });
        }

        // Memanggil fungsi hideTerpilihButtons setelah mengubah status tombol
        hideTerpilihButtons();

        // Menambahkan atribut data-bs-dismiss="modal" secara dinamis
        $('#selectperusahaan').attr('data-bs-dismiss', 'modal');
    });
</script>

<script>
    new DataTable('#editCs');
</script>
