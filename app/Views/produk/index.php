<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4" style="background: #1a1d20; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
        <div>
            <h2 class="fw-bold text-white mb-0">Menu Gallery</h2>
            <p class="text-light opacity-75 small">
                <?= ($role == 'admin') ? 'Mode Administrator: Kelola stok, harga, dan menu.' : 'Nikmati pilihan menu terbaik kami.' ?>
            </p>
        </div>
        
        <div class="d-flex gap-2">
            <?php if($role == 'admin'): ?>
                <button class="btn btn-warning fw-bold px-4 rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
                    <i class="fas fa-plus me-2"></i> Tambah Menu
                </button>
            <?php else: ?>
                <button class="btn btn-outline-warning rounded-pill px-4 fw-bold shadow-sm" onclick="showCartModal()">
                    <i class="fas fa-shopping-basket me-2"></i> Keranjang <span id="cartCount" class="badge bg-danger rounded-circle ms-1">0</span>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-4 border border-warning" data-bs-toggle="pill" data-bs-target="#all">Semua</button>
        </li>
        <?php foreach($kategori as $kat): ?>
            <?php $targetId = strtolower(str_replace([' ', '-'], '', $kat)); ?>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 text-white bg-dark border border-secondary" 
                        data-bs-toggle="pill" 
                        data-bs-target="#<?= $targetId ?>">
                    <?= $kat ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all">
            <div class="row g-4 text-start">
                <?php foreach($produk as $p) : ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-dark text-white border-0 shadow-sm mb-4 h-100 rounded-4 overflow-hidden card-hover">
                            <div class="position-relative">
                                <img src="<?= base_url('uploads/menu/' . $p['image']) ?>" class="card-img-top <?= ($p['stok'] <= 0) ? 'opacity-25 grayscale' : '' ?>" style="height: 180px; object-fit: cover;">
                                <?php if($p['stok'] <= 0) : ?>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <span class="badge bg-danger px-3 py-2 shadow">HABIS</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold mb-1 text-white"><?= $p['nama_produk'] ?></h6>
                                <small class="<?= ($p['stok'] <= 0) ? 'text-danger fw-bold' : 'text-light opacity-50' ?>">
                                    <?= ($p['stok'] <= 0) ? 'Stok Habis' : 'Stok: ' . $p['stok'] ?>
                                </small>
                                <p class="text-warning fw-bold mt-2 mb-3 fs-5">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                
                                <div class="mt-auto">
                                    <?php if($role == 'admin'): ?>
                                        <div class="d-flex justify-content-between gap-2">
                                            <a href="<?= base_url('produk/edit/'.$p['id']) ?>" class="btn btn-outline-warning btn-sm w-100 fw-bold">Update</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteMenu<?= $p['id'] ?>"><i class="fas fa-trash"></i></button>
                                        </div>
                                    <?php else: ?>
                                        <button class="btn btn-warning btn-sm w-100 rounded-pill fw-bold" onclick="addToCart(<?= $p['id'] ?>)" <?= ($p['stok'] <= 0) ? 'disabled' : '' ?>>
                                            <i class="fas fa-cart-plus me-1"></i> Tambah Ke Order
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($role == 'admin'): ?>
                    <div class="modal fade" id="modalDeleteMenu<?= $p['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border-danger shadow-lg">
                                <div class="modal-body p-4 text-center">
                                    <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="fw-bold">Hapus Menu?</h5>
                                    <p class="small text-light opacity-75">Tindakan ini tidak bisa dibatalkan untuk <b><?= $p['nama_produk'] ?></b>.</p>
                                    <div class="d-flex gap-2 mt-4">
                                        <button class="btn btn-outline-light btn-sm w-50" data-bs-dismiss="modal">Batal</button>
                                        <a href="<?= base_url('produk/delete/'.$p['id']) ?>" class="btn btn-danger btn-sm w-50">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach($kategori as $kat): ?>
            <?php $targetId = strtolower(str_replace([' ', '-'], '', $kat)); ?>
            <div class="tab-pane fade" id="<?= $targetId ?>">
                <div class="row g-4 text-start">
                    <?php 
                    $found = false;
                    foreach($produk as $p) : 
                        if($p['kategori'] == $kat): 
                            $found = true; ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="card bg-dark text-white border-0 shadow-sm mb-4 h-100 rounded-4 overflow-hidden card-hover">
                                    <div class="position-relative">
                                        <img src="<?= base_url('uploads/menu/' . $p['image']) ?>" class="card-img-top <?= ($p['stok'] <= 0) ? 'opacity-25' : '' ?>" style="height: 180px; object-fit: cover;">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h6>
                                        <p class="text-warning fw-bold mt-2 mb-3">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                        <div class="mt-auto">
                                            <?php if($role == 'admin'): ?>
                                                <a href="<?= base_url('produk/edit/'.$p['id']) ?>" class="btn btn-outline-warning btn-sm w-100 fw-bold">Update</a>
                                            <?php else: ?>
                                                <button class="btn btn-warning btn-sm w-100 rounded-pill fw-bold" onclick="addToCart(<?= $p['id'] ?>)" <?= ($p['stok'] <= 0) ? 'disabled' : '' ?>>Tambah Ke Order</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    endforeach; 
                    
                    if(!$found): ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-mug-hot fa-3x text-secondary mb-3"></i>
                            <p class="text-light opacity-50">Belum ada menu untuk kategori <?= $kat ?>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="modalDetailPesanan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-white shadow-lg">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title fw-bold"><i class="fas fa-shopping-cart me-2"></i>Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('transaksi/save') ?>" method="post">
                <div class="modal-body p-4 text-start">
                    <div id="cartItemsList" class="mb-4">
                        </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 border-top pt-3">
                        <span class="h5 fw-bold text-dark mb-0">Total Tagihan</span>
                        <span class="h4 fw-bold text-success mb-0" id="totalAkhir">Rp 0</span>
                        <input type="hidden" name="total_akhir" id="inputTotalAkhir">
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-dark">NAMA PELANGGAN</label>
                        <input type="text" name="nama_pelanggan" class="form-control bg-light" placeholder="Masukkan nama..." required>
                    </div>

                    <div class="mb-4 text-dark">
                        <label class="small fw-bold mb-3 d-block text-center border-bottom pb-2">METODE PEMBAYARAN</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="pay_cash" value="cash" checked>
                                <label class="btn btn-outline-dark w-100 py-3 fw-bold shadow-sm" for="pay_cash"><i class="fas fa-money-bill-wave mb-1 d-block"></i> TUNAI</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="pay_qris" value="qris">
                                <label class="btn btn-outline-primary w-100 py-3 fw-bold shadow-sm" for="pay_qris"><i class="fas fa-qrcode mb-1 d-block"></i> QRIS</label>
                            </div>
                        </div>
                    </div>

                    <div id="qrisArea" class="text-center mb-3 p-3 bg-light rounded-3" style="display: none;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=QUEEJUY_COFFEE" alt="QRIS" class="border p-2 bg-white rounded shadow-sm">
                        <p class="mt-2 text-primary fw-bold small">SCAN QRIS UNTUK MEMBAYAR</p>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-3 rounded-pill shadow">
                        <i class="fas fa-print me-2"></i> CETAK STRUK & SELESAI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if($role == 'admin'): ?>
