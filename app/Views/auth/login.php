<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kopi Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #3e2723 0%, #5d4037 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-icon {
            color: #3e2723;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #3e2723;
            color: white;
            border-radius: 10px;
            padding: 10px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #1b100e;
            color: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-icon">
        <i class="fas fa-coffee fa-4x mb-3"></i>
        <h3 class="fw-bold">Kopi Kita</h3>
        <p class="text-muted small">Silakan masuk untuk mengelola kedai</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger small py-2"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="/login/proses" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label small fw-bold">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                <input type="text" name="username" class="form-control border-start-0 bg-light" placeholder="Masukkan username" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control border-start-0 bg-light" placeholder="********" required>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100 fw-bold">MASUK SEKARANG</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>