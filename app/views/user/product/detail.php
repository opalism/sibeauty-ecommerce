<div class="container py-3 py-md-5"> 
    
    <div class="mb-3">
        <a href="<?= BASEURL; ?>/product" class="text-decoration-none text-muted small fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="row g-4 g-lg-5"> 
        
        <div class="col-md-5">
            <div class="sticky-md-top" style="top: 90px; z-index: 1;">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-image-wrapper">
                    <div class="d-flex align-items-center justify-content-center h-100 bg-light p-3">
                        <img src="<?= BASEURL; ?>/assets/img/products/<?= $data['product']['image']; ?>" 
                             class="img-fluid product-img-zoom" 
                             alt="<?= $data['product']['name']; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="product-details ps-md-3 ps-lg-4">
                <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2 px-3 py-2 rounded-pill">
                    <?= $data['product']['category_name'] ?? 'Umum'; ?>
                </span>
                
                <h1 class="fw-bold mt-2 mb-2 product-title"><?= $data['product']['name']; ?></h1>
                
                <div class="d-flex align-items-center mb-4">
                    <h2 class="text-primary fw-bold mb-0 me-3">Rp <?= number_format($data['product']['price'], 0, ',', '.'); ?></h2>
                    <?php if(($data['product']['stock'] ?? 0) < 5 && ($data['product']['stock'] ?? 0) > 0): ?>
                        <span class="text-danger small fw-bold bg-danger bg-opacity-10 px-2 py-1 rounded">
                            <i class="bi bi-fire"></i> Stok Menipis!
                        </span>
                    <?php endif; ?>
                </div>

                <div class="description-box mb-4 text-muted">
                    <p class="description-text"><?= nl2br($data['product']['description']); ?></p>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <form action="<?= BASEURL; ?>/cart/add" method="post" class="mt-4">
                    <input type="hidden" name="product_id" value="<?= $data['product']['id']; ?>">
                    
                    <div class="row align-items-end g-3">
                        <div class="col-6 col-md-5 col-lg-4">
                            <label class="form-label small fw-bold text-muted">Jumlah Pesanan</label>
                            <div class="input-group input-group-lg-mobile">
                                <button class="btn btn-outline-secondary btn-minus" type="button"><i class="bi bi-dash"></i></button>
                                <input type="number" name="quantity" class="form-control text-center border-secondary fw-bold" value="1" min="1" max="<?= $data['product']['stock']; ?>" readonly>
                                <button class="btn btn-outline-secondary btn-plus" type="button"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-6 col-md-7 col-lg-8 d-flex align-items-center pb-2">
                             <span class="text-muted small">Tersedia: <strong><?= $data['product']['stock']; ?></strong> pcs</span>
                        </div>

                        <div class="col-12 mt-4" style="position: relative; z-index: 10;"> 
                            <div class="d-grid d-sm-flex gap-2">
                                <?php if(($data['product']['stock'] ?? 0) > 0): ?>
                                    <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill px-lg-5 fw-bold shadow-sm flex-grow-1" style="position: relative; z-index: 20;">
                                        <i class="bi bi-cart-plus me-2"></i> Tambah Keranjang
                                    </button>
                                    <a href="https://wa.me/?text=..." target="_blank" class="btn btn-outline-success btn-lg rounded-pill px-4 fw-bold" style="position: relative; z-index: 20;">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary btn-lg rounded-pill w-100 fw-bold" disabled>
                                        Stok Habis
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-5 g-3">
                    <div class="col-6 col-sm-4">
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="bi bi-shield-check fs-4 text-success"></i>
                            <span>100% Original</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="bi bi-truck fs-4 text-primary"></i>
                            <span>Fast Shipping</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary-custom { background-color: #D885A3; color: white; border: none; transition: all 0.3s; }
    .btn-primary-custom:hover { background-color: #c06c8a; transform: translateY(-2px); color: white; }

    /* Pengaturan Default (Desktop) */
    .product-image-wrapper { height: 500px; }
    .product-title { font-size: 2.5rem; }
    .description-text { line-height: 1.8; font-size: 1rem; }

    /* KHUSUS TABLET (IPAD / MEDIUM DEVICE) */
    @media (min-width: 768px) and (max-width: 991px) {
        .product-image-wrapper {
            height: 380px; /* Tinggi disesuaikan agar tidak memakan layar */
        }
        .product-title {
            font-size: 1.8rem; /* Ukuran font lebih proporsional */
        }
        .description-text {
            font-size: 0.95rem; /* Teks sedikit lebih kecil agar pas */
        }
        .ps-md-3 {
            padding-left: 1.5rem !important; /* Memberi ruang napas antara gambar & teks */
        }
    }

    /* KHUSUS SMARTPHONE (MOBILE) */
    @media (max-width: 767px) {
        .product-image-wrapper { height: 320px; margin-bottom: 0.5rem; }
        .product-title { font-size: 1.5rem; }
        .btn-lg { font-size: 1rem; padding: 12px; }
    }

    .product-img-zoom { max-height: 100%; object-fit: contain; transition: transform 0.3s ease; }
    .product-image-wrapper:hover .product-img-zoom { transform: scale(1.05); }
</style>