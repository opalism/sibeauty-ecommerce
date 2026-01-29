<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .navbar-admin { background-color: #2c3e50; } /* Warna Gelap biar beda sama User */
        .nav-link { color: rgba(255,255,255,0.8) !important; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-admin navbar-dark sticky-top py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASEURL; ?>/admin">
        ADMIN <span class="text-warning">PANEL</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item px-2">
            <a class="nav-link" href="<?= BASEURL; ?>/admin"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
        </li>
        <li class="nav-item px-2">
            <a class="nav-link" href="<?= BASEURL; ?>/admin/products"><i class="bi bi-box-seam me-1"></i> Produk</a>
        </li>
        <li class="nav-item px-2">
            <a class="nav-link" href="<?= BASEURL; ?>/admin/categories"><i class="bi bi-tags me-1"></i> Kategori</a>
        </li>
        <li class="nav-item px-2">
            <a class="nav-link" href="<?= BASEURL; ?>/admin/orders"><i class="bi bi-receipt me-1"></i> Pesanan</a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center">
        <div class="dropdown">
            <a class="btn btn-outline-light btn-sm dropdown-toggle rounded-pill px-3" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li><a class="dropdown-item" href="<?= BASEURL; ?>" target="_blank"><i class="bi bi-globe me-2"></i> Lihat Website</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="min-vh-100">