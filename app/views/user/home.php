<section class="hero-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #FFF5F7 0%, #fae1eb 100%); border-radius: 0 0 50px 50px;">
    <div class="container position-relative z-2">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <span class="badge px-3 py-2 rounded-pill shadow-sm mb-3 animate-fade-in" style="background-color: #D885A3; color: white;">✨ SPESIAL KOLEKSI 2026</span>
                <h1 class="display-4 fw-bold mb-3 text-dark lh-tight animate-slide-up">Cantik Alami, <br><span style="color: #D885A3;">Elegan</span> Setiap Hari</h1>
                <p class="lead text-muted mb-4 pe-lg-5 animate-slide-up delay-100">Temukan koleksi perawatan kulit premium yang dikurasi khusus untuk memancarkan pesona aslimu.</p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3 animate-slide-up delay-200">
                    <a href="<?= BASEURL; ?>/product" class="btn btn-primary-custom btn-lg shadow rounded-pill px-5 fw-bold">Belanja Sekarang <i class="bi bi-bag-heart ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative d-inline-block">
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-white shadow-sm" style="width: 350px; height: 350px; opacity: 0.5; z-index: 1;"></div>
                    <img src="https://watermark.lovepik.com/photo/20211208/large/lovepik-young-women-skin-care-products-display-cosmetics-picture_501587337.jpg" class="img-fluid rounded-4 position-relative hero-animate-img shadow-lg" alt="Sibeauty Model" style="z-index: 2; max-height: 450px; border: 5px solid rgba(255,255,255,0.7);">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-dark">Kategori Favorit</h3>
            <div class="mx-auto" style="width: 60px; height: 3px; background-color: #D885A3;"></div>
        </div>
        <div class="row g-4 justify-content-center text-center">
            <?php 
            $cats = [['name'=>'Skincare','icon'=>'bi-droplet-half'], ['name'=>'Make Up','icon'=>'bi-stars'], ['name'=>'Bodycare','icon'=>'bi-water'], ['name'=>'Fragrance','icon'=>'bi-flower1']];
            foreach($cats as $cat): 
            ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 bg-transparent category-card h-100">
                    <div class="category-icon-wrapper rounded-circle bg-white mx-auto d-flex align-items-center justify-content-center shadow-sm mb-3">
                        <i class="bi <?= $cat['icon']; ?> fs-1 text-pink"></i>
                    </div>
                    <h6 class="fw-bold text-secondary"><?= $cat['name']; ?></h6>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light bg-opacity-50">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold text-dark">Produk Terlaris</h3>
                <p class="text-muted mb-0 small">Pilihan terbaik minggu ini</p>
            </div>
            <a href="<?= BASEURL; ?>/product" class="btn btn-outline-custom rounded-pill btn-sm px-4 fw-bold">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        
        <div class="row g-4">
            <?php if(!empty($data['products'])): ?>
                <?php foreach($data['products'] as $product): ?>
                <div class="col-6 col-md-3">
                    <div class="card card-product h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <?php if($product['stock'] < 1): ?>
                            <div class="position-absolute top-0 start-0 m-3 z-3"><span class="badge bg-secondary">Habis</span></div>
                        <?php endif; ?>

                        <div class="bg-white d-flex align-items-center justify-content-center p-4 position-relative overflow-hidden" style="height: 220px;">
                            <img src="<?= BASEURL; ?>/assets/img/<?= $product['image']; ?>" 
                                 class="img-fluid product-img transition-img" 
                                 alt="<?= $product['name']; ?>"
                                 onerror="this.src='<?= BASEURL; ?>/assets/img/no-image.jpg'" 
                                 style="max-height: 100%; object-fit: contain;">
                        </div>

                        <div class="card-body bg-white">
                            <h6 class="fw-bold text-dark text-truncate mb-1"><?= $product['name']; ?></h6>
                            <p class="text-pink fw-bold fs-5 mb-3">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            <div class="d-flex gap-2">
                                <a href="<?= BASEURL; ?>/product/detail/<?= $product['id']; ?>" class="btn btn-outline-dark btn-sm rounded-pill flex-grow-1">Detail</a>
                                <?php if($product['stock'] > 0): ?>
                                    <form action="<?= BASEURL; ?>/cart/add" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-custom btn-sm rounded-circle shadow-sm"><i class="bi bi-cart-plus"></i></button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-light btn-sm rounded-circle border" disabled><i class="bi bi-x-lg"></i></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5"><p class="text-muted">Belum ada produk.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .text-pink { color: #D885A3 !important; }
    .btn-primary-custom { background-color: #D885A3 !important; color: white !important; border: none; transition: 0.3s; }
    .btn-primary-custom:hover { background-color: #c4728f !important; transform: translateY(-3px); }
    .btn-custom { background-color: #D885A3; color: white; border: none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
    .btn-custom:hover { background-color: #b05c7a; }
    .btn-outline-custom { color: #D885A3; border: 2px solid #D885A3; transition: 0.3s; }
    .btn-outline-custom:hover { background-color: #D885A3; color: white; }
    .category-icon-wrapper { width: 100px; height: 100px; border: 2px solid #FDEFF4; transition: 0.3s; }
    .category-card:hover .category-icon-wrapper { transform: scale(1.1); border-color: #D885A3; }
    .card-product { transition: transform 0.3s, box-shadow 0.3s; }
    .card-product:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    .product-img { transition: transform 0.5s; }
    .card-product:hover .product-img { transform: scale(1.05); }
    .hero-animate-img { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
    .animate-slide-up { animation: slideUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.1s; } .delay-200 { animation-delay: 0.2s; }
    @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
</style>