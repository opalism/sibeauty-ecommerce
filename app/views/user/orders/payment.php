<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-4 text-center">Konfirmasi Pembayaran</h4>
                    
                    <div class="alert alert-info small">
                        Silakan upload foto bukti transfer / struk ATM agar pesanan <strong>#<?= $data['order']['invoice_number']; ?></strong> segera diproses.
                    </div>

                    <div class="d-flex justify-content-between mb-4 bg-light p-3 rounded">
                        <span>Total Tagihan:</span>
                        <span class="fw-bold text-danger fs-5">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?></span>
                    </div>

                    <form action="<?= BASEURL; ?>/order/submitPayment" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="<?= $data['order']['id']; ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Bukti Transfer</label>
                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                            <div class="form-text">Format JPG/PNG/JPEG. Pastikan tulisan terbaca jelas.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom rounded-pill">Kirim Bukti Pembayaran</button>
                            <a href="<?= BASEURL; ?>/order" class="btn btn-outline-secondary rounded-pill">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>