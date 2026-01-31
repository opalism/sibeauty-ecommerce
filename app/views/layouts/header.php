<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> - SIBEAUTY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        
        /* Navbar Styling */
        .navbar-brand img { max-height: 40px; } 
        .nav-link { font-weight: 500; color: #555 !important; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #D885A3 !important; }
        
        .btn-custom { background-color: #D885A3; color: white; border: none; }
        .btn-custom:hover { background-color: #c06c8a; color: white; }
        
        /* Search Bar Custom */
        .search-input { border-color: #eee; background-color: #f8f9fa; }
        .search-input:focus { border-color: #D885A3; box-shadow: none; background-color: #fff; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand" href="<?= BASEURL; ?>">
            <img src="<?= BASEURL; ?>/assets/img/logo-3.png" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" 
                 alt="SIBEAUTY">
            <span style="display:none; font-weight:700; color:#D885A3;">SIBEAUTY</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASEURL; ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASEURL; ?>/product">Produk</a>
                </li>
                
                <li class="nav-item mx-lg-3 my-2 my-lg-0">
                    <form action="<?= BASEURL; ?>/product/search" method="POST" class="d-flex">
                        <div class="input-group">
                            <input class="form-control search-input rounded-start-pill border-end-0 px-3" 
                                   type="search" 
                                   placeholder="Cari skincare..." 
                                   name="keyword" 
                                   aria-label="Search" 
                                   style="width: 200px;">
                            <button class="btn btn-light border border-start-0 rounded-end-pill text-muted" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <?php if(isset($_SESSION['user_session']) && $_SESSION['user_session']['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link px-3 text-danger fw-bold" href="<?= BASEURL; ?>/admin">
                        <i class="bi bi-shield-lock"></i> Admin
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 justify-content-center justify-content-lg-end">
                
                <a href="<?= BASEURL; ?>/cart" class="btn btn-light position-relative rounded-circle border">
                    <i class="bi bi-cart3 fs-5"></i>
                    
                    <?php 
                        // LOGIKA BARU: HITUNG JUMLAH KERANJANG
                        if(isset($_SESSION['user_session'])) {
                            // Panggil model langsung dari View (trik praktis di MVC sederhana)
                            // Pastikan Cart_model sudah punya fungsi countCart
                            $cartCount = $this->model('Cart_model')->countCart($_SESSION['user_session']['id']);
                            
                            if($cartCount > 0) {
                                echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                            style="font-size: 0.6rem; border: 2px solid white;">' 
                                      . $cartCount . 
                                     '</span>';
                            }
                        }
                    ?>
                </a>

                <?php if(isset($_SESSION['user_session'])): ?>
                    <div class="dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle rounded-pill px-4" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i> <?= substr($_SESSION['user_session']['name'], 0, 8); ?>..
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="<?= BASEURL; ?>/profile"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item py-2" href="<?= BASEURL; ?>/order"><i class="bi bi-bag me-2"></i> Riwayat Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= BASEURL; ?>/auth/login" class="btn btn-custom rounded-pill px-4 fw-bold">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>