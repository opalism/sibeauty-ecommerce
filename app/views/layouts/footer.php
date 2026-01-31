<footer class="bg-white pt-5 pb-4 border-top mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="<?= BASEURL; ?>" class="d-flex align-items-center text-dark text-decoration-none mb-3">
                        <img src="<?= BASEURL; ?>/assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                        <span class="fs-4 fw-bold" style="letter-spacing: -1px;">Sibeauty.</span>
                    </a>
                    <p class="text-muted small">Platform e-commerce skincare nomor #1 di Indonesia dengan produk 100% original dan terpercaya.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Belanja</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?= BASEURL; ?>/product" class="text-decoration-none text-muted">Semua Produk</a></li>
                        <li class="mb-2"><a href="<?= BASEURL; ?>/product/category/1" class="text-decoration-none text-muted">Skincare</a></li>
                        <li class="mb-2"><a href="<?= BASEURL; ?>/product/category/2" class="text-decoration-none text-muted">Make Up</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Bantuan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="https://wa.me/6283195725280" target="_blank" class="text-decoration-none text-muted">Hubungi CS</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Cara Belanja</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Konfirmasi Pembayaran</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold mb-3">Berlangganan</h6>
                    <form action="#" class="d-flex gap-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Email kamu...">
                        <button class="btn btn-dark btn-sm px-3">Daftar</button>
                    </form>
                </div>
            </div>
            <hr class="my-4 text-muted">
            <div class="text-center small text-muted">
                &copy; 2026 Sibeauty Official. All rights reserved.
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6283195725280?text=Halo%20Admin%20Sibeauty,%20saya%20butuh%20bantuan%20nih..." 
       target="_blank"
       class="d-flex align-items-center justify-content-center text-decoration-none shadow-lg"
       style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background-color: #25D366; color: white; border-radius: 50%; z-index: 9999; transition: all 0.3s ease;">
        <i class="bi bi-whatsapp fs-2"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="<?= BASEURL; ?>/assets/js/script.js"></script>
    
    <style>
        a[href*="wa.me"]:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.5) !important;
        }
    </style>
</body>
</html>