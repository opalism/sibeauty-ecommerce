<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Kelola Kategori</h3>
        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php Flasher::flash(); ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Induk (Parent)</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($data['categories'] as $cat): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <?php if($cat['parent_id']): ?>
                                            <span class="ms-3 text-primary">↳ <?= $cat['name']; ?></span>
                                        <?php else: ?>
                                            <span class="fw-bold"><?= $cat['name']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($cat['parent_name']): ?>
                                            <span class="badge bg-secondary"><?= $cat['parent_name']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Kategori Utama</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-warning me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal<?= $cat['id']; ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="<?= BASEURL; ?>/admin/categoryDelete/<?= $cat['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Yakin hapus kategori ini?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal<?= $cat['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= BASEURL; ?>/admin/categoryUpdate" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $cat['id']; ?>">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Kategori</label>
                                                        <input type="text" name="name" class="form-control" value="<?= $cat['name']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Induk Kategori</label>
                                                        <select name="parent_id" class="form-select">
                                                            <option value="">-- Jadikan Kategori Utama --</option>
                                                            <?php foreach($data['categories'] as $parent): ?>
                                                                <?php if($parent['id'] != $cat['id']): // Cegah milih diri sendiri ?>
                                                                    <option value="<?= $parent['id']; ?>" <?= $cat['parent_id'] == $parent['id'] ? 'selected' : ''; ?>>
                                                                        <?= $parent['name']; ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASEURL; ?>/admin/categoryStore" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Serum, Toner" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Induk Kategori</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Jadikan Kategori Utama --</option>
                            <?php foreach($data['categories'] as $cat): ?>
                                <?php if($cat['parent_id'] == null): ?>
                                    <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted">Pilih "Jadikan Kategori Utama" jika ini adalah kategori induk (misal: Skincare).</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>