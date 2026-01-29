<div class="container py-5">
    
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <h3 class="fw-bold m-0">Kelola Produk</h3>
        </div>
        <div class="col-md-5">
            <div class="input-group shadow-sm rounded-pill overflow-hidden">
                <span class="input-group-text bg-white border-0 ps-3">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchInput" class="form-control border-0 py-2" placeholder="Cari nama produk untuk restock...">
            </div>
        </div>
        <div class="col-md-3 text-end">
            <a href="<?= BASEURL; ?>/admin/productCreate" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Tambah
            </a>
        </div>
    </div>

    <div class="mb-3">
        <button class="btn btn-sm btn-outline-danger rounded-pill px-3 me-2" onclick="filterLowStock()">
            <i class="bi bi-exclamation-triangle me-1"></i> Stok Menipis (< 10)
        </button>
        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="resetFilter()">
            Lihat Semua
        </button>
    </div>

    <div class="mb-3">
        <?php Flasher::flash(); ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="productTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">No</th>
                            <th class="py-3">Gambar</th>
                            <th class="py-3">Nama Produk</th>
                            <th class="py-3">Harga</th>
                            <th class="py-3" style="width: 150px;">Stok</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['products'])): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada produk.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no=1; foreach($data['products'] as $product): ?>
                            <tr class="product-row">
                                <td class="ps-4 text-muted small"><?= $no++; ?></td>
                                <td>
                                    <img src="<?= BASEURL; ?>/assets/img/products/<?= $product['image']; ?>" 
                                         class="rounded border shadow-sm" 
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark product-name"><?= $product['name']; ?></div>
                                    <small class="text-muted" style="font-size: 0.7rem;">ID: #<?= $product['id']; ?></small>
                                </td>
                                <td class="small">Rp <?= number_format($product['price'], 0, ',', '.'); ?></td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                            // Logic warna badge stok
                                            $stockColor = 'bg-secondary';
                                            if($product['stock'] <= 5) $stockColor = 'bg-danger';
                                            elseif($product['stock'] <= 15) $stockColor = 'bg-warning text-dark';
                                        ?>
                                        <span class="badge <?= $stockColor; ?> me-2 px-3 rounded-pill stock-value">
                                            <?= $product['stock']; ?>
                                        </span>
                                        
                                        <button type="button" class="btn btn-sm btn-success rounded-circle shadow-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#restockModal<?= $product['id']; ?>" 
                                                style="width: 30px; height: 30px;">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </td>
                                
                                <td class="text-end pe-4">
                                    <a href="<?= BASEURL; ?>/admin/productEdit/<?= $product['id']; ?>" class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="bi bi-pencil"></i></a>
                                    <a href="<?= BASEURL; ?>/admin/productDelete/<?= $product['id']; ?>" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Yakin hapus?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="restockModal<?= $product['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form action="<?= BASEURL; ?>/admin/productRestock" method="post">
                                            <div class="modal-body p-4 text-center">
                                                <h6 class="fw-bold mb-3">Tambah Stok</h6>
                                                <p class="small text-muted mb-4"><?= $product['name']; ?></p>
                                                
                                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                <input type="number" name="quantity" class="form-control form-control-lg text-center rounded-pill mb-3" placeholder="0" min="1" required autofocus>
                                                
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-success rounded-pill fw-bold">Update Stok</button>
                                                    <button type="button" class="btn btn-link text-muted btn-sm text-decoration-none" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Fitur Search Instan
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {
            let name = row.querySelector('.product-name').innerText.toLowerCase();
            if (name.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Fitur Filter Stok Menipis
    function filterLowStock() {
        let rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            let stock = parseInt(row.querySelector('.stock-value').innerText);
            if (stock < 10) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Reset Filter
    function resetFilter() {
        let rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            row.style.display = '';
        });
        document.getElementById('searchInput').value = '';
    }
</script>