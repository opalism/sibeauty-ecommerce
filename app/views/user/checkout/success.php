<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                
                <h2 class="fw-bold mb-3">Pesanan Berhasil Dibuat!</h2>
                <p class="text-muted mb-4">
                    Terima kasih telah berbelanja di Sibeauty. Pesanan Anda dengan ID 
                    <strong class="text-primary">#<?= $data['order_id']; ?></strong> 
                    telah tersimpan.
                </p>
                
                <div class="alert alert-warning text-start border-0 shadow-sm rounded-3" role="alert">
                    <h6 class="fw-bold mb-3 border-bottom border-warning pb-2">
                        <i class="bi bi-info-circle-fill me-2"></i>Instruksi Pembayaran:
                    </h6>
                    
                    <div class="small">
                        <div class="mb-3">
                            <strong class="d-block text-dark mb-1"><i class="bi bi-bank me-1"></i> Transfer Bank:</strong>
                            <ul class="list-unstyled mb-0 ps-3 border-start border-warning border-3">
                                <li class="mb-1">BCA: <strong>123-456-7890</strong> <span class="text-muted">(Sibeauty Official)</span></li>
                                <li>BRI: <strong>0987-654-321</strong> <span class="text-muted">(Sibeauty Official)</span></li>
                            </ul>
                        </div>
                        
                        <div>
                            <strong class="d-block text-dark mb-1"><i class="bi bi-wallet2 me-1"></i> E-Wallet:</strong>
                            <ul class="list-unstyled mb-0 ps-3 border-start border-warning border-3">
                                <li>DANA: <strong>0851-3431-0760</strong> <span class="text-muted">(Naufal Alief)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="<?= BASEURL; ?>/order/payment/<?= $data['order_id']; ?>" class="btn btn-dark py-3 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-upload me-2"></i> Upload Bukti Pembayaran
                    </a>

                    <div class="d-flex gap-2 justify-content-center mt-2">
                        <a href="<?= BASEURL; ?>/product" class="btn btn-outline-secondary rounded-pill px-4">Belanja Lagi</a>
                        <a href="<?= BASEURL; ?>" class="btn btn-outline-secondary rounded-pill px-4">Ke Beranda</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>