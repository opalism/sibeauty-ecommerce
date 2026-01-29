<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        /* Button Custom Pink sesuai permintaan */
        .btn-primary-custom {
            background-color: #D885A3;
            border: none;
            color: white;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #c4728f;
            color: white;
            transform: translateY(-2px);
        }
        .card {
            margin-top: 50px;
        }
        .form-control:focus {
            border-color: #D885A3;
            box-shadow: 0 0 0 0.25 row rgba(216, 133, 163, 0.25);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold text-center mb-4" style="color: #D885A3;">Welcome Back!</h3>
                    
                    <div class="mb-3">
                        <?php Flasher::flash(); ?>
                    </div>

                    <form action="<?= BASEURL; ?>/auth/loginProcess" method="post">
                        <div class="mb-3">
                            <label class="form-label text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="nama@email.com" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted">Password</label>
                            <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="••••••••" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-pill mt-2 shadow">Login</button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">Belum punya akun? 
                            <a href="<?= BASEURL; ?>/auth/register" class="text-decoration-none fw-bold" style="color: #D885A3;">Daftar Disini</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>