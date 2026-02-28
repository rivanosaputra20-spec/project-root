<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4" style="background: #1a1d20; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white mb-0">Menu Gallery</h2>
            <p class="text-muted small">
                <?= ($role == 'admin') ? 'Mode Administrator: Kelola stok, harga, dan menu.' : 'Nikmati pilihan menu terbaik kami.' ?>
            </p>
        </div>
        
        <?php if($role == 'admin'): ?>
            <button class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
                <i class="fas fa-plus me-2"></i> Tambah Menu
            </button>
        <?php endif; ?>
    </div>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#all">Semua</button>
        </li>
        <?php foreach($kategori as $kat): ?>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 text-white bg-dark border border-secondary" 
                        data-bs-toggle="pill" 
                        data-bs-target="#<?= strtolower(str_replace([' ', '-'], '', $kat)) ?>">
                    <?= $kat ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all">
            <div class="row g-4 text-start">
                <?php foreach ($produk as $p) : ?>
                    <div class="col-md-3">
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 overflow-hidden h-100">
                            <div class="position-relative">
                                <?php 
                                    $imgSrc = (isset($p['image']) && strpos($p['image'], 'http') !== false) 
                                              ? $p['image'] 
                                              : base_url('uploads/menu/' . ($p['image'] ?? 'default.png'));
                                ?>
                                <img src="<?= $imgSrc ?>" class="card-img-top" style="height: 200px; object-fit: cover;" onerror="this.src='<?= base_url('uploads/menu/default.png') ?>'">
                                
                                <?php if (isset($p['stok']) && $p['stok'] <= 0) : ?>
                                    <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.6);">
                                        <span class="badge bg-danger px-3 py-2">SOLD OUT</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h5>
                                <p class="<?= (isset($p['stok']) && $p['stok'] > 0) ? 'text-success' : 'text-danger' ?> small mb-2">
                                    <?= (isset($p['stok']) && $p['stok'] > 0) ? 'Tersedia: '.$p['stok'] : 'Stok Habis' ?>
                                </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <h6 class="text-warning fw-bold mb-0">Rp <?= number_format($p['harga'], 0, ',', '.') ?></h6>
                                    
                                    <?php if($role == 'admin'): ?>
                                    <div>
                                        <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#modalEditMenu<?= $p['id'] ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#modalDeleteMenu<?= $p['id'] ?>"><i class="fas fa-trash"></i></button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach($kategori as $kat): ?>
        <div class="tab-pane fade" id="<?= strtolower(str_replace([' ', '-'], '', $kat)) ?>">
            <div class="row g-4 text-start">
                <?php 
                $found = false;
                foreach($produk as $p): 
                    if($p['kategori'] == $kat): 
                        $found = true;
                ?>
                    <div class="col-md-3">
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 overflow-hidden h-100">
                             <img src="<?= base_url('uploads/menu/'.$p['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                             <div class="card-body">
                                <h5 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h5>
                                <h6 class="text-warning fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></h6>
                             </div>
                        </div>
                    </div>
                <?php 
                    endif;
                endforeach; 
                if(!$found): echo '<div class="col-12 text-center text-muted py-5">Belum ada menu di kategori ini.</div>'; endif;
                ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if($role == 'admin'): ?>
    
    <div class="modal fade" id="modalTambahMenu" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary text-white shadow-lg">
                <form action="<?= base_url('produk/save') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title fw-bold text-warning">Tambah Menu Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">NAMA PRODUK</label>
                            <input type="text" name="nama_produk" class="form-control bg-black border-secondary text-white" required placeholder="Contoh: Matcha Latte">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold mb-2">KATEGORI</label>
                                <select name="kategori" class="form-select bg-black border-secondary text-white">
                                    <?php foreach($kategori as $kat): ?>
                                        <option value="<?= $kat ?>"><?= $kat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold mb-2">HARGA (RP)</label>
                                <input type="number" name="harga" class="form-control bg-black border-secondary text-white" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">STOK AWAL</label>
                            <input type="number" name="stok" class="form-control bg-black border-secondary text-white" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">FOTO PRODUK</label>
                            <input type="file" name="image" class="form-control bg-black border-secondary text-white">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill">SIMPAN MENU</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach($produk as $p): ?>
        <div class="modal fade" id="modalEditMenu<?= $p['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark border-secondary text-white shadow-lg">
                    <form action="<?= base_url('produk/update/'.$p['id']) ?>" method="post">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title fw-bold">Update Harga & Stok</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4 text-start">
                            <p class="small text-muted mb-3">Produk: <strong class="text-white"><?= $p['nama_produk'] ?></strong></p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small fw-bold mb-2 text-warning">HARGA BARU (RP)</label>
                                    <input type="number" name="harga" value="<?= $p['harga'] ?>" class="form-control bg-black border-secondary text-white" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small fw-bold mb-2 text-warning">STOK TERSEDIA</label>
                                    <input type="number" name="stok" value="<?= $p['stok'] ?>" class="form-control bg-black border-secondary text-white" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDeleteMenu<?= $p['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark border-danger text-white">
                    <div class="modal-header border-danger">
                        <h5 class="modal-title fw-bold text-danger">Hapus Produk?</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus <strong><?= $p['nama_produk'] ?></strong> secara permanen?</p>
                    </div>
                    <div class="modal-footer border-danger">
                        <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <a href="<?= base_url('produk/delete/'.$p['id']) ?>" class="btn btn-danger rounded-pill px-4 fw-bold">Ya, Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<style>
    .nav-pills .nav-link.active { background-color: #ffc107 !important; color: #000 !important; font-weight: bold; }
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-10px); }
    .text-start { text-align: left !important; }
</style>
<?= $this->endSection() ?>