<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="fw-bold mb-4">Pengaturan Akun</h3>
            
            <div class="mb-3">
                <?php Flasher::flash(); ?>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <form action="<?= BASEURL; ?>/profile/update" method="post">
                        <input type="hidden" name="id" value="<?= $data['user']['id']; ?>">
                        
                        <h6 class="fw-bold text-muted text-uppercase mb-3">Informasi Pribadi</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3" value="<?= $data['user']['name']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email (Tidak dapat diubah)</label>
                                <input type="email" class="form-control rounded-3 bg-light" value="<?= $data['user']['email']; ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="<?= $data['user']['phone']; ?>" placeholder="Contoh: 08123456789">
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-muted text-uppercase mb-3">Alamat Pengiriman Default</h6>
                        <div class="mb-4">
                            <label class="form-label text-muted small">Alamat Lengkap</label>
                            <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Masukkan alamat lengkap untuk memudahkan checkout..."><?= $data['user']['address']; ?></textarea>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-muted text-uppercase mb-3">Keamanan</h6>
                        <div class="mb-4">
                            <label class="form-label text-muted small">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control rounded-3" placeholder="Kosongkan jika tidak ingin mengganti password">
                            <div class="form-text">Minimal 6 karakter.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary-custom px-5 rounded-pill shadow">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>