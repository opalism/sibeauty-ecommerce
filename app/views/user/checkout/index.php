<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Checkout Pengiriman</h4>
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <form action="<?= BASEURL; ?>/checkout/process" method="POST">
                        
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-pink"></i>Data Penerima</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama Penerima</label>
                                <input type="text" name="receiver_name" class="form-control" value="<?= $data['user']['name']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nomor Telepon (WhatsApp)</label>
                                <input type="number" name="receiver_phone" class="form-control" value="<?= $data['user']['phone'] ?? ''; ?>" placeholder="08..." required>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2 text-pink"></i>Alamat Pengiriman</h6>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Nama Jalan, RT/RW, Nomor Rumah" required><?= $data['user']['address'] ?? ''; ?></textarea>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Kecamatan</label>
                                <input type="text" name="district" class="form-control" placeholder="Contoh: Sukasari" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Kota / Kabupaten</label>
                                <input type="text" name="city" class="form-control" placeholder="Contoh: Bandung" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Provinsi</label>
                                <input type="text" name="province" class="form-control" placeholder="Contoh: Jawa Barat" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Kode Pos</label>
                                <input type="number" name="postal_code" class="form-control" placeholder="40123" required>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-pink"></i>Metode Pembayaran</h6>
                        <div class="card bg-light border-0">
                            <div class="card-body p-2">
                                <div class="form-check p-3 border-bottom bg-white rounded-top">
                                    <input class="form-check-input ms-1" type="radio" name="payment_method" value="Bank BCA" id="bca" checked>
                                    <label class="form-check-label ms-2 d-flex justify-content-between fw-bold w-100" for="bca">
                                        <span>Transfer Bank BCA</span>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" height="20" alt="BCA">
                                    </label>
                                </div>

                                <div class="form-check p-3 border-bottom bg-white">
                                    <input class="form-check-input ms-1" type="radio" name="payment_method" value="Bank BRI" id="bri">
                                    <label class="form-check-label ms-2 d-flex justify-content-between fw-bold w-100" for="bri">
                                        <span>Transfer Bank BRI</span>
                                        <img src="https://tse2.mm.bing.net/th/id/OIP.0pj0upGhy7h8Q-ZFTTM0XAHaGU?rs=1&pid=ImgDetMain&o=7&rm=3" height="40" alt="BRI">
                                    </label>
                                </div>

                                <div class="form-check p-3 bg-white rounded-bottom">
                                    <input class="form-check-input ms-1" type="radio" name="payment_method" value="Dana" id="dana">
                                    <label class="form-check-label ms-2 d-flex justify-content-between fw-bold w-100" for="dana">
                                        <span>DANA / E-Wallet</span>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" height="20" alt="DANA">
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h4 class="fw-bold mb-4">Ringkasan</h4>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-3">
                        <?php $total = 0; ?>
                        <?php foreach($data['cart_items'] as $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="d-flex align-items-center">
                                <img src="<?= BASEURL; ?>/assets/img/products/<?= $item['image']; ?>" class="rounded-3 me-3 border" width="50" height="50" style="object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 small fw-bold text-truncate" style="max-width: 150px;"><?= $item['name']; ?></h6>
                                    <small class="text-muted"><?= $item['quantity']; ?> x Rp <?= number_format($item['price'], 0, ',', '.'); ?></small>
                                </div>
                            </div>
                            <span class="small fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span class="text-success fw-bold">Gratis</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Bayar</span>
                            <span class="fw-bold fs-5 text-pink">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                        </div>
                        
                        <input type="hidden" name="total_amount" value="<?= $total; ?>">
                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-bold shadow-sm">Buat Pesanan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>