<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-pink text-white text-center py-4 position-relative">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-wallet2 me-2"></i>Konfirmasi Pembayaran</h5>
                    <p class="mb-0 small text-white-50 mt-1">Selesaikan pembayaran agar pesananmu segera diproses</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-5">
                        <small class="text-muted text-uppercase fw-bold ls-1">Total Tagihan</small>
                        <h1 class="fw-bold text-dark display-4 my-2">
                            Rp <?= number_format($data['order']['total_amount'], 0, ',', '.'); ?>
                        </h1>
                        <div class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-hourglass-split me-1"></i>Menunggu Pembayaran
                        </div>
                    </div>

                    <div class="card bg-light border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                                <i class="bi bi-bank me-2"></i>Transfer ke Rekening Berikut:
                            </h6>
                            
                            <div class="vstack gap-3">
                                <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-3 border">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" height="25" width="50" style="object-fit: contain;">
                                        <div>
                                            <div class="small text-muted fw-bold">BANK BCA</div>
                                            <div class="fw-bold fs-5 text-dark user-select-all">123-456-7890</div>
                                            <div class="small text-muted">a.n Sibeauty Official</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-light btn-sm rounded-circle" onclick="navigator.clipboard.writeText('1234567890')"><i class="bi bi-files"></i></button>
                                </div>

                                <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-3 border">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.png" height="25" width="50" style="object-fit: contain;">
                                        <div>
                                            <div class="small text-muted fw-bold">BANK BRI</div>
                                            <div class="fw-bold fs-5 text-dark user-select-all">0987-654-321</div>
                                            <div class="small text-muted">a.n Sibeauty Official</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-light btn-sm rounded-circle" onclick="navigator.clipboard.writeText('0987654321')"><i class="bi bi-files"></i></button>
                                </div>

                                <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-3 border">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" height="25" width="50" style="object-fit: contain;">
                                        <div>
                                            <div class="small text-muted fw-bold">DANA (E-Wallet)</div>
                                            <div class="fw-bold fs-5 text-dark user-select-all">0851-3431-0760</div>
                                            <div class="small text-muted">a.n Naufal Alief</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-light btn-sm rounded-circle" onclick="navigator.clipboard.writeText('085134310760')"><i class="bi bi-files"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="<?= BASEURL; ?>/order/uploadProof" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="<?= $data['order']['id']; ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Upload Bukti Transfer</label>
                            <div class="input-group input-group-lg">
                                <input type="file" class="form-control" id="proof" name="payment_proof" required>
                                <label class="input-group-text" for="proof"><i class="bi bi-upload"></i></label>
                            </div>
                            <div class="form-text text-muted small mt-2">
                                <i class="bi bi-info-circle me-1"></i>Format: JPG, PNG, JPEG (Maks. 2MB)
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-bold shadow-sm transition-hover">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>

                    <div class="text-center mt-4 border-top pt-4">
                        <p class="small text-muted mb-2">Mengalami kendala saat pembayaran?</p>
                        <a href="https://wa.me/6283195725280?text=Halo%20Admin,%20saya%20mau%20konfirmasi%20pembayaran%20Order%20ID:%20<?= $data['order']['invoice_number']; ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-4">
                            <i class="bi bi-whatsapp me-2"></i>Hubungi Admin
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-pink { background-color: #D885A3 !important; }
    .ls-1 { letter-spacing: 1px; }
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; transition: 0.3s; }
</style>