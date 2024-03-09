<?php
// load_products.php

// Masukkan file koneksi database Anda di sini
include "koneksi.php";

// Query untuk mengambil data produk dari database
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

$products = array();

while ($data = mysqli_fetch_array($query)) {
    $product = array(
        'id_produk' => $data['id_produk'],
        'nama_produk' => $data['nama_produk'],
        'nama_merk' => $data['nama_merk'],
        'satuan' => $data['satuan'],
        'stock' => $data['stock']
        // 'spkId' => $_POST['spkId'], // Anda mungkin perlu menyesuaikan ini dengan cara Anda mendapatkan nilai spkId
        // 'no' => $_POST['no'] // Juga untuk nomor, jika diperlukan
    );
    array_push($products, $product);
}

// Mengembalikan data produk dalam format JSON
echo json_encode(array('products' => $products));
?>
