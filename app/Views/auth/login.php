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
            background: linear-gradient(135deg, #1a1c1e 0%, #25282c 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif; color: white;
        }
        .login-card {
            background: #25282c; padding: 40px; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5); width: 100%; max-width: 400px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-login {
            background-color: #e68a00; color: white; border-radius: 10px;
            padding: 12px; transition: 0.3s; border: none;
        }
        .btn-login:hover { background-color: #ff9800; color: white; transform: translateY(-2px); }
        .form-control { background: #1a1c1e; border: 1px solid #333; color: white; border-radius: 10px; padding: 12px; }
        .form-control:focus { background: #1a1c1e; color: white; border-color: #e68a00; box-shadow: none; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <i class="fas fa-mug-hot fa-3x text-warning mb-3"></i>
        <h3 class="fw-bold">Queejuy Coffee</h3>
        <p class="text-muted small">Silakan masuk untuk mengelola kedai</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 small py-2 bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login/proses') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label small fw-bold text-muted">USERNAME</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-0 text-muted"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="admin / kasir" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold text-muted">PASSWORD</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-0 text-muted"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100 fw-bold shadow">MASUK SEKARANG</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>