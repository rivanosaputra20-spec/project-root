<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Queejuy Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f1011 0%, #1a1c1e 100%);
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: white;
        }
        .login-card {
            background: #25282c; 
            padding: 40px; 
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.7); 
            width: 100%; 
            max-width: 400px;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .btn-login {
            background-color: #e68a00; 
            color: white; 
            border-radius: 10px;
            padding: 14px; 
            transition: 0.3s; 
            border: none;
            letter-spacing: 1px;
        }
        .btn-login:hover { 
            background-color: #ff9800; 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(230, 138, 0, 0.4);
        }
        
        /* PERBAIKAN TULISAN INPUT */
        .form-control { 
            background: #121416 !important; /* Latar input lebih gelap agar teks putih menonjol */
            border: 1px solid #444; 
            color: #ffffff !important; /* Tulisan yang diketik wajib PUTIH */
            border-radius: 10px; 
            padding: 12px; 
        }
        .form-control:focus { 
            background: #121416; 
            color: white !important; 
            border-color: #e68a00; 
            box-shadow: 0 0 0 0.25 margin-bottom: rgba(230, 138, 0, 0.25); 
        }
        .form-control::placeholder {
            color: #666 !important; /* Tulisan contoh dibuat agak abu-abu agar beda dengan ketikan */
        }
        
        /* PERBAIKAN WARNA LABEL & ICON */
        .form-label-custom {
            color: #ffffff !important; /* Label atas (Username/Password) jadi PUTIH terang */
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .input-group-text {
            background: #121416 !important;
            border: 1px solid #444;
            border-right: none;
            color: #e68a00 !important; /* Icon jadi warna oranye agar jelas */
        }
        .input-group .form-control {
            border-left: none;
        }
        .text-light-custom {
            color: #ccc !important; /* Tulisan keterangan di bawah judul */
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <i class="fas fa-mug-hot fa-3x text-warning mb-3"></i>
        <h2 class="fw-bold text-white">Queejuy <span class="text-warning">Coffee</span></h2>
        <p class="text-light-custom small">Silakan masuk untuk mengelola kedai</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 small py-2 bg-danger text-white mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login/proses') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="mb-3">
            <label class="form-label small form-label-custom">USERNAME</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="admin / kasir" required autocomplete="off">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small form-label-custom">PASSWORD</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100 fw-bold shadow">
            MASUK SEKARANG <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </form>
    
    <div class="text-center mt-4">
        <p class="text-muted small mb-0">&copy; 2024 Queejuy Coffee Team</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>