<div class="container py-5">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <?php if(isset($data['keyword'])): ?>
                <h2 class="fw-bold">Hasil Pencarian: "<?= $data['keyword']; ?>"</h2>
                <a href="<?= BASEURL; ?>/product" class="btn btn-sm btn-outline-secondary rounded-pill mb-3">Reset</a>
            <?php elseif(isset($data['category_id'])): ?>
                <h2 class="fw-bold"><?= $data['title']; ?></h2>
                <p class="text-muted">Kategori Pilihan.</p>
            <?php else: ?>
                <h2 class="fw-bold">Katalog Produk</h2>
                <p class="text-muted">Belanja produk kecantikan terbaik.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>
    <div class="row g-4">
        <?php if(empty($data['products'])): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Produk tidak ditemukan.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['products'] as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden">
                        
                        <?php if($product['stock'] <= 0): ?>
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white fw-bold z-2">HABIS</div>
                        <?php endif; ?>

                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <img src="<?= BASEURL; ?>/assets/img/products/<?= $product['image']; ?>" class="card-img-top p-3" style="object-fit: contain; max-height: 100%;">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted"><?= isset($product['category_name']) ? $product['category_name'] : 'Umum'; ?></small>
                                
                                <?php if($product['stock'] > 0): ?>
                                    <small class="text-success fw-bold">Sisa: <?= $product['stock']; ?></small>
                                <?php else: ?>
                                    <small class="text-danger fw-bold">Habis</small>
                                <?php endif; ?>
                            </div>

                            <h6 class="card-title fw-bold text-truncate"><?= $product['name']; ?></h6>
                            <p class="text-primary fw-bold">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            
                            <div class="mt-auto">
                                <?php if($product['stock'] > 0): ?>
                                    <a href="<?= BASEURL; ?>/product/detail/<?= $product['id']; ?>" class="btn btn-outline-dark rounded-pill btn-sm w-100 stretched-link">Lihat Detail</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary rounded-pill btn-sm w-100" disabled>Stok Habis</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if(isset($data['totalPages']) && $data['totalPages'] > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <?php 
                $url = isset($data['category_id']) ? BASEURL . '/product/category/' . $data['category_id'] . '/' : BASEURL . '/product/index/';
            ?>
            <li class="page-item <?= ($data['page'] <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link rounded-pill px-3 me-2" href="<?= $url . ($data['page'] - 1); ?>">Prev</a>
            </li>
            <?php for($i = 1; $i <= $data['totalPages']; $i++): ?>
                <li class="page-item">
                    <a class="page-link rounded-circle mx-1 <?= ($data['page'] == $i) ? 'active bg-dark text-white' : 'text-dark'; ?>" href="<?= $url . $i; ?>" style="width: 40px; height: 40px; text-align: center; line-height: 25px;"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($data['page'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                <a class="page-link rounded-pill px-3 ms-2" href="<?= $url . ($data['page'] + 1); ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>