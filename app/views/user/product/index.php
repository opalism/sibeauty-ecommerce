<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: #4A4A4A;">Katalog <span style="color: #D885A3;">Produk</span></h2>
        <p class="text-muted">Temukan produk perawatan terbaik untuk kulitmu.</p>
    </div>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-grid text-pink me-2"></i>Kategori</h5>
                    <hr>
                    <div class="accordion accordion-flush" id="categoryAccordion">
                        <div class="accordion-item border-0">
                             <a href="<?= BASEURL; ?>/product" class="text-decoration-none d-block py-2 text-dark fw-bold hover-pink">Semua Produk</a>
                        </div>
                        <?php foreach($data['categories'] as $parent): ?>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <?php if(!empty($parent['children'])): ?>
                                    <button class="accordion-button collapsed px-0 shadow-none fw-bold text-secondary bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#cat<?= $parent['id']; ?>">
                                        <?= $parent['name']; ?>
                                    </button>
                                <?php else: ?>
                                    <a href="<?= BASEURL; ?>/product/category/<?= $parent['id']; ?>" class="text-decoration-none d-block py-3 fw-bold text-secondary hover-pink"><?= $parent['name']; ?></a>
                                <?php endif; ?>
                            </h2>
                            <?php if(!empty($parent['children'])): ?>
                            <div id="cat<?= $parent['id']; ?>" class="accordion-collapse collapse" data-bs-parent="#categoryAccordion">
                                <div class="accordion-body py-2 ps-3">
                                    <ul class="list-unstyled mb-0 border-start border-2 ps-3" style="border-color: #FDEFF4 !important;">
                                        <li class="mb-2"><a href="<?= BASEURL; ?>/product/category/<?= $parent['id']; ?>" class="text-decoration-none small text-muted hover-pink">Semua <?= $parent['name']; ?></a></li>
                                        <?php foreach($parent['children'] as $child): ?>
                                        <li class="mb-2"><a href="<?= BASEURL; ?>/product/category/<?= $child['id']; ?>" class="text-decoration-none small text-muted hover-pink"><?= $child['name']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded-3">
                <span class="text-muted small">Menampilkan <strong><?= count($data['products']); ?></strong> produk</span>
                <div class="small text-muted">Urutkan: Terbaru</div>
            </div>

            <div class="row g-3 row-cols-2 row-cols-md-3">
                <?php if(!empty($data['products'])): ?>
                    <?php foreach($data['products'] as $product): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 product-card overflow-hidden">
                            <?php if($product['stock'] < 1): ?>
                                <div class="position-absolute top-0 start-0 m-2 z-1"><span class="badge bg-secondary">Habis</span></div>
                            <?php endif; ?>

                            <div class="bg-white d-flex align-items-center justify-content-center p-3 position-relative" style="height: 200px;">
                                <img src="<?= BASEURL; ?>/assets/img/<?= $product['image']; ?>" 
                                     class="img-fluid" 
                                     alt="<?= $product['name']; ?>"
                                     onerror="this.src='<?= BASEURL; ?>/assets/img/no-image.jpg'"
                                     style="max-height: 100%; object-fit: contain;">
                            </div>

                            <div class="card-body p-3 bg-white">
                                <small class="text-muted d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    <?= isset($product['category_name']) ? $product['category_name'] : 'PRODUK'; ?>
                                </small>
                                <h6 class="fw-bold text-dark text-truncate mb-1"><?= $product['name']; ?></h6>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-pink fw-bold">Rp <?= number_format($product['price'], 0, ',', '.'); ?></span>
                                    <?php if($product['stock'] > 0): ?>
                                        <form action="<?= BASEURL; ?>/cart/add" method="POST">
                                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-custom btn-sm rounded-circle shadow-sm"><i class="bi bi-plus-lg"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-light btn-sm rounded-circle border" disabled><i class="bi bi-x"></i></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= BASEURL; ?>/product/detail/<?= $product['id']; ?>" class="stretched-link"></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5"><p class="text-muted">Produk tidak ditemukan.</p></div>
                <?php endif; ?>
            </div>

            <?php if(isset($data['totalPages']) && $data['totalPages'] > 1): ?>
            <div class="d-flex justify-content-center mt-5">
                <nav>
                    <ul class="pagination">
                        <?php for($i=1; $i <= $data['totalPages']; $i++): ?>
                            <li class="page-item <?= ($data['currentPage'] ?? 1) == $i ? 'active' : ''; ?>">
                                <a class="page-link rounded-circle mx-1 border-0 fw-bold <?= ($data['currentPage'] ?? 1) == $i ? 'bg-pink text-white shadow' : 'text-secondary bg-light'; ?>" href="<?= BASEURL; ?>/product/index/<?= $i; ?>" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
    .text-pink { color: #D885A3 !important; }
    .bg-pink { background-color: #D885A3 !important; }
    .hover-pink:hover { color: #D885A3 !important; }
    .btn-custom { background-color: #D885A3; color: white; border:none; transition: 0.2s; width: 32px; height: 32px; display:flex; align-items:center; justify-content:center;}
    .btn-custom:hover { background-color: #b05c7a; color: white; transform: scale(1.1); }
    .accordion-button:not(.collapsed) { color: #D885A3; background-color: transparent; box-shadow: none; }
    .accordion-button:focus { box-shadow: none; border-color: rgba(0,0,0,.125); }
    .product-card { transition: transform 0.2s, box-shadow 0.2s; position: relative; z-index: 1; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .btn-custom { position: relative; z-index: 2; }
</style>