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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Data Bank</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah Data</button>
                                    <table class="table" id="ecat">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col" style="width: 25%;">Nama Bank</th>
                                                <th scope="col" style="width: 30%;">Nomor Rekening</th>
                                                <th scope="col" style="width: 30%;">Atas Nama</th>
                                                <th scope="col" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "koneksi.php";
                                                // Query untuk mengambil data dari tabel tb_bank
                                                $query = "SELECT * FROM tb_bank";
                                                $result = mysqli_query($koneksi, $query);
                                                // $data_lama = mysqli_fetch_array($result);


                                                // Hasil query
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $no++ . "</th>";
                                                    echo "<td>" . $row['nama_bank'] . "</td>"; 
                                                    echo "<td>" . $row['no_rekening'] . "</td>"; 
                                                    echo "<td>" . $row['atas_nama'] . "</td>"; 
                                                    echo "<td>
                                                            <button type='button' class='btn btn-warning btn-sm mt-2 btn-edit' 
                                                                data-id='" . $row['id_bank'] . "'    
                                                                data-bank='" . $row['nama_bank'] . "'
                                                                data-rekening='" . $row['no_rekening'] . "'
                                                                data-atasnama='" . $row['atas_nama'] . "'
                                                                data-createdby='" . $row['created_by'] . "'
                                                                data-created='" . $row['created_date'] . "'>
                                                                <i class='bx bx-edit-alt'></i>
                                                            </button>
                                                            <button type='button' class='btn btn-danger btn-sm mt-2 btn-delete' data-id='" . $row['id_bank'] . "'>
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
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Bank - E-Catalogue</h5>
            </div>
            <div class="modal-body">
                <!-- Formulir untuk menambah data bank -->
                <form action="proses/proses_bank.php" method="POST">
                <?php 
                  $uuid = generateUUID(); 
                  $hari = date('d');
                  $tahun = date('y');
                  $bnkuuid = "BNK$uuid$hari$tahun";
                ?>
                    <input type="hidden" class="form-control" name="id_bank" id="id" value = "<?php echo $bnkuuid ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama Bank *</label>
                            <input type="text" name="nama_bank" class="form-control capitalize" pattern="[A-Za-z]+" placeholder="Tulis Nama Bank" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nomor Rekening *</label>
                            <input type="text" name="no_rekening" class="form-control" pattern="[0-9]+" placeholder="Tulis Nomor Rekening" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Atas Nama *</label>
                            <input type="text" name="atas_nama" class="form-control capitalize" pattern="[A-Za-z]+"  placeholder="Tulis Nama Pemilik Rekening" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan-bank">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/vendor/selectize-js/dist/js/selectize.min.js"></script>
    <script>
        $('.normalize2').selectize();
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

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="proses/proses_bank.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus Data Bank</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data Bank :  ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" name="delete-bank" id="modalDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "page/script.php"; ?>

    <script type="text/javascript">
        // Inisialisasi DataTable
        new DataTable('#ecat');

            $('#addBankForm').on('submit', function(event) {
        event.preventDefault();

        // Mengambil data formulir
        var formData = $("#addBankForm").serialize();

        $('#modalCenter').modal('hide');
        });

        // Plugins Search Select
        $('.normalize').selectize();


        // Function DELETE
        $('.btn-delete').on('click', function() {
        var bankId = $(this).data('id');
        var namaBank = $(this).closest('tr').find('td:nth-child(2)').text(); 

        // Set ID dan nama bank untuk digunakan di tombol "Ya, Hapus"
        $('#modalDeleteBtn').data('id', bankId);
        $('#modalDeleteBtn').data('bank', namaBank);

        // Set pesan konfirmasi dengan nama instansi yang akan dihapus
        var modalText = "Apakah anda yakin hapus data Bank '<b>" + namaBank + "</b>'?";
        $('#modalDelete .modal-body p').html(modalText + '<br><input type="hidden" id="bankIdInput" name="id_bank" value="' + bankId + '" style="display:none;">');

        $('#modalDelete').on('hidden.bs.modal', function() {
        });

        $('#modalDelete').modal('show');
        });

        $('#modalDeleteBtn').on('click', function() {
        var bankId = $(this).data('id');
        var namaBank = $(this).data('bank');

        $('#modalDelete').modal('hide');

        // Lakukan operasi hapus di sini menggunakan customerId 
        // Untuk tujuan pengujian, Anda dapat mencetak customerId ke konsol
        console.log("Menghapus pelanggan dengan ID:", bankId);
        console.log("Instansi yang dihapus:", namaBank);
        });
    </script>
</body>
</html>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Data Bank - E-Catalogue</h5>
            </div>
            <form action="proses/proses_bank.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3 mt-2">
                        <input type="hidden" id="id_bank" name="id_bank" class="form-control" required>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Bank</label>
                                <input type="text" id="namaBank" name="nama_bank" class="form-control capitalize" pattern="[A-Za-z]+" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nomor Rekening</label>
                                <input type="text" id="noRekening" name="no_rekening" class="form-control" pattern="[0-9]+" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Atas Nama</label>
                                <input type="text" id="atasNama" name="atas_nama" class="form-control capitalize" pattern="[A-Za-z]+" required>
                            </div>
                        </div>
                        <!-- <input type="text" name="update" class="form-control" id="dataUpdate" required> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit-bank">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handler Tombol Edit
    $('.btn-edit').on('click', function() {
        // Mendapatkan data dari tombol yang ditekan
        var id = $(this).data('id');
        var bank = $(this).data('bank');
        var rekening = $(this).data('rekening');
        var nama = $(this).data('atasnama'); // Corrected variable name
        var createdby = $(this).data('createdby');
        var created = $(this).data('created');
        var updateby = $(this).data('updateby');
        var update = $(this).data('update');

        // Set values in the edit modal
        $('#id_bank').val(id);
        $('#namaBank').val(bank);
        $('#noRekening').val(rekening);
        $('#atasNama').val(nama);
        $('#dataUpdate').val(update); // Corrected variable name

        // Tampilkan modal edit
        $('#modalEdit').modal('show');
    });

    $('.normalize').selectize();
</script>


