<div class="container py-5">
    <h3 class="fw-bold mb-4">Manajemen Kategori</h3>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Baru</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASEURL; ?>/admin/categoryStore" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control rounded-pill" placeholder="Contoh: Skincare" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-pill">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="mb-3">
                <?php Flasher::flash(); ?>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" width="10%">No</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-end pe-4" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($data['categories'] as $cat): ?>
                                <tr>
                                    <td class="ps-4"><?= $no++; ?></td>
                                    <td class="fw-bold"><?= $cat['name']; ?></td>
                                    <td class="text-end pe-4">
                                        <a href="<?= BASEURL; ?>/admin/categoryDelete/<?= $cat['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-circle" 
                                           onclick="return confirm('Yakin hapus kategori ini?');">
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
        </div>
    </div>
</div>