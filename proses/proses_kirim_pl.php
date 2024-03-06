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
        include "../koneksi.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil nilai dari formulir
            $id_inv_pl = $_POST['id_inv_pl'];
            $id_driver = $_POST['id_driver'];
            $id_ekspedisi = $_POST['id_ekspedisi'];
            $jenis_pengiriman = $_POST['jenis_pengiriman'];
            $dikirim_oleh = $_POST['dikirim_oleh'];
            $penanggung_jawab = $_POST['penanggung_jawab'];
            
            // Tentukan nilai UUID untuk id_status_kirim
            $uuid = uniqid();
            $hari = date('d');
            $tahun = date('y');
            $KRMuuid = "KRM$uuid$hari$tahun";
            
            // Tentukan nilai tgl_kirim sesuai dengan jenis pengiriman
            if ($jenis_pengiriman == "1") {
                // Diambil Langsung
                $tgl_kirim = $_POST['tgl_kirim_langsung'];
            } elseif ($jenis_pengiriman == "2") {
                // Driver
                $tgl_kirim = $_POST['tgl_kirim_driver'];
            } else {
                // Ekspedisi
                $tgl_kirim = $_POST['tgl_kirim_ekspedisi'];
            }
            
            // Lakukan INSERT ke dalam database
            $query_insert = "INSERT INTO status_kirim (id_inv_ecat, id_status_kirim, id_driver, id_ekspedisi, jenis_pengiriman, tgl_kirim, dikirim_oleh, penanggung_jawab) 
                    VALUES ('$id_inv_pl', '$KRMuuid', '$id_driver', '$id_ekspedisi', '$jenis_pengiriman', '$tgl_kirim', '$dikirim_oleh', '$penanggung_jawab')";
            
            // Eksekusi query INSERT
            if(mysqli_query($koneksi, $query_insert)) {
                // Setelah berhasil melakukan INSERT, lakukan pembaruan ke tabel tb_spk_ecat
                $query_update = "UPDATE tb_spk_pl SET status_spk_pl = 'Dikirim' WHERE id_inv_pl = '$id_inv_pl'";
                
                // Eksekusi query UPDATE
                if(mysqli_query($koneksi, $query_update)) {
                    // Mengambil total spk dari tb_spk_ecat
                    $query_total_invoice = "SELECT SUM(total_spk_pl) AS total FROM tb_spk_pl WHERE id_inv_pl = '$id_inv_pl'";
                    $result_total_invoice = mysqli_query($koneksi, $query_total_invoice);
                    $row_total_invoice = mysqli_fetch_assoc($result_total_invoice);
                    $totalInvoice = $row_total_invoice['total'];

                    // Update total_invoice di tabel inv_ecat dengan total spk
                    $query_update_total = "UPDATE inv_pl SET total_inv_pl = '$totalInvoice' WHERE id_inv_pl = '$id_inv_pl'";
                    $result_update_total = mysqli_query($koneksi, $query_update_total);

                    if($result_update_total) {
                        // Update status_transaksi di inv_ecat menjadi 'Dikirim'
                        $query_update_status_transaksi = "UPDATE inv_pl SET status_transaksi = 'Dikirim' WHERE id_inv_pl = '$id_inv_pl'";
                        $result_update_status_transaksi = mysqli_query($koneksi, $query_update_status_transaksi);

                        if($result_update_status_transaksi) {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: 'Data berhasil Dikirim',
                                        icon: 'success'
                                    }).then(function() {
                                        window.location.href = '../spk_pl_invoice_dicetak.php';
                                    });
                                </script>";
                            exit();
                        } else {
                            echo "ERROR: Gagal memperbarui status transaksi di inv_pl: " . mysqli_error($koneksi);
                        }
                    } else {
                        echo "ERROR: Gagal memperbarui total invoice: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "ERROR: Gagal memperbarui status SPK PL: " . mysqli_error($koneksi);
                }
            } else {
                echo "ERROR: Gagal eksekusi query INSERT: $query_insert. " . mysqli_error($koneksi);
            }
        }
    ?>
</body>
</html>
    
