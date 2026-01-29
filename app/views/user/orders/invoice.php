<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $data['title']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            -webkit-print-color-adjust: exact;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        /* Header */
        .brand-title { color: #D885A3; font-weight: 800; font-size: 24px; text-decoration: none; }
        .brand-subtitle { color: #1f2937; }
        
        /* Table */
        .table-custom { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table-custom th { background-color: #f9fafb; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        .table-custom td { padding: 16px 12px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .table-custom tr:last-child td { border-bottom: none; }
        
        /* Status Badge */
        .badge-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-paid { background-color: #d1fae5; color: #065f46; border: 1px solid #065f46; }
        .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #92400e; }

        /* Total Section */
        .total-box { background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-top: 20px; }

        /* Print Settings */
        @media print {
            body { background: #fff; }
            /* UPDATE: Margin Top biar gak mepet kertas */
            .invoice-box { box-shadow: none; border: none; padding: 0; margin-top: 50px !important; } 
            .no-print { display: none !important; }
            .btn { display: none; }
        }
        
        .btn-print {
            background-color: #1f2937; color: white; border: none; padding: 10px 20px; 
            border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block;
        }
        .btn-back {
            background-color: transparent; color: #4b5563; border: 1px solid #d1d5db; padding: 10px 20px; 
            border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="no-print" style="max-width: 800px; margin: 20px auto; text-align: right;">
        <?php 
            // LOGIC PINTAR: Cek siapa yang sedang login
            $backLink = BASEURL . '/order'; // Default untuk User Biasa
            
            if(isset($_SESSION['user_session']) && $_SESSION['user_session']['role'] == 'admin') {
                $backLink = BASEURL . '/admin/orders'; // Jika Admin, balik ke Panel Admin
            }
        ?>
        <a href="<?= $backLink; ?>" class="btn-back">&laquo; Kembali</a>
        <button onclick="window.print()" class="btn-print">Cetak Invoice</button>
    </div>

    <div class="invoice-box">
        <table style="width: 100%; margin-bottom: 40px;">
            <tr>
                <td style="vertical-align: top;">
                    <div class="brand-title">SI<span class="brand-subtitle">BEAUTY</span></div>
                    <div style="font-size: 14px; color: #6b7280; margin-top: 5px;">
                        Jl. Teknologi No. 1, Bandung<br>
                        cs@sibeauty.com | 0812-3456-7890
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <h1 style="font-size: 24px; margin: 0; color: #111;">INVOICE</h1>
                    <div style="font-size: 14px; color: #6b7280; margin-top: 5px;">
                        #<?= $data['order']['invoice_number']; ?>
                    </div>
                    <div style="margin-top: 10px;">
                        <?php if($data['order']['status'] == 'paid' || $data['order']['status'] == 'shipped' || $data['order']['status'] == 'completed'): ?>
                            <span class="badge-status badge-paid">LUNAS</span>
                        <?php else: ?>
                            <span class="badge-status badge-pending">BELUM LUNAS</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <strong style="font-size: 12px; text-transform: uppercase; color: #6b7280;">Ditagihkan Kepada:</strong>
                    <div style="font-size: 16px; font-weight: 600; margin-top: 5px;"><?= $data['order']['user_name']; ?></div>
                    <div style="font-size: 14px; color: #4b5563; margin-top: 2px;">
                        <?= isset($data['order']['user_phone']) ? $data['order']['user_phone'] : '-'; ?><br>
                        <?= $data['order']['shipping_address']; ?>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <strong style="font-size: 12px; text-transform: uppercase; color: #6b7280;">Detail Pesanan:</strong>
                    <table style="width: 100%; font-size: 14px; margin-top: 5px; color: #4b5563;">
                        <tr>
                            <td style="padding: 2px 0;">Tanggal Pemesanan:</td>
                            <td style="text-align: right; font-weight: 600;">
                                <?= isset($data['order']['created_at']) ? date('d M Y, H:i', strtotime($data['order']['created_at'])) : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 0;">Metode Pembayaran:</td>
                            <td style="text-align: right; font-weight: 600;"><?= $data['order']['payment_method']; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['items'] as $item): ?>
                <tr>
                    <td>
                        <strong style="color: #111;"><?= isset($item['product_name']) ? $item['product_name'] : $item['name']; ?></strong>
                    </td>
                    <td style="text-align: right;">Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                    <td style="text-align: center;"><?= $item['quantity']; ?></td>
                    <td style="text-align: right; font-weight: 600;">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-box">
            <table style="width: 100%; font-size: 14px;">
                <tr>
                    <td style="text-align: right; padding-bottom: 5px; color: #6b7280;">Subtotal</td>
                    <td style="text-align: right; width: 150px; padding-bottom: 5px;">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-bottom: 10px; color: #6b7280;">Ongkos Kirim</td>
                    <td style="text-align: right; width: 150px; padding-bottom: 10px;">Rp 0</td>
                </tr>
                <tr style="border-top: 1px solid #e5e7eb;">
                    <td style="text-align: right; padding-top: 10px; font-weight: 700; font-size: 18px;">TOTAL BAYAR</td>
                    <td style="text-align: right; padding-top: 10px; font-weight: 700; font-size: 18px; color: #D885A3;">
                        Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #9ca3af;">
            <p>Terima kasih telah berbelanja di SIBEAUTY. Simpan invoice ini sebagai bukti pembayaran yang sah.</p>
            <p>&copy; <?= date('Y'); ?> Sibeauty Corp.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Kasih jeda 1 detik biar layout render dulu baru print
            setTimeout(function() {
                // Uncomment baris bawah kalau mau otomatis print saat dibuka
                // window.print();
            }, 1000);
        }
    </script>
</body>
</html>