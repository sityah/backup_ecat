<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
        session_start();
        include "../koneksi.php";

        // Memastikan bahwa metode yang digunakan adalah POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Mendapatkan data dari form
            $spkId = $_POST['id_spk_ecat'];

            // Query untuk mengambil data dari tabel tmp_produk_spk_ecat
            $query = "SELECT 
                        sr.id_spk_ecat,
                        tps.id_tmp_ecat,
                        tps.id_produk_ecat,
                        spr.stock, 
                        tpr.nama_produk, 
                        tpr.satuan,
                        tps.qty,
                        tps.status_tmp,
                        tpr.harga_produk,
                        tm.nama_merk  
                    FROM mandir36_db_ecat_staging.tmp_produk_spk_ecat AS tps
                    LEFT JOIN mandir36_db_ecat_staging.tb_spk_ecat AS sr ON sr.id_spk_ecat = tps.id_spk_ecat
                    LEFT JOIN mandir36_staging.stock_produk_ecat AS spr ON tps.id_produk_ecat = spr.id_produk_ecat
                    LEFT JOIN mandir36_staging.tb_produk_ecat AS tpr ON tps.id_produk_ecat = tpr.id_produk_ecat
                    LEFT JOIN mandir36_staging.tb_merk AS tm ON tpr.id_merk = tm.id_merk 
                    WHERE sr.id_spk_ecat = '$spkId' AND tps.status_tmp = 1";
            $result = mysqli_query($koneksi, $query);

            // Memasukkan data ke dalam tabel transaksi_produk_ecat
            $success = true; // Variabel untuk menandai apakah insert berhasil atau tidak
            while ($row = mysqli_fetch_assoc($result)) {
                $idSpk = $row['id_spk_ecat'];
                $idProdukEcat = $row['id_produk_ecat'];
                $namaProduk = $row['nama_produk']; 
                $hargaProduk = $row['harga_produk'];
                $qty = $row['qty'];

                $disc = null;
                $totalHarga = $hargaProduk * $qty;

                // Mendapatkan tanggal saat ini
                $createdDate = date('Y-m-d H:i:s');

                $idTransaksiEcat = mysqli_real_escape_string($koneksi, uuid());

                // Query untuk memasukkan data ke dalam tabel transaksi_produk_ecat
                $queryInsert = "INSERT INTO transaksi_produk_ecat (id_transaksi_ecat, id_spk, id_produk, nama_produk_spk, harga, qty, disc, total_harga, status_trx, created_date) 
                                VALUES ('$idTransaksiEcat', '$idSpk', '$idProdukEcat', '$namaProduk', '$hargaProduk', '$qty', '$disc', '$totalHarga', '0', '$createdDate')";
                $insertResult = mysqli_query($koneksi, $queryInsert);
                
                // Jika insert gagal, atur variabel success menjadi false
                if (!$insertResult) {
                    $success = false;
                    break;
                }
            }

            // Jika semua insert berhasil, update kolom status_spk_ecat menjadi "Dalam Proses"
            if ($success) {
                $updateQuery = "UPDATE tb_spk_ecat SET status_spk_ecat = 'Dalam Proses' WHERE id_spk_ecat = '$spkId'";
                mysqli_query($koneksi, $updateQuery);

                // Setelah berhasil insert ke transaksi_produk_ecat, hapus data dari tmp_produk_spk_ecat
                $deleteQuery = "DELETE FROM tmp_produk_spk_ecat WHERE id_spk_ecat = '$spkId'";
                mysqli_query($koneksi, $deleteQuery);
            }

            // Menutup koneksi
            mysqli_close($koneksi);

            if ($success) {
                echo '<script>
                        Swal.fire({
                            title: "Sukses!",
                            text: "Pesanan berhasil di Proses!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "../data_spk.php";
                        });
                    </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal melakukan Proses Pesanan!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "../data_spk.php";
                        });
                    </script>';
            }

        }
        // Fungsi untuk menghasilkan UUID dalam format string
        function uuid() {
            $data = random_bytes(12); // 12 byte yang tersisa
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
            return 'TRXE' . vsprintf('%s%s-%s', str_split(bin2hex($data), 4));
        }
    ?>
</body>
</html>

