<div class="mb-4 px-3 text-center">
    <h4 class="fw-bold text-white mb-1"><i class="fas fa-mug-hot text-warning me-2"></i> Queejuy</h4>
    <span class="role-badge"><?= session()->get('role') ?> Mode</span>
</div>

<nav class="nav flex-column mt-4">
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

    <hr class="text-secondary my-4">

    <a href="<?= base_url('profile') ?>" class="nav-link <?= (url_is('profile*') ? 'active' : '') ?>">
        <i class="fas fa-user-circle"></i> Profile Saya
    </a>

    <a class="nav-link text-danger mt-5" href="<?= base_url('logout') ?>">
        <i class="fas fa-power-off"></i> Keluar
    </a>
</nav>