<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - SIBEAUTY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS KHUSUS PRINT */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; -webkit-print-color-adjust: exact; }
            .table-responsive { overflow: visible !important; }
        }
        body { background-color: #f8f9fa; color: #333; }
        .kop-surat { border-bottom: 3px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .logo-text { font-weight: 800; font-size: 24px; color: #D885A3; text-transform: uppercase; letter-spacing: 2px; }
    </style>
</head>
<body class="p-5">

    <div class="container bg-white p-5 shadow-sm rounded-4" style="min-height: 297mm;">
        
        <div class="d-flex justify-content-between mb-4 no-print">
            <a href="<?= BASEURL; ?>/admin" class="btn btn-outline-secondary">
                &larr; Kembali ke Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-primary fw-bold px-4" style="background-color: #D885A3; border:none;">
                <i class="bi bi-printer"></i> Cetak PDF / Print
            </button>
        </div>

        <div class="text-center kop-surat">
            <h1 class="logo-text mb-2">SIBEAUTY INDONESIA</h1>
            <p class="mb-0">Jl. Teknologi No. 123, Kampus Digital, Indonesia</p>
            <p class="small text-muted">Email: admin@sibeauty.com | Telp: 0812-3456-7890</p>
        </div>

        <div class="text-center mb-5">
            <h3 class="fw-bold text-uppercase text-decoration-underline">Laporan Penjualan Resmi</h3>
            <p class="text-muted">Periode: Semua Waktu</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $grandTotal = 0;
                    if(!empty($data['orders'])): 
                        foreach($data['orders'] as $order): 
                            // PERBAIKAN: Gunakan 'total_amount' sesuai database
                            $grandTotal += $order['total_amount']; 
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($order['created_at'])); ?></td>
                        <td class="text-center fw-bold text-primary">#<?= $order['invoice_number']; ?></td>
                        <td><?= $order['customer_name']; ?></td>
                        <td class="text-end fw-bold">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data penjualan selesai (Completed).</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold fs-5 pe-4">TOTAL PENDAPATAN</td>
                        <td class="text-end fw-bold fs-5 text-success">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-5 pt-5">
            <div class="col-4 offset-8 text-center">
                <p class="mb-5">Subang, <?= date('d F Y'); ?></p>
                <br><br>
                <p class="fw-bold text-decoration-underline mb-0">Administrator</p>
                <small>Manager Keuangan</small>
            </div>
        </div>

    </div>

</body>
</html>