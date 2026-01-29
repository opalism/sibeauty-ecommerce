<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Tambah Produk Baru</h5>
                </div>
                <div class="card-body p-4">
                    
                    <div class="mb-3">
                        <?php Flasher::flash(); ?>
                    </div>

                    <form action="<?= BASEURL; ?>/admin/productStore" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control rounded-3" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select rounded-3">
                                    <?php foreach($data['categories'] as $cat): ?>
                                        <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target Gender</label>
                                <select name="gender" class="form-select rounded-3">
                                    <option value="women">Wanita (Women)</option>
                                    <option value="men">Pria (Men)</option>
                                    <option value="unisex">Unisex</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control rounded-3" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stock" class="form-control rounded-3" value="10" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea name="description" class="form-control rounded-3" rows="4"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto Produk</label>
                            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASEURL; ?>/admin/products" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-primary-custom rounded-pill px-5">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>