<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Menu Gallery</h2>
        <p class="text-muted">Kelola varian rasa dan harga produk Anda.</p>
    </div>
    <button type="button" class="btn btn-warning fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
    + Tambah Menu
</button>
</div>

<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4 me-2" data-bs-toggle="pill" data-bs-target="#all">Semua</button>
    </li>
    <?php foreach($kategori as $kat): ?>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4 me-2 text-white border-secondary" data-bs-toggle="pill" data-bs-target="#<?= strtolower(str_replace(' ', '', $kat)) ?>">
            <?= $kat ?>
        </button>
    </li>
    <?php endforeach; ?>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="all">
        <div class="row g-4">
            <?php foreach($produk as $p): ?>
            <div class="col-md-3">
                <div class="card coffee-card border-0 rounded-4 overflow-hidden h-100" style="background: #25282c;">
                    <div class="position-relative overflow-hidden" style="height: 180px;">
                        <img src="<?= $p['image'] ?>" class="card-img-top" style="height: 100%; object-fit: cover;">
                        <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 rounded-pill"><?= $p['kategori'] ?></span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1 text-white"><?= $p['nama_produk'] ?></h5>
                        <p class="text-muted small mb-3"><?= substr($p['deskripsi'], 0, 50) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-warning fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-light border-0"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach($kategori as $kat): ?>
    <div class="tab-pane fade" id="<?= strtolower(str_replace(' ', '', $kat)) ?>">
        <div class="row g-4">
            <?php foreach($produk as $p): ?>
                <?php if($p['kategori'] == $kat): ?>
                <div class="col-md-3">
                    <div class="card coffee-card border-0 rounded-4 overflow-hidden h-100" style="background: #25282c;">
                        <div class="overflow-hidden" style="height: 180px;">
                            <img src="<?= $p['image'] ?>" class="card-img-top" style="height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-1 text-white"><?= $p['nama_produk'] ?></h5>
                            <span class="text-warning fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .nav-pills .nav-link { background: #25282c; transition: 0.3s; }
    .nav-pills .nav-link.active { background: var(--accent) !important; color: #000 !important; }
</style>
<?= $this->endSection() ?>