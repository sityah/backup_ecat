<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        input[type="text"][readonly] {
            border: none;
            background-color: transparent;
            width: 100%;
            outline: none; 
        }
        .border-end {
            border-right: 1px solid #dee2e6 !important;
        }
    </style>
</head>
<body>

<div class="card-body p-2 d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h5 class="card-title mb-0">Tambah Produk Pesanan</h5>
    </div>
</div>
<div class="card-body p-2">
    <div class="row p-1">
        <div class="col-sm-1 mb-2">
            <input type="text" class="form-control text-center bg-light mobile" value="1" readonly>
        </div>
        <div class="col-sm-3 mb-2">
            <input type="hidden" name="id_tmp[]" id="id_1" value="1" readonly>
            <input type="hidden" class="form-control" name="id_spk_reg_tmp[]" value="SPK001" readonly>
            <input type="hidden" class="form-control" name="id_produk_tmp[]" value="PROD001" readonly>
            <input type="text" class="form-control bg-light" value="Nama Produk 1" readonly>
        </div>
        <div class="col-sm-1 mb-2">
            <input type="text" class="form-control bg-light text-center mobile-text" value="pcs" readonly>
        </div>
        <div class="col-sm-2 mb-2">
            <input type="text" class="form-control bg-light text-center mobile-text" value="Merk 1" readonly>
        </div>
        <div class="col-sm-2 mb-2">
            <input type="text" class="form-control bg-light text-end mobile-text" value="10000" readonly>
        </div>
        <div class="col-sm-1 mb-2">
            <input type="text" class="form-control bg-light text-end mobile-text" name="stock" id="stock_1" value="50" readonly>
        </div>
        <div class="col-sm-1 mb-2">
            <input type="text" class="form-control text-end mobile-text" name="qty_tmp[]" id="qtyInput_1" oninput="checkStock('1')" required>
        </div>
        <div class="col-sm-1 mb-2 text-center">
            <button type="button" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></button>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
