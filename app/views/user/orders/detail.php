<div class="container mt-5 py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Detail Pesanan</h3>
        <div>
            <a href="<?= BASEURL; ?>/order/invoice/<?= $data['order']['id']; ?>" target="_blank" class="btn btn-outline-dark rounded-pill me-2">
                <i class="bi bi-printer me-2"></i> Cetak Invoice
            </a>
            <a href="<?= BASEURL; ?>/order" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Invoice #<?= $data['order']['invoice_number']; ?></h5>
                        <span class="badge bg-light text-dark border px-3 py-2">
                            <?= strtoupper($data['order']['status']); ?>
                        </span>
                    </div>
                    <p class="text-muted small mt-2">Dipesan pada <?= date('d F Y, H:i', strtotime($data['order']['order_date'])); ?></p>
                </div>

                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Barang yang dibeli</h6>
                    <div class="mb-4">
                        <?php foreach($data['items'] as $item): ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="<?= BASEURL; ?>/assets/img/products/<?= $item['image']; ?>" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark"><?= $item['name']; ?></h6>
                                <small class="text-muted">Rp <?= number_format($item['price'], 0, ',', '.'); ?> x <?= $item['quantity']; ?></small>
                            </div>
                            <div class="fw-bold">
                                Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4">
                        <h6 class="fw-bold small mb-2">Alamat Pengiriman</h6>
                        <p class="mb-0 text-muted small"><?= nl2br($data['order']['shipping_address']); ?></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5">Total Pembayaran</span>
                        <span class="fs-4 fw-bold text-danger">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                </div>

                <?php if($data['order']['status'] == 'pending'): ?>
                <div class="card-footer bg-warning bg-opacity-10 border-0 p-3 text-center">
                    <small class="text-dark fw-bold">Silakan lakukan pembayaran agar pesanan segera diproses.</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>