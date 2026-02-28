<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-4 bg-dark min-vh-100 position-relative">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="text-white fw-bold m-0"><i class="fas fa-mug-hot text-warning me-2"></i>Queejuy Menu</h2>
            <p class="text-muted small">Halo, <span class="text-warning fw-bold"><?= session()->get('username') ?></span>! Siap melayani pelanggan hari ini?</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="input-group w-50 ms-auto shadow-sm">
                <input type="text" id="menuSearch" class="form-control bg-secondary border-0 text-white rounded-start-pill ps-4" placeholder="Cari kopi kesukaan...">
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

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 bg-success text-white shadow-sm rounded-4 mb-4 fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div>
                    <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4 mb-5" id="menuContainer">
        <?php foreach ($produk as $p) : ?>
        <div class="col-md-3 menu-item" data-category="<?= $p['kategori'] ?>">
            <div class="card h-100 border-0 bg-secondary text-white shadow coffee-card rounded-4 overflow-hidden">
                <div class="position-relative">
                    <img src="<?= base_url('uploads/menu/'.$p['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                         <span class="badge bg-warning text-dark rounded-pill shadow-sm">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    </div>
                </div>
                
                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h6>
                    <p class="text-light opacity-50 small flex-grow-1 mb-3"><?= $p['deskripsi'] ?? 'Seduhan penuh cinta.' ?></p>
                    
                    <form action="<?= base_url('transaksi/addToCart/'.$p['id']) ?>" method="get">
                        <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm hover-scale">
                            <i class="fas fa-plus-circle me-1"></i> Add to Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php $cartCount = count(session()->get('cart') ?? []); ?>
    <button type="button" class="btn btn-warning fab-cart shadow-lg rounded-circle p-0" data-bs-toggle="modal" data-bs-target="#cartModal">
        <i class="fas fa-shopping-basket fa-lg"></i>
        <?php if($cartCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger border border-light" style="padding: 6px 10px;">
                <?= $cartCount ?>
            </span>
        <?php endif; ?>
    </button>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-warning border-0 p-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-receipt me-2"></i>Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('transaksi/save') ?>" method="post">
                <div class="modal-body p-4 bg-white">
                    <?php $total = 0; $cart = session()->get('cart') ?? []; ?>
                    
                    <?php if (empty($cart)) : ?>
                        <div class="text-center py-5">
                            <div class="mb-3 opacity-25"><i class="fas fa-shopping-cart fa-5x"></i></div>
                            <h5 class="text-muted">Ops! Keranjang Kosong</h5>
                            <p class="small text-muted">Ayo tambahkan menu lezat ke sini.</p>
                        </div>
                    <?php else : ?>
                        <div class="cart-items mb-4 pe-2" style="max-height: 350px; overflow-y: auto;">
                            <?php foreach ($cart as $id => $item) : 
                                $subtotal = $item['harga'] * $item['qty'];
                                $total += $subtotal;
                            ?>
                                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-4 border-start border-warning border-4">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold text-dark"><?= $item['nama'] ?></h6>
                                        <span class="badge bg-white text-dark border small"><?= $item['qty'] ?> x Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                    </div>
                                    <span class="fw-bold text-dark fs-5">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="bg-light p-3 rounded-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark m-0">Total Akhir</h5>
                                <h5 class="fw-bold text-success m-0">Rp <?= number_format($total, 0, ',', '.') ?></h5>
                            </div>
                        </div>

                        <input type="hidden" name="total" value="<?= $total ?>">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control border-0 bg-light rounded-3" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100 py-3 rounded-pill fw-bold shadow">
                            CETAK STRUK & SELESAI <i class="fas fa-print ms-2"></i>
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="<?= base_url('transaksi/clearCart') ?>" class="text-danger text-decoration-none small fw-bold">
                                <i class="fas fa-trash-alt me-1"></i> Kosongkan Keranjang
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .coffee-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .coffee-card:hover { transform: translateY(-10px); }
    .hover-scale:hover { transform: scale(1.05); }
    
    .fab-cart {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 70px;
        height: 70px;
        z-index: 1000;
        transition: all 0.3s ease;
        border: 4px solid #1a1d20;
    }
    .fab-cart:hover { transform: scale(1.1) rotate(5deg); }
    
    .cart-items::-webkit-scrollbar { width: 5px; }
    .cart-items::-webkit-scrollbar-track { background: #f1f1f1; }
    .cart-items::-webkit-scrollbar-thumb { background: #f39c12; border-radius: 10px; }

    #menuSearch:focus {
        background-color: #343a40 !important;
        box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
    }
</style>

<script>
    const searchInput = document.getElementById('menuSearch');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const menuItems = document.querySelectorAll('.menu-item');

    function filterMenu() {
        const searchText = searchInput.value.toLowerCase();
        const activeCategory = document.querySelector('.filter-btn.active').getAttribute('data-filter');

        menuItems.forEach(item => {
            const title = item.querySelector('h6').innerText.toLowerCase();
            const category = item.getAttribute('data-category');

            const matchSearch = title.includes(searchText);
            const matchCategory = (activeCategory === 'all' || category === activeCategory);

            item.style.display = (matchSearch && matchCategory) ? "" : "none";
        });
    }

    searchInput.addEventListener('keyup', filterMenu);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'btn-warning');
                b.classList.add('btn-outline-secondary', 'text-white');
            });
            this.classList.add('active', 'btn-warning');
            this.classList.remove('btn-outline-secondary', 'text-white');
            filterMenu();
        });
    });
</script>

<?= $this->endSection() ?>