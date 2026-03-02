<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-4 bg-dark min-vh-100 position-relative">
    <?php 
        $userRole = strtolower(session()->get('role') ?? ''); 
    ?>

    <div class="row mb-4 align-items-center">
        <div class="col-md-6 text-start">
            <h2 class="text-white fw-bold m-0"><i class="fas fa-mug-hot text-warning me-2"></i>Queejuy Coffee</h2>
            <p class="text-muted small">Halo, <span class="text-warning fw-bold"><?= session()->get('username') ?></span>! (<?= ucfirst($userRole) ?>)</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="input-group w-50 ms-auto shadow-sm">
                <input type="text" id="menuSearch" class="form-control bg-secondary border-0 text-white rounded-start-pill ps-4" placeholder="Cari menu...">
                <button class="btn btn-warning rounded-end-pill px-4"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex gap-2 flex-wrap">
            <button class="btn btn-warning rounded-pill px-4 filter-btn active" data-filter="all">Semua</button>
            <button class="btn btn-outline-secondary text-white border-secondary rounded-pill px-4 filter-btn" data-filter="Coffee">Coffee</button>
            <button class="btn btn-outline-secondary text-white border-secondary rounded-pill px-4 filter-btn" data-filter="Non-Coffee">Non-Coffee</button>
            <button class="btn btn-outline-secondary text-white border-secondary rounded-pill px-4 filter-btn" data-filter="Snack">Snack</button>
        </div>
    </div>

    <div class="row g-4 mb-5" id="menuContainer">
        <?php foreach ($produk as $p) : ?>
        <div class="col-md-3 menu-item" data-category="<?= $p['kategori'] ?>">
            <div class="card h-100 border-0 bg-secondary text-white shadow coffee-card rounded-4 overflow-hidden">
                <div class="position-relative">
                    <img src="<?= base_url('uploads/menu/'.$p['image']) ?>" class="card-img-top <?= ($p['stok'] <= 0) ? 'opacity-25 grayscale' : '' ?>" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                         <span class="badge bg-warning text-dark rounded-pill shadow-sm">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    </div>
                    <?php if($p['stok'] <= 0) : ?>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <span class="badge bg-danger px-3 py-2 shadow">HABIS</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-3 d-flex flex-column text-start">
                    <h6 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h6>
                    <p class="text-light opacity-50 small mb-1">Stok: <?= $p['stok'] ?></p>
                    <p class="text-light opacity-50 small flex-grow-1 mb-3"><?= $p['deskripsi'] ?: 'Seduhan penuh cinta.' ?></p>
                    
                    <div class="mt-auto">
                        <?php if($userRole === 'admin'): ?>
                            <a href="<?= base_url('produk/edit/'.$p['id']) ?>" class="btn btn-outline-warning w-100 rounded-pill fw-bold">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        <?php else: ?>
                            <button type="button" onclick="addToCart(<?= $p['id'] ?>)" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm" <?= ($p['stok'] <= 0) ? 'disabled' : '' ?>>
                                <i class="fas fa-plus-circle me-1"></i> Add to Order
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($userRole !== 'admin'): ?>
    <button type="button" id="btnCartFloating" class="btn btn-warning fab-cart shadow-lg rounded-circle p-0" onclick="openCartModal()">
        <i class="fas fa-shopping-basket fa-lg"></i>
        <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger border border-light d-none" style="padding: 6px 10px;">0</span>
    </button>
    <?php endif; ?>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-warning border-0 p-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-receipt me-2"></i>Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formTransaksi" action="<?= base_url('transaksi/save') ?>" method="post">
                <div class="modal-body p-4 bg-white text-start">
                    <div id="cartItemsContainer" class="mb-4" style="max-height: 250px; overflow-y: auto;"></div>

                    <div id="cartContentArea">
                        <div class="bg-light p-3 rounded-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-bold">Total Akhir</span>
                                <h4 class="fw-bold text-success m-0" id="displayTotal">Rp 0</h4>
                            </div>
                        </div>
                        <input type="hidden" name="total_akhir" id="inputTotal">

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">NAMA PELANGGAN</label>
                            <input type="text" name="nama_pelanggan" class="form-control border-0 bg-light rounded-3 shadow-sm" placeholder="Nama pelanggan..." required>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2 d-block text-center">METODE PEMBAYARAN</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran" id="method_cash" value="cash" checked onclick="toggleQRIS(false)">
                                    <label class="btn btn-outline-dark w-100 py-3 fw-bold rounded-3" for="method_cash">
                                        <i class="fas fa-money-bill-wave d-block mb-1"></i> CASH
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran" id="method_qris" value="qris" onclick="toggleQRIS(true)">
                                    <label class="btn btn-outline-primary w-100 py-3 fw-bold rounded-3" for="method_qris">
                                        <i class="fas fa-qrcode d-block mb-1"></i> QRIS
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="qrisSection" class="mb-3 p-3 border rounded-4 d-none bg-light" style="border: 2px dashed #ffc107 !important;">
                            <p class="small text-muted mb-2 text-center">Scan QRIS Queejuy Coffee</p>
                            
                            <div class="d-flex justify-content-center align-items-center" style="min-height: 170px;">
                                <img src="<?= base_url('assets/image/qris.png') ?>" 
                                     class="img-fluid rounded-3 shadow-sm" 
                                     style="max-width: 160px; background: white; padding: 10px; display: block;"
                                     onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none');">
                                
                                <div class="alert alert-danger small d-none m-0">
                                    Gagal memuat qris.png<br>Cek folder: public/assets/image/
                                </div>
                            </div>
                            
                            <p class="small fw-bold text-primary m-0 mt-2 text-center">QUEEJUY COFFEE HUB</p>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-3 rounded-pill fw-bold shadow">
                            CETAK STRUK & SELESAI <i class="fas fa-print ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .coffee-card { transition: all 0.3s ease; }
    .coffee-card:hover { transform: translateY(-8px); }
    .fab-cart { position: fixed; bottom: 30px; right: 30px; width: 65px; height: 65px; z-index: 1050; border: 4px solid #1a1d20; transition: transform 0.2s ease; }
    .btn-check:checked + .btn-outline-dark { background-color: #212529 !important; color: white !important; border-color: #212529 !important; }
    .btn-check:checked + .btn-outline-primary { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
    .grayscale { filter: grayscale(1); }
    .cart-bump { transform: scale(1.2); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('menuSearch');
        const menuItems = document.querySelectorAll('.menu-item');
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            menuItems.forEach(item => {
                const name = item.querySelector('h6').textContent.toLowerCase();
                item.style.display = name.includes(query) ? "" : "none";
            });
        });

        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active', 'btn-warning'));
                this.classList.add('active', 'btn-warning');
                const filter = this.dataset.filter;
                menuItems.forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.category === filter) ? "" : "none";
                });
            });
        });

        updateModalData();
    });

    function toggleQRIS(show) {
        const qris = document.getElementById('qrisSection');
        if(show) {
            qris.classList.remove('d-none');
        } else {
            qris.classList.add('d-none');
        }
    }

    function addToCart(id) {
        if ("<?= $userRole ?>" === "admin") return;

        fetch(`<?= base_url('transaksi/addToCart') ?>/${id}`)
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                updateModalData();
                const btnCart = document.getElementById('btnCartFloating');
                btnCart.classList.add('cart-bump');
                setTimeout(() => btnCart.classList.remove('cart-bump'), 400);
            }
        });
    }

    function openCartModal() {
        updateModalData();
        const modal = new bootstrap.Modal(document.getElementById('cartModal'));
        modal.show();
    }

    function updateModalData() {
        if ("<?= $userRole ?>" === "admin") return;

        fetch('<?= base_url('transaksi/getCart') ?>')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('cartItemsContainer');
            const badge = document.getElementById('cartBadge');
            
            container.innerHTML = '';
            if (!data.cart || data.cart.length === 0) {
                container.innerHTML = '<div class="text-center text-muted p-4">Keranjang Kosong</div>';
                badge.classList.add('d-none');
            } else {
                badge.classList.remove('d-none');
                badge.innerText = data.cart.length;
                
                data.cart.forEach(item => {
                    container.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3 text-dark border-start border-warning border-4 shadow-sm">
                            <div>
                                <span class="fw-bold d-block">${item.nama}</span>
                                <small>${item.qty} x Rp ${Number(item.harga).toLocaleString('id-ID')}</small>
                            </div>
                            <span class="fw-bold">Rp ${(item.qty * item.harga).toLocaleString('id-ID')}</span>
                        </div>`;
                });
                document.getElementById('displayTotal').innerText = 'Rp ' + data.total_formatted;
                document.getElementById('inputTotal').value = data.total;
            }
        });
    }
</script>
<?= $this->endSection() ?>