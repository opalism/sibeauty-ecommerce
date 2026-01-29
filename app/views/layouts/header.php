<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> - SIBEAUTY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-sibeauty sticky-top py-3">
  <div class="container">
    <a class="navbar-brand" href="<?= BASEURL; ?>">
        <img src="<?= BASEURL; ?>/assets/img/logo.png" alt="SIBEAUTY Logo" height="100%">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link active" href="<?= BASEURL; ?>">Home</a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                Produk
            </a>
            <ul class="dropdown-menu shadow border-0">
                
                <li><a class="dropdown-item" href="<?= BASEURL; ?>/product">Semua Produk</a></li>
                
                <li><hr class="dropdown-divider"></li>
                
                <?php 
                    require_once '../app/models/Category_model.php';
                    $catModel = new Category_model();
                    $categories = $catModel->getAllCategories();
                    
                    foreach($categories as $cat): 
                ?>
                    <li>
                        <a class="dropdown-item" href="<?= BASEURL; ?>/product/category/<?= $cat['id']; ?>">
                            <?= $cat['name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
      </ul>
      
      <div class="d-flex gap-3 align-items-center">
        
        <div class="d-flex align-items-center">
            <div class="collapse collapse-horizontal me-2" id="collapseSearch">
                <form action="<?= BASEURL; ?>/product/search" method="post" style="width: 200px;">
                     <div class="input-group input-group-sm">
                        <input type="text" class="form-control rounded-pill border-secondary" 
                               name="keyword" placeholder="Cari produk..." required>
                    </div>
                </form>
            </div>
            <a href="#" class="text-dark fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                <i class="bi bi-search"></i>
            </a>
        </div>
        
        <a href="<?= BASEURL; ?>/cart" class="position-relative text-dark fs-5">
            <i class="bi bi-bag"></i>
            <?php 
                $cartCount = 0;
                if(isset($_SESSION['user_session'])) {
                    require_once '../app/models/Cart_model.php';
                    $cartModel = new Cart_model();
                    $cartCount = $cartModel->countCart($_SESSION['user_session']['id']);
                }
            ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                <?= $cartCount; ?>
            </span>
        </a>

        <?php if(isset($_SESSION['user_session'])): ?>
            <div class="dropdown">
                <a class="btn btn-sm btn-outline-dark rounded-pill px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i> 
                    <?= explode(' ', $_SESSION['user_session']['name'])[0]; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <?php if($_SESSION['user_session']['role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="<?= BASEURL; ?>/admin"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="<?= BASEURL; ?>/profile"><i class="bi bi-person me-2"></i> Akun Saya</a></li>
                    <li><a class="dropdown-item" href="<?= BASEURL; ?>/order"><i class="bi bi-box-seam me-2"></i> Pesanan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?= BASEURL; ?>/auth" class="btn btn-sm btn-outline-dark rounded-pill px-4">Login</a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</nav>