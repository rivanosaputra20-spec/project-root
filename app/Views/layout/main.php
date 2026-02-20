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
        }
        .nav-link { 
            color: var(--text-muted); padding: 15px 20px; border-radius: 15px; 
            margin-bottom: 10px; transition: 0.3s; display: flex; align-items: center;
        }
        .nav-link i { margin-right: 15px; font-size: 1.1rem; }
        .nav-link:hover, .nav-link.active { 
            background: rgba(230, 138, 0, 0.1); color: var(--accent); 
        }
        
        /* Main Content Styling */
        .main-content { margin-left: 280px; padding: 40px; }
        
        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200');
            background-size: cover; background-position: center;
            border-radius: 30px; height: 350px; display: flex; align-items: center; padding: 60px; margin-bottom: 40px;
        }

        /* --- TAMBAHAN ANIMASI KARTU PESANAN --- */
        .coffee-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            overflow: hidden; /* Biar gambar yang membesar ga keluar kotak */
        }

        .coffee-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
            border-color: var(--accent) !important;
        }

        /* Efek Zoom pada Gambar */
        .coffee-card img {
            transition: transform 0.6s ease;
        }

        .coffee-card:hover img {
            transform: scale(1.1);
        }

        /* Animasi Tombol Order */
        .btn-order-anim {
            transition: all 0.3s ease;
        }

        .coffee-card:hover .btn-order-anim {
            background-color: var(--accent);
            box-shadow: 0 0 15px rgba(230, 138, 0, 0.5);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 px-3">
        <h4 class="fw-bold text-white"><i class="fas fa-mug-hot text-warning me-2"></i> Kopi Kita</h4>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link <?= (url_is('/') ? 'active' : '') ?>" href="<?= base_url('/') ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a class="nav-link <?= (url_is('produk*') ? 'active' : '') ?>" href="<?= base_url('produk') ?>">
            <i class="fas fa-coffee"></i> Menu Kopi
        </a>
        <a class="nav-link <?= (url_is('pelanggan*') ? 'active' : '') ?>" href="<?= base_url('pelanggan') ?>">
            <i class="fas fa-users"></i> Pelanggan
        </a>
        <a class="nav-link <?= (url_is('transaksi*') ? 'active' : '') ?>" href="<?= base_url('transaksi') ?>">
            <i class="fas fa-receipt"></i> Transaksi
        </a>
        <div class="mt-5">
            <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
                <i class="fas fa-power-off"></i> Keluar
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>