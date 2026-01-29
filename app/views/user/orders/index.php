<div class="container py-5">
    <h3 class="fw-bold mb-4">Riwayat Pesanan</h3>

    <?php if(empty($data['orders'])): ?>
        <div class="text-center py-5">
            <i class="bi bi-receipt display-1 text-muted"></i>
            <p class="mt-3 text-muted">Belum ada pesanan.</p>
            <a href="<?= BASEURL; ?>/product" class="btn btn-primary-custom rounded-pill">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <?php foreach($data['orders'] as $order): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block mb-1">
                                    <?= date('d M Y', strtotime($order['order_date'])); ?>
                                </small>
                                <h6 class="fw-bold mb-0">#<?= $order['invoice_number']; ?></h6>
                            </div>
                            <?php 
                                $statusColor = 'secondary';
                                if($order['status'] == 'pending') $statusColor = 'warning text-dark';
                                if($order['status'] == 'paid') $statusColor = 'info text-dark';
                                if($order['status'] == 'shipped') $statusColor = 'primary';
                                if($order['status'] == 'completed') $statusColor = 'success';
                                if($order['status'] == 'cancelled') $statusColor = 'danger';
                            ?>
                            <span class="badge bg-<?= $statusColor; ?> rounded-pill px-3 py-2">
                                <?= ucfirst($order['status']); ?>
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-end border-top pt-3">
                            <div>
                                <small class="text-muted">Total Belanja</small>
                                <p class="fw-bold text-dark fs-5 mb-0">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></p>
                            </div>
                            
                            <div class="d-flex gap-2 align-items-center">
                                
                                <?php if($order['status'] == 'pending' && empty($order['payment_proof'])): ?>
                                    <a href="<?= BASEURL; ?>/order/payment/<?= $order['id']; ?>" class="btn btn-sm btn-warning fw-bold rounded-pill px-3 shadow-sm">
                                        Konfirmasi Bayar
                                    </a>
                                
                                <?php elseif($order['status'] == 'pending' && !empty($order['payment_proof'])): ?>
                                    <span class="badge bg-secondary text-light py-2 px-3 rounded-pill">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu Verifikasi
                                    </span>
                                <?php endif; ?>

                                <a href="<?= BASEURL; ?>/order/detail/<?= $order['id']; ?>" class="btn btn-sm btn-outline-dark rounded-pill px-4">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>