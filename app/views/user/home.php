<section class="hero-section py-5" style="background: linear-gradient(135deg, #FFF5F7 0%, #FDEFF4 100%); border-radius: 0 0 50px 50px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start text-center mb-5 mb-md-0">
                <span class="badge mb-3 px-3 py-2 rounded-pill shadow-sm" style="background-color: #D885A3; color: white;">
                    ✨ Spesial Koleksi 2026
                </span>
                <h1 class="display-4 fw-bold mb-3" style="color: #4A4A4A; line-height: 1.2;">
                    Cantik Alami,<br><span style="color: #D885A3;">Elegan</span> Setiap Hari
                </h1>
                <p class="lead text-muted mb-4 pe-md-5">
                    Temukan koleksi perawatan kulit premium yang dikurasi khusus untuk memancarkan pesona asli Anda dengan bahan alami terbaik.
                </p>
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="<?= BASEURL; ?>/product" class="btn btn-primary-custom btn-lg shadow rounded-pill px-5">
                        Belanja Sekarang
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 text-center">
                <div class="position-relative">
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 400px; height: 400px; background-color: rgba(216, 133, 163, 0.1); z-index: 1;"></div>
                    
                    <img src="https://watermark.lovepik.com/photo/20211208/large/lovepik-young-women-skin-care-products-display-cosmetics-picture_501587337.jpg" 
                         class="img-fluid rounded-4 position-relative hero-animate-img" 
                         alt="Sibeauty Banner" 
                         style="z-index: 2; max-height: 450px;">
                         
                    <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-4 shadow-sm d-none d-lg-block" style="z-index: 3; transform: translate(-20%, -20%);">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-success fs-3 me-2"></i>
                            <div class="text-start">
                                <h6 class="fw-bold mb-0 small">BPOM Approved</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">100% Produk Aman</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-5" style="color: #4A4A4A;">Kategori Favorit</h3>
        <div class="row g-4 justify-content-center text-center">
            <?php 
            $cats = [
                ['name' => 'Skincare', 'icon' => 'bi-droplet-half'],
                ['name' => 'Make Up', 'icon' => 'bi-stars'],
                ['name' => 'Bodycare', 'icon' => 'bi-water'],
                ['name' => 'Fragrance', 'icon' => 'bi-flower1']
            ];
            foreach($cats as $cat): 
            ?>
            <div class="col-6 col-md-3">
                <div class="card border-0 bg-transparent category-card">
                    <div class="rounded-circle bg-white mx-auto d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 120px; height: 120px; border: 2px solid #FDEFF4; transition: 0.3s;">
                        <i class="bi <?= $cat['icon']; ?> fs-1" style="color: #D885A3;"></i>
                    </div>
                    <p class="mt-3 fw-bold text-secondary"><?= $cat['name']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Produk Terlaris</h3>
            <a href="<?= BASEURL; ?>/product" class="text-decoration-none fw-bold" style="color: #D885A3;">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            <?php if(!empty($data['products'])): ?>
                <?php foreach($data['products'] as $product): ?>
                <div class="col-6 col-md-3">
                    <div class="card card-product h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img src="<?= BASEURL; ?>/assets/img/products/<?= $product['image']; ?>" 
                                 class="img-fluid p-3" 
                                 alt="<?= $product['name']; ?>"
                                 onerror="this.src='https://via.placeholder.com/300x300/f8f9fa/adb5bd?text=No+Image'"
                                 style="max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold text-truncate mb-1"><?= $product['name']; ?></h6>
                            <p class="text-danger fw-bold mb-3">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            <a href="<?= BASEURL; ?>/product/detail/<?= $product['id']; ?>" class="btn btn-sm btn-outline-dark w-100 rounded-pill">Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted italic">Belum ada produk yang ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    /* Styling tambahan ini bisa dihapus jika style.css sudah diupdate, 
       tapi dibiarkan saja juga aman buat jaga-jaga */
    .btn-primary-custom {
        background-color: #D885A3 !important;
        color: white !important;
        border: none;
        transition: 0.3s;
    }
    .btn-primary-custom:hover {
        background-color: #c4728f !important;
        transform: translateY(-3px);
    }
    .card-product:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>