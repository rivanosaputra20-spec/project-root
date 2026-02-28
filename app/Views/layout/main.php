<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-bg: #1a1c1e;
            --card-bg: #25282c;
            --accent: #e68a00;
            --text-muted: #a0a0a0;
        }
        body { background-color: var(--dark-bg); color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar { 
            width: 280px; height: 100vh; position: fixed; 
            background: #151719; padding: 40px 20px; border-right: 1px solid #333;
            z-index: 1000;
        }
        .nav-link { 
            color: var(--text-muted); padding: 15px 20px; border-radius: 15px; 
            margin-bottom: 10px; transition: 0.3s; display: flex; align-items: center;
            text-decoration: none;
        }
        .nav-link i { margin-right: 15px; font-size: 1.1rem; width: 25px; text-align: center; }
        
        /* Penambahan Logika Active Link */
        .nav-link:hover, .nav-link.active { 
            background: rgba(230, 138, 0, 0.1) !important; color: var(--accent) !important; 
        }
        
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }

        .role-badge {
            font-size: 0.7rem; padding: 3px 10px;
            background: rgba(255, 255, 255, 0.1); border-radius: 50px;
            color: var(--accent); text-transform: uppercase; letter-spacing: 1px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 px-3 text-center">
        <h3 class="fw-bold text-white mb-0">Queejuy <span class="text-warning">Coffee</span></h3>
        <span class="role-badge"><?= session()->get('role') ?? 'Kasir' ?> Mode</span>
    </div>

    <div class="nav-list">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= url_is('dashboard*') ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <a href="<?= base_url('transaksi') ?>" class="nav-link <?= url_is('transaksi*') ? 'active' : '' ?>">
            <i class="fas fa-coffee"></i> Menu Gallery
        </a>

        <a href="<?= base_url('riwayat') ?>" class="nav-link <?= url_is('riwayat*') ? 'active' : '' ?>">
            <i class="fas fa-history"></i> Riwayat Transaksi
        </a>

        <div class="mt-5 pt-5">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger mt-5">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </div>
</div>

<div class="main-content">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>