<div class="container py-5">
    <h2 class="mb-4 fw-bold" style="color: #D885A3;">Keranjang Belanja</h2>

    <div class="row">
        <div class="col-lg-8">
            <?php Flasher::flash(); ?>
            
            <?php if(empty($data['cart'])): ?>
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <h4>Keranjang kamu masih kosong</h4>
                    <p>Yuk cari produk favoritmu!</p>
                    <a href="<?= BASEURL; ?>/product" class="btn btn-primary rounded-pill px-4 mt-2" style="background-color: #D885A3; border: none;">Belanja Sekarang</a>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Produk</th>
                                        <th class="py-3">Harga</th>
                                        <th class="py-3">Jumlah</th>
                                        <th class="py-3">Total</th>
                                        <th class="pe-4 py-3 text-end">Aksi</th>
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
                                                     alt="<?= $item['name']; ?>" 
                                                     class="rounded me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0 text-dark fw-medium"><?= $item['name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                        <td style="width: 150px;">
                                            <form action="<?= BASEURL; ?>/cart/add" method="POST" class="d-flex align-items-center">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" 
                                                       class="form-control form-control-sm text-center mx-1" 
                                                       style="width: 60px;" min="1" max="<?= $item['stock']; ?>">
                                                <button type="submit" class="btn btn-sm btn-light border" title="Update">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="fw-bold" style="color: #D885A3;">
                                            Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="<?= BASEURL; ?>/cart/delete/<?= $item['id']; ?>" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Hapus?');">
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
            <?php endif; ?>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Item</span>
                        <span><?= isset($data['cart']) ? count($data['cart']) : 0; ?> Barang</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total Harga</span>
                        <span class="fw-bold fs-5" style="color: #D885A3;">
                            Rp <?= isset($grandTotal) ? number_format($grandTotal, 0, ',', '.') : 0; ?>
                        </span>
                    </div>
                    
                    <?php if(!empty($data['cart'])): ?>
                        <a href="<?= BASEURL; ?>/checkout" class="btn btn-dark w-100 py-2 rounded-pill fw-bold">
                            Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 py-2 rounded-pill" disabled>Checkout</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>