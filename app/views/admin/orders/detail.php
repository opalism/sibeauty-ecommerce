<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-secondary mb-1">Detail Pesanan #<?= $data['order']['invoice_number']; ?></h3>
            <span class="text-muted small">ID Order: <?= $data['order']['id']; ?></span>
        </div>
        <a href="<?= BASEURL; ?>/admin/orders" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Daftar Produk</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th>Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $grandTotal = 0;
                                foreach($data['items'] as $item): 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $grandTotal += $subtotal;
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= BASEURL; ?>/assets/img/products/<?= $item['image']; ?>" 
                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0"><?= $item['name']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?= $item['quantity']; ?></td>
                                <td class="text-end pe-4 fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold py-3">Total Pesanan:</td>
                                <td class="text-end pe-4 fw-bold fs-5 text-primary">
                                    Rp <?= number_format($grandTotal, 0, ',', '.'); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Update Status</h5>
                    
                    <?php Flasher::flash(); ?>

                    <form action="<?= BASEURL; ?>/admin/updateOrder" method="POST">
                        <input type="hidden" name="order_id" value="<?= $data['order']['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Status Saat Ini</label>
                            <select name="status" class="form-select border-2" style="border-color: #D885A3;">
                                <option value="pending" <?= $data['order']['status'] == 'pending' ? 'selected' : ''; ?>>⏳ Pending (Menunggu)</option>
                                <option value="paid" <?= $data['order']['status'] == 'paid' ? 'selected' : ''; ?>>💰 Paid (Sudah Bayar)</option>
                                <option value="shipping" <?= $data['order']['status'] == 'shipping' ? 'selected' : ''; ?>>🚚 Shipping (Dikirim)</option>
                                <option value="completed" <?= $data['order']['status'] == 'completed' ? 'selected' : ''; ?>>✅ Completed (Selesai)</option>
                                <option value="cancelled" <?= $data['order']['status'] == 'cancelled' ? 'selected' : ''; ?>>❌ Cancelled (Batal)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-pill">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <?php if(!empty($data['order']['payment_proof'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-3 text-start">Bukti Pembayaran</h5>
                    <div class="position-relative overflow-hidden rounded border" style="cursor: pointer;">
                        <img src="<?= BASEURL; ?>/assets/img/payments/<?= $data['order']['payment_proof']; ?>" 
                             class="img-fluid" 
                             alt="Bukti Transfer"
                             onclick="window.open(this.src)">
                    </div>
                    <small class="text-muted mt-2 d-block"><i class="bi bi-zoom-in"></i> Klik gambar untuk memperbesar</small>
                </div>
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Info Pelanggan</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><small class="text-muted d-block">Nama</small> <strong><?= $data['order']['user_name']; ?></strong></li>
                        <li class="mb-2"><small class="text-muted d-block">Email</small> <?= $data['order']['email']; ?></li>
                        <li class="mb-2"><small class="text-muted d-block">Tanggal</small> <?= date('d M Y H:i', strtotime($data['order']['created_at'])); ?></li>
                        <li class="mb-2"><small class="text-muted d-block">Metode Bayar</small> <span class="badge bg-secondary"><?= strtoupper($data['order']['payment_method']); ?></span></li>
                        <li><small class="text-muted d-block">Alamat Pengiriman</small> <?= $data['order']['shipping_address']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>