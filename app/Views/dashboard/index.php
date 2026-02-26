<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="hero-banner">
    <div>
        <span class="text-warning fw-bold text-uppercase small">Est. 2023 • Artisan Roastery</span>
        <h1 class="display-4 fw-bold mt-2">Crafting Your<br>Daily Ritual</h1>
        <p class="text-light opacity-75 mt-3" style="max-width: 450px;">Nikmat banget harmoni sempurna dari biji kopi pilihan yang dipanggang dengan penuh cinta.</p>
        <div class="mt-4">
            <button class="btn btn-warning px-4 py-2 fw-bold rounded-pill me-2">Pesan Sekarang</button>
            <button class="btn btn-outline-light px-4 py-2 rounded-pill">Tentang Kami</button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Today's Special</h3>
    <a href="<?= base_url('produk') ?>" class="text-warning text-decoration-none fw-bold small">Lihat Menu Lengkap <i class="fas fa-arrow-right ms-1"></i></a>
</div>

<div class="row g-4">
    <?php 
    $menus = !empty($produk_populer) ? $produk_populer : [
        ['nama' => 'Maple Pecan Latte', 'harga' => 24500, 'img' => 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?q=80&w=400'],
        ['nama' => 'Laminated Croissant', 'harga' => 18000, 'img' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=400'],
        ['nama' => 'Midnight Cold Brew', 'harga' => 22000, 'img' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=400'],
        ['nama' => 'Classic Cortado', 'harga' => 19000, 'img' => 'https://images.unsplash.com/photo-1534706936160-d5ee67737249?q=80&w=400']
    ];
    
    foreach($menus as $m) : ?>
    <div class="col-md-3">
        <div class="card coffee-card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="background: #25282c;">
            <div class="overflow-hidden" style="height: 200px;">
                <img src="<?= $m['image'] ?>" class="card-img-top" style="height: 100%; object-fit: cover; transition: 0.5s;">
            </div>
            
            <div class="card-body p-4">
                <h5 class="fw-bold mb-1 text-white"><?= $m['nama_produk'] ?></h5>
                <p class="text-muted small mb-3">Seasonal favorite with authentic maple syrup.</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-warning fw-bold">Rp <?= number_format($m['harga'], 0, ',', '.') ?></span>
                    <a href="<?= base_url('transaksi/create') ?>" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold btn-order-anim">+ Order Now</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>