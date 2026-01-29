<div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            <h4 class="fw-bold mb-4">Detail Pengiriman</h4>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="<?= BASEURL; ?>/checkout/process" method="post">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Penerima</label>
                            <input type="text" class="form-control rounded-pill px-3" value="<?= $_SESSION['user_session']['name']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Alamat Lengkap</label>
                            <textarea name="address" class="form-control rounded-4 px-3 py-2" rows="3" placeholder="Nama Jalan, No. Rumah, RT/RW" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Kota / Kabupaten</label>
                                <input type="text" name="city" class="form-control rounded-pill px-3" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control rounded-pill px-3" required>
                            </div>
                        </div>
                        
                        <h5 class="fw-bold mt-4 mb-3">Pilih Pembayaran</h5>
<div class="card bg-light border-0 rounded-3 mb-4">
    <div class="card-body p-2">
        
        <div class="form-check p-3 border-bottom bg-white rounded-top">
            <input class="form-check-input ms-1" type="radio" name="payment_method" value="Bank BCA" id="bca" checked>
            <label class="form-check-label ms-2 d-flex justify-content-between fw-bold w-100" for="bca">
                <span>Transfer Bank BCA</span>
                <i class="bi bi-bank"></i>
            </label>
        </div>

        <div class="form-check p-3 border-bottom bg-white">
            <input class="form-check-input ms-1" type="radio" name="payment_method" value="Bank BRI" id="bri">
            <label class="form-check-label ms-2 d-flex justify-content-between fw-bold w-100" for="bri">
                <span>Transfer Bank BRI</span>
                <i class="bi bi-bank"></i>
            </label>
        </div>

    </div>
</div>

<button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-3 fw-bold shadow">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5 mt-4 mt-md-0">
            <h4 class="fw-bold mb-4">Ringkasan Pesanan</h4>
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <?php 
                    $total = 0;
                    foreach($data['cart'] as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="<?= BASEURL; ?>/assets/img/products/<?= $item['image']; ?>" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/50'">
                            <div class="ms-3" style="line-height: 1.2;">
                                <small class="fw-bold d-block"><?= $item['name']; ?></small>
                                <small class="text-muted">x <?= $item['quantity']; ?></small>
                            </div>
                        </div>
                        <span class="fw-bold text-dark">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="text-success fw-bold">Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <span class="fs-5 fw-bold">Total Bayar</span>
                        <span class="fs-5 fw-bold text-danger">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>