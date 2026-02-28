<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    .hero-banner {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200');
        background-size: cover;
        background-position: center;
        border-radius: 30px;
        padding: 80px 50px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    .stat-card {
        transition: transform 0.3s ease;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .coffee-card {
        transition: all 0.3s ease;
    }
    .coffee-card:hover {
        transform: translateY(-10px);
    }
    .coffee-card:hover img {
        transform: scale(1.1);
    }
    .btn-order-anim:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(230, 138, 0, 0.4);
    }
</style>

<?php
    $jam = date('H');
    $sapaan = ($jam < 12) ? 'Selamat Pagi' : (($jam < 18) ? 'Selamat Siang' : 'Selamat Malam');
    $username = session()->get('username') ?? 'User';
    $role = session()->get('role'); 
?>

<div class="container-fluid p-0">
    <div class="mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h4 class="text-white fw-bold mb-1"><?= $sapaan ?>, <?= $username ?>!</h4>
            <p class="text-muted small mb-0">
                <?= ($role == 'admin') ? 'Panel kendali utama Queejuy Coffee.' : 'Mari buat hari ini luar biasa dengan seduhan terbaik.'; ?>
            </p>
        </div>
        <span class="badge bg-warning text-dark px-3 rounded-pill fw-bold"><?= strtoupper($role) ?> MODE</span>
    </div>

    <div class="hero-banner shadow-lg border border-secondary border-opacity-25">
        <div style="position: relative; z-index: 2;">
            <span class="text-warning fw-bold text-uppercase small" style="letter-spacing: 2px;">Est. 2023 • Artisan Roastery</span>
            
            <?php if ($role == 'admin') : ?>
                <h1 class="display-4 fw-bold mt-2 text-white">Administrator<br>Control Center</h1>
                <p class="text-white-50 mt-3 mb-4 w-50">Pantau performa bisnis, kelola inventaris produk, dan tinjau laporan transaksi dalam satu layar.</p>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('produk') ?>" class="btn btn-warning px-5 py-3 fw-bold rounded-pill shadow">Kelola Produk</a>
                    <a href="<?= base_url('riwayat') ?>" class="btn btn-outline-light px-5 py-3 rounded-pill border-2">Laporan Penjualan</a>
                </div>
            <?php else : ?>
                <h1 class="display-4 fw-bold mt-2 text-white">Crafting Your<br>Daily Ritual</h1>
                <p class="text-white-50 mt-3 mb-4 w-50">Siap melayani pelanggan? Mulai pesanan baru atau lihat daftar menu unggulan hari ini.</p>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-warning px-5 py-3 fw-bold rounded-pill shadow">Pesan Sekarang</a>
                    <button class="btn btn-outline-light px-5 py-3 rounded-pill border-2">Cek Stok Menu</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($role == 'admin') : ?>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card border-0 rounded-4 p-4 shadow-sm" style="background: linear-gradient(135deg, #e68a00, #ffb347);">
                <div class="d-flex align-items-center text-white">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <p class="opacity-75 mb-0 small fw-bold text-uppercase">Omzet Hari Ini</p>
                        <h3 class="fw-bold mb-0">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c;">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3 text-warning">
                        <i class="fas fa-shopping-bag fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Total Transaksi</p>
                        <h3 class="text-white fw-bold mb-0"><?= $total_pesanan ?? 0 ?> Pesanan</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c;">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3 text-info">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Data Pelanggan</p>
                        <h3 class="text-white fw-bold mb-0"><?= $total_pelanggan ?? 0 ?> Orang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <?php if ($role == 'admin') : ?>
            <h4 class="fw-bold text-white"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Status Inventaris</h4>
            <a href="<?= base_url('produk') ?>" class="text-warning text-decoration-none fw-bold small text-uppercase">Semua Produk <i class="fas fa-arrow-right ms-1"></i></a>
        <?php else : ?>
            <h4 class="fw-bold text-white"><i class="fas fa-coffee text-warning me-2"></i>Menu Populer</h4>
            <a href="<?= base_url('transaksi') ?>" class="text-warning text-decoration-none fw-bold small text-uppercase">Menu Lengkap <i class="fas fa-arrow-right ms-1"></i></a>
        <?php endif; ?>
    </div>

    <div class="row g-4 mb-5">
        <?php if (!empty($produk_populer)) : ?>
            <?php foreach($produk_populer as $m) : ?>
                <div class="col-md-3">
                    <div class="card coffee-card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="background: #25282c;">
                        <div class="overflow-hidden" style="height: 180px;">
                            <img src="<?= base_url('uploads/menu/'.$m['image']) ?>" class="card-img-top" style="height: 100%; width:100%; object-fit: cover; transition: 0.5s;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h6 class="fw-bold mb-1 text-white"><?= $m['nama_produk'] ?></h6>
                            
                            <?php if ($role == 'admin') : ?>
                                <div class="mt-2 mb-3">
                                    <small class="text-muted d-block mb-1 text-uppercase fw-bold" style="font-size: 10px;">Persediaan</small>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                                <a href="<?= base_url('produk/edit/'.$m['id']) ?>" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">Update Stok</a>
                            <?php else : ?>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-warning fw-bold">Rp <?= number_format($m['harga'], 0, ',', '.') ?></span>
                                    <a href="<?= base_url('transaksi/addToCart/'.$m['id']) ?>" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold btn-order-anim">+ Order</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center py-5 rounded-4" style="border: 2px dashed #333;">
                <p class="text-muted mb-0">Belum ada data produk unggulan yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c;">
                <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                    <h5 class="fw-bold mb-0"><i class="fas fa-history text-warning me-2"></i>Aktivitas Penjualan</h5>
                    <a href="<?= base_url('riwayat') ?>" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-borderless align-middle mb-0">
                        <thead class="text-muted small border-bottom border-secondary">
                            <tr>
                                <th class="pb-3 text-uppercase" style="letter-spacing: 1px;">Waktu</th>
                                <th class="pb-3 text-uppercase" style="letter-spacing: 1px;">Pelanggan</th>
                                <th class="pb-3 text-uppercase text-end" style="letter-spacing: 1px;">Total Bayar</th>
                                <th class="pb-3 text-center text-uppercase" style="letter-spacing: 1px;">Status</th>
                                <th class="pb-3 text-center text-uppercase" style="letter-spacing: 1px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($transaksi_terakhir)) : foreach($transaksi_terakhir as $tr) : ?>
                            <tr class="border-bottom border-secondary border-opacity-10">
                                <td class="py-3 small text-muted font-monospace"><?= date('H:i', strtotime($tr['created_at'] ?? 'now')) ?> WIB</td>
                                <td class="fw-bold text-white"><?= $tr['nama_pelanggan'] ?></td>
                                <td class="text-warning fw-bold text-end font-monospace">Rp <?= number_format($tr['total_harga'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 small">
                                        <i class="fas fa-check me-1 small"></i> Berhasil
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('transaksi/print/'.$tr['id']) ?>" class="btn btn-sm btn-link text-muted" title="Cetak Struk">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; else : ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted small">Belum ada aktivitas transaksi terekam hari ini.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>