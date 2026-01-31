<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - SIBEAUTY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', serif; background: #fff; color: #000; }
        .kop-surat { border-bottom: 3px double #000; margin-bottom: 30px; padding-bottom: 20px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body class="p-5">

    <div class="no-print position-fixed top-0 end-0 p-4">
        <a href="<?= BASEURL; ?>/admin" class="btn btn-secondary me-2">Kembali</a>
        <button onclick="window.print()" class="btn btn-primary">Cetak PDF</button>
    </div>

    <div class="text-center kop-surat">
        <h2 class="fw-bold mb-1">SIBEAUTY INDONESIA</h2>
        <p class="mb-0">Jl. Kecantikan No. 123, Jakarta Selatan, Indonesia</p>
        <p class="mb-0">Email: admin@sibeauty.com | Telp: 021-12345678</p>
    </div>

    <h4 class="text-center fw-bold mb-4">LAPORAN PENJUALAN RESMI</h4>
    <p>Dicetak pada: <?= date('d F Y H:i'); ?></p>

    <table class="table table-bordered border-dark">
        <thead class="table-light border-dark">
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Nama Pelanggan</th>
                <th class="text-end">Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $grandTotal = 0;
                $no = 1;
                if(!empty($data['orders'])):
                    foreach($data['orders'] as $row):
                        $grandTotal += $row['total_amount']; 
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= date('d/m/Y', strtotime($row['created_at'])); ?></td>
                <td><?= $row['invoice_number']; ?></td>
                
                <td><?= $row['user_name']; ?></td>
                
                <td class="text-end">Rp <?= number_format($row['total_amount'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center py-3 fst-italic">Belum ada data penjualan yang selesai (Completed).</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="4" class="text-end">TOTAL PENDAPATAN</td>
                <td class="text-end">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5 text-end">
        <p class="mb-5">Jakarta, <?= date('d F Y'); ?><br>Manager Keuangan</p>
        <br><br>
        <p class="fw-bold text-decoration-underline">Administrator</p>
    </div>

</body>
</html>