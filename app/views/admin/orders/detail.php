<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?= BASEURL; ?>/admin/orders" class="text-decoration-none text-muted mb-2 d-block">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
            <h3 class="fw-bold">Order #<?= $data['order']['invoice_number']; ?></h3>
        </div>
        
        <a href="<?= BASEURL; ?>/order/invoice/<?= $data['order']['id']; ?>" target="_blank" class="btn btn-secondary rounded-pill shadow-sm">
            <i class="bi bi-printer me-2"></i> Cetak Invoice
        </a>
    </div>

    <div class="mb-3">
        <?php Flasher::flash(); ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Status Pesanan</h6>
                    
                    <div class="mb-3">
                        <?php 
                            $status = $data['order']['status'];
                            $badgeClass = 'bg-secondary'; // Default

                            if($status == 'pending') {
                                $badgeClass = 'bg-warning text-dark';
                            } elseif($status == 'paid' || $status == 'shipped' || $status == 'completed') {
                                $badgeClass = 'bg-success';
                            } elseif($status == 'cancelled') {
                                $badgeClass = 'bg-danger';
                            }
                        ?>
                        <span class="badge <?= $badgeClass; ?> fs-6 px-3 py-2 rounded-pill text-uppercase w-100 d-block text-center mb-2">
                            <?= $status; ?>
                        </span>

                        <div class="text-center small fw-bold">
                            <?php if($status == 'paid' || $status == 'shipped' || $status == 'completed'): ?>
                                <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> SUDAH LUNAS</span>
                            <?php else: ?>
                                <span class="text-warning"><i class="bi bi-hourglass-split me-1"></i> BELUM LUNAS</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <form action="<?= BASEURL; ?>/admin/orderUpdateStatus" method="post">
                        <input type="hidden" name="order_id" value="<?= $data['order']['id']; ?>">
                        <label class="fw-bold small mb-2">Update Status Manual:</label>
                        <div class="input-group">
                            <select name="status" class="form-select form-select-sm border-secondary">
                                <option value="pending" <?= $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="paid" <?= $status == 'paid' ? 'selected' : ''; ?>>Paid (Dibayar)</option>
                                <option value="shipped" <?= $status == 'shipped' ? 'selected' : ''; ?>>Shipped (Dikirim)</option>
                                <option value="completed" <?= $status == 'completed' ? 'selected' : ''; ?>>Completed (Selesai)</option>
                                <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : ''; ?>>Cancelled (Batal)</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-dark">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Info Pelanggan</h6>
                    <p class="mb-1 fw-bold"><?= $data['order']['user_name']; ?></p>
                    <p class="mb-1 small text-muted"><?= $data['order']['email']; ?></p>
                    <p class="mb-1 small text-muted"><?= isset($data['order']['user_phone']) ? $data['order']['user_phone'] : '-'; ?></p>
                    
                    <hr>
                    
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Alamat Pengiriman</h6>
                    <p class="mb-0 text-muted small" style="line-height: 1.6;">
                        <?= nl2br($data['order']['shipping_address']); ?>
                    </p>
                    
                    <hr>
                    
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Bukti Pembayaran</h6>
                    <?php if(!empty($data['order']['payment_proof'])): ?>
                        <div class="mb-3">
                            <a href="<?= BASEURL; ?>/assets/img/payments/<?= $data['order']['payment_proof']; ?>" target="_blank">
                                <img src="<?= BASEURL; ?>/assets/img/payments/<?= $data['order']['payment_proof']; ?>" class="img-fluid rounded shadow-sm border" alt="Bukti Transfer">
                            </a>
                        </div>
                        <div class="alert alert-success small py-2 mb-0">
                            <i class="bi bi-check-circle me-1"></i> Bukti terlampir.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning small py-2 mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada bukti.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted text-uppercase mb-4">Item Pesanan</h6>
                    
                    <?php foreach($data['items'] as $item): ?>
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="<?= BASEURL; ?>/assets/img/products/<?= isset($item['product_image']) ? $item['product_image'] : 'default.jpg'; ?>" 
                             class="rounded-3 border" 
                             style="width: 70px; height: 70px; object-fit: cover;">
                        
                        <div class="ms-3 flex-grow-1">
                            <h6 class="fw-bold mb-1"><?= isset($item['product_name']) ? $item['product_name'] : $item['name']; ?></h6>
                            <small class="text-muted">
                                Rp <?= number_format($item['price'], 0, ',', '.'); ?> x <?= $item['quantity']; ?> pcs
                            </small>
                        </div>
                        
                        <div class="fw-bold fs-6">
                            Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2">
                        <span class="fs-5 fw-bold text-dark">Total Transaksi</span>
                        <span class="fs-3 fw-bold text-primary">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>