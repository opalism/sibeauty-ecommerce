<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Dashboard Admin</h2>
            <p class="text-muted">Selamat datang kembali, Admin!</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #D885A3 0%, #C06C8A 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2">Total Pendapatan</h6>
                            <h3 class="fw-bold mb-0">Rp <?= number_format($data['total_income'], 0, ',', '.'); ?></h3>
                        </div>
                        <i class="bi bi-wallet2 fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">Total Pesanan</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $data['total_orders']; ?></h3>
                        </div>
                        <div class="icon-shape bg-light text-primary rounded-circle p-3">
                            <i class="bi bi-bag-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">Total Produk</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $data['total_products']; ?></h3>
                        </div>
                        <div class="icon-shape bg-light text-success rounded-circle p-3">
                            <i class="bi bi-box-seam fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Menu Kelola</h5>
                    <div class="d-grid gap-2">
                        <a href="<?= BASEURL; ?>/admin/products" class="btn btn-outline-dark text-start p-3 rounded-3">
                            <i class="bi bi-boxes me-2"></i> Kelola Produk (Tambah/Edit/Hapus)
                        </a>
                        <a href="<?= BASEURL; ?>/admin/orders" class="btn btn-outline-dark text-start p-3 rounded-3">
                            <i class="bi bi-receipt me-2"></i> Kelola Pesanan Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Pesanan Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Ambil 5 data saja
                                $limit = 0;
                                foreach($data['recent_orders'] as $order): 
                                    if($limit++ >= 5) break;
                                ?>
                                <tr>
                                    <td><small>#<?= $order['id']; ?></small></td>
                                    <td><small><?= $order['user_name']; ?></small></td>
                                    <td><small>Rp <?= number_format($order['total_amount'],0,',','.'); ?></small></td>
                                    <td>
                                        <?php if($order['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Pending</span>
                                        <?php elseif($order['status'] == 'paid'): ?>
                                            <span class="badge bg-success" style="font-size: 0.6rem;">Dibayar</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary" style="font-size: 0.6rem;"><?= $order['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>