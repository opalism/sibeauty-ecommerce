<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-3">Pesanan Berhasil!</h2>
                <p class="text-muted mb-4">Terima kasih telah berbelanja di Sibeauty. Pesanan Anda dengan ID <strong>#<?= $data['order_id']; ?></strong> sedang kami proses.</p>
                
                <div class="alert alert-warning text-start" role="alert">
                    <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-1"></i> Instruksi Pembayaran:</h6>
                    
                    <div class="small">
                        <div class="mb-2">
                            <strong><i class="bi bi-bank me-1"></i> Jika Transfer Bank:</strong><br>
                            • BCA: <strong>1234567890</strong> (Sibeauty Corp)<br>
                            • BRI: <strong>0987654321</strong> (Sibeauty Corp)
                        </div>
                        
                        <div>
                            <strong><i class="bi bi-cash-coin me-1"></i> Jika COD:</strong><br>
                            • Mohon siapkan uang pas sesuai total tagihan saat kurir datang.
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <a href="<?= BASEURL; ?>/order/payment/<?= $data['order_id']; ?>" class="btn btn-warning text-dark fw-bold rounded-pill shadow-sm">
                        <i class="bi bi-upload me-2"></i> Konfirmasi Pembayaran Sekarang
                    </a>

                    <a href="<?= BASEURL; ?>/product" class="btn btn-primary-custom rounded-pill">Belanja Lagi</a>
                    <a href="<?= BASEURL; ?>" class="btn btn-outline-secondary rounded-pill">Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>
</div>