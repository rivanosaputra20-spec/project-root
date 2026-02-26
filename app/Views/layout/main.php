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
        body { background-color: var(--dark-bg); color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif; }
        
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
        .nav-link:hover, .nav-link.active { 
            background: rgba(230, 138, 0, 0.1); color: var(--accent); 
        }
        
        /* Main Content Styling */
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }

        /* Badge Role */
        .role-badge {
            font-size: 0.7rem;
            padding: 3px 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Coffee Card Animations */
        .coffee-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            overflow: hidden;
        }
        .coffee-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
            border-color: var(--accent) !important;
        }
        .coffee-card img { transition: transform 0.6s ease; }
        .coffee-card:hover img { transform: scale(1.1); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-4 px-3">
        <h4 class="fw-bold text-white mb-1"><i class="fas fa-mug-hot text-warning me-2"></i> Queejuy</h4>
        <span class="role-badge"><?= session()->get('role') ?> Mode</span>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link <?= (url_is('/') ? 'active' : '') ?>" href="<?= base_url('/') ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <?php if (session()->get('role') == 'admin') : ?>
            <a class="nav-link <?= (url_is('produk*') ? 'active' : '') ?>" href="<?= base_url('produk') ?>">
                <i class="fas fa-coffee"></i> Menu Kopi
            </a>
            <a class="nav-link <?= (url_is('pelanggan*') ? 'active' : '') ?>" href="<?= base_url('pelanggan') ?>">
                <i class="fas fa-users"></i> Pelanggan
            </a>
            <a class="nav-link <?= (url_is('transaksi*') ? 'active' : '') ?>" href="<?= base_url('transaksi') ?>">
                <i class="fas fa-chart-bar"></i> Laporan Penjualan
            </a>
        <?php endif; ?>

        <?php if (session()->get('role') == 'user') : ?>
            <a class="nav-link <?= (url_is('transaksi*') ? 'active' : '') ?>" href="<?= base_url('transaksi') ?>">
                <i class="fas fa-receipt"></i> Kasir / Order
            </a>
        <?php endif; ?>

        <hr class="text-secondary my-4">

        <a class="nav-link <?= (url_is('profile*') ? 'active' : '') ?>" href="<?= base_url('profile') ?>">
            <i class="fas fa-user-circle"></i> Profile Saya
        </a>

        <div class="mt-auto">
            <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
                <i class="fas fa-power-off"></i> Keluar
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 rounded-3 mb-4" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>