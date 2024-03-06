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
                <!-- Button trigger modal -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <main id="main" class="main">
                        <section>
                            <div class="card p-3">
                                <div class="card-header text-center">
                                    <h5><strong>FORM EDIT CUSTOMER</strong></h5>
                                </div>
                                <form action="proses_customer.php" method="post">
                                <?php
                                    include "koneksi.php";
                                    $id = $_GET['id'];
                                    $query = "SELECT tb_customer.*, tb_perusahaan.nama_perusahaan, tb_perusahaan.alamat_perusahaan FROM tb_customer
                                        LEFT JOIN tb_perusahaan ON tb_customer.id_perusahaan = tb_perusahaan.id_perusahaan
                                        WHERE id_customer = '$id'";
                                        $result = mysqli_query($koneksi, $query);
                                        $data = mysqli_fetch_array($result);
                                        $perusahaan_id = $data['id_perusahaan'];
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group" style="margin-bottom: 20px;">
                                                <label for=""><strong>Status Customer</strong></label>
                                                <div class="form-check form-check-inline" style="margin-left: 20px;">
                                                    <input class="form-check-input" type="radio" name="status_cs" id="inlineRadio1" value="Aktif" <?php echo ($data['status_cs'] == 'Aktif') ? 'checked' : ''; ?> required>
                                                    <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_cs" id="inlineRadio2" value="Tidak Aktif" <?php echo ($data['status_cs'] == 'Tidak Aktif') ? 'checked' : ''; ?> required>
                                                    <label class="form-check-label" for="inlineRadio2">Tidak Aktif</label>
                                                </div>
                                            </div>
                                            <input type="hidden" id="id_customer" name="id_customer" class="form-control" value="<?php echo $data['id_customer']; ?>" required>
                                            <div class="mt-3">
                                                <label>Nama Contact Person </label>
                                                <input type="text" class="form-control capitalize" id="cp" name="nama_contact_person" pattern="[A-Za-z]+" value="<?php echo $data['nama_contact_person']?>">
                                            </div>
                                            <div class="mt-3">
                                                <label>Nama Perusahaan</label>
                                                <input type="hidden" id="id_perusahaan" name="id_perusahaan" class="form-control" value="<?php echo $perusahaan_id ?>" required>
                                                <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" data-bs-toggle="modal" data-bs-target="#selectperusahaan" readonly="readonly" value="<?php echo $data['nama_perusahaan']?>">
                                            </div>
                                            <div class="mt-3">
                                                <label>Alamat Perusahaan </label>
                                                <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" readonly="readonly"><?php echo $data['alamat_perusahaan']?></textarea>
                                            </div>
                                            <div class="mt-3">
                                                <label>No. NPWP </label>
                                                <input type="text" class="form-control" id="npwp" name="no_npwp_instansi" pattern="[0-9]+" value="<?php echo $data['no_npwp_instansi']?>">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mt-3">
                                                <label for="" class="form-label">No. Telp</label>
                                                <input type="text" class="form-control bg-white" id="telp" name="no_telp_cs" pattern="[0-9]+" minlength="11" maxlength="13" value="<?php echo $data['no_telp_cs']?>">
                                            </div>
                                            <div class="mt-3">
                                                <label for="" class="form-label">Email</label>
                                                <input type="text" class="form-control bg-white" id="email" name="email_cs" pattern=".+@.+" value="<?php echo $data['email_cs']?>" oninvalid="this.setCustomValidity('Please include an \'@\' in the email address')" oninput="this.setCustomValidity('')">
                                            </div>
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" name="edit-cs" class="btn btn-primary btn-md m-2"><i class="bx bx-save"></i> Simpan Data</button>
                                        <a href="data_customer.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle"></i> Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
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
                                    <th scope="col" style="width: 5%;">No</th>
                                    <th scope="col" style="width: 40%;">Nama Perusahaan</th>
                                    <th scope="col" style="width: 40%;">Alamat</th>
                                    <th scope="col" style="width: 15%;">Aksi</th>
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
                                        <td style='width: 5%;'><?php echo $no; ?></td>
                                        <td style='width: 40%;'><?php echo $row['nama_perusahaan'] ?></td>
                                        <td style='width: 40%;'><?php echo $row['alamat_perusahaan']?></td>
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
    <?php include "page/script.php"; ?>
</body>
</html>
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