<div class="modal fade" id="modalTambahMenu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white text-start shadow-lg">
            <form action="<?= base_url('produk/save') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-warning">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">NAMA PRODUK</label>
                        <input type="text" name="nama_produk" class="form-control bg-black border-secondary text-white" placeholder="Contoh: Es Kopi Susu" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold mb-2">KATEGORI</label>
                            <select name="kategori" class="form-select bg-black border-secondary text-white">
                                <?php foreach($kategori as $kat): ?>
                                    <option value="<?= $kat ?>"><?= $kat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold mb-2">HARGA</label>
                            <input type="number" name="harga" class="form-control bg-black border-secondary text-white" placeholder="15000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">STOK AWAL</label>
                        <input type="number" name="stok" class="form-control bg-black border-secondary text-white" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">FOTO PRODUK</label>
                        <input type="file" name="image" class="form-control bg-black border-secondary text-white" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill">SIMPAN MENU</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
    .nav-pills .nav-link.active { background-color: #e68a00 !important; color: #fff !important; font-weight: bold; border-color: #e68a00 !important; }
    .nav-pills .nav-link:not(.active) { opacity: 0.8; color: white; }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.5) !important; }
    .grayscale { filter: grayscale(1); }
    #modalDetailPesanan .text-dark, #modalDetailPesanan label { color: #212529 !important; }
    #modalDetailPesanan .form-control { color: #212529 !important; border: 1px solid #ced4da !important; }
</style>

<script>
    // Tampilan QRIS
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach((elem) => {
        elem.addEventListener("change", (e) => {
            document.getElementById("qrisArea").style.display = (e.target.value === "qris") ? "block" : "none";
        });
    });

    // AJAX: Add to Cart
    function addToCart(id) {
        fetch('<?= base_url('transaksi/addToCart') ?>/' + id)
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    refreshCart();
                    // Alert sederhana
                    const toast = document.createElement('div');
                    toast.className = 'position-fixed bottom-0 end-0 p-3';
                    toast.style.zIndex = '1060';
                    toast.innerHTML = `<div class="alert alert-success shadow">Menu berhasil ditambahkan!</div>`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2000);
                } else {
                    alert(data.message || "Gagal menambahkan!");
                }
            });
    }

    // AJAX: Refresh Tampilan Keranjang
    function refreshCart() {
        fetch('<?= base_url('transaksi/getCart') ?>')
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.cart && data.cart.length > 0) {
                    data.cart.forEach(item => {
                        html += `
                        <div class="d-flex justify-content-between align-items-center mb-3 bg-light p-3 rounded-3">
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">${item.nama}</h6>
                                <small class="text-secondary">${item.qty} x Rp ${Number(item.harga).toLocaleString('id-ID')}</small>
                            </div>
                            <span class="fw-bold text-dark">Rp ${(item.qty * item.harga).toLocaleString('id-ID')}</span>
                        </div>`;
                    });
                } else {
                    html = '<div class="text-center py-4"><i class="fas fa-shopping-basket fa-2x text-muted mb-2 d-block"></i><p class="text-muted small">Keranjang masih kosong</p></div>';
                }
                document.getElementById('cartItemsList').innerHTML = html;
                document.getElementById('totalAkhir').innerText = 'Rp ' + (data.total_formatted || '0');
                document.getElementById('inputTotalAkhir').value = data.total || 0;
                
                // Update Badge Angka Keranjang
                const cartCountElem = document.getElementById('cartCount');
                if(cartCountElem) {
                    cartCountElem.innerText = data.cart ? data.cart.length : 0;
                }
            });
    }

    function showCartModal() {
        refreshCart();
        new bootstrap.Modal(document.getElementById('modalDetailPesanan')).show();
    }

    // Jalankan saat halaman dibuka
    window.onload = refreshCart;
</script>

<?= $this->endSection() ?>