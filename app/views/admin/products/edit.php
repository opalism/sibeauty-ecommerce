<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href="<?= BASEURL; ?>/admin/products" class="text-decoration-none text-muted mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Edit Produk</h4>

                    <form action="<?= BASEURL; ?>/admin/productUpdate" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" value="<?= $data['product']['id']; ?>">
                        <input type="hidden" name="oldImage" value="<?= $data['product']['image']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Produk</label>
                            <input type="text" name="name" class="form-control rounded-pill" value="<?= $data['product']['name']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kategori</label>
                            <select name="category_id" class="form-select rounded-pill" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach($data['categories'] as $cat): ?>
                                    <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $data['product']['category_id']) ? 'selected' : ''; ?>>
                                        <?= $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control rounded-pill" value="<?= $data['product']['price']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Stok</label>
                                <input type="number" name="stock" class="form-control rounded-pill" value="<?= $data['product']['stock']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Deskripsi</label>
                            <textarea name="description" class="form-control rounded-4" rows="4" required><?= $data['product']['description']; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Gambar Produk</label>
                            <div class="d-flex align-items-center mb-2">
                                <img src="<?= BASEURL; ?>/assets/img/products/<?= $data['product']['image']; ?>" class="rounded border me-3" width="70" height="70" style="object-fit: cover;">
                                <div class="small text-muted">Gambar saat ini</div>
                            </div>
                            <input type="file" name="image" class="form-control rounded-pill">
                            <div class="form-text small">Kosongkan jika tidak ingin ganti gambar.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark rounded-pill py-2 fw-bold">Simpan Perubahan</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>