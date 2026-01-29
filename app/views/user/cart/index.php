<div class="container py-5">
    <h2 class="fw-bold mb-4">Keranjang Belanja</h2>
    
    <div class="mb-3">
        <?php Flasher::flash(); ?>
    </div>

    <?php if(empty($data['cart'])): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <p class="mt-3 text-muted">Keranjang kamu masih kosong.</p>
            <a href="<?= BASEURL; ?>/product" class="btn btn-primary-custom rounded-pill mt-2">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Produk</th>
                                        <th class="py-3">Harga</th>
                                        <th class="py-3">Jumlah</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $grandTotal = 0;
                                    foreach($data['cart'] as $item): 
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $grandTotal += $subtotal;
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= BASEURL; ?>/assets/img/products/<?= $item['image']; ?>" 
                                                     class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;"
                                                     onerror="this.src='https://via.placeholder.com/60?text=P'">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-bold"><?= $item['name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                        <td>
                                            <input type="number" value="<?= $item['quantity']; ?>" class="form-control form-control-sm text-center" style="width: 60px;" readonly>
                                        </td>
                                        <td class="fw-bold text-danger">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="<?= BASEURL; ?>/cart/delete/<?= $item['cart_id']; ?>" class="btn btn-sm text-danger" onclick="return confirm('Hapus produk ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Belanja</span>
                            <span class="fw-bold">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Bayar</span>
                            <span class="fw-bold fs-5 text-danger">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></span>
                        </div>
                       <a href="<?= BASEURL; ?>/checkout" class="btn btn-primary-custom w-100 rounded-pill py-2 shadow">Checkout Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>