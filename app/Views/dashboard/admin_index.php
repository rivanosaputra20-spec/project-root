<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4" style="background: #1a1d20; min-height: 100vh;">
    
    <div class="mb-4">
        <h2 class="fw-bold text-white mb-1">Dashboard Overview</h2>
        <p class="text-muted small">Real-time performance metrics for Queejuy Coffee.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 shadow-sm" style="background: #25282c;">
                <p class="text-secondary small fw-bold mb-1">TOTAL REVENUE</p>
                <h3 class="fw-bold text-warning mb-0">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 shadow-sm" style="background: #25282c;">
                <p class="text-secondary small fw-bold mb-1">TOTAL ORDERS</p>
                <h3 class="fw-bold text-info mb-0"><?= number_format($totalOrders) ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 shadow-sm" style="background: #25282c;">
                <p class="text-secondary small fw-bold mb-1">TOTAL PRODUCTS</p>
                <h3 class="fw-bold text-success mb-0"><?= $totalProducts ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c; min-height: 400px;">
                <h5 class="fw-bold text-white mb-4 border-bottom border-secondary pb-2">Sales Trends</h5>
                <div style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c; min-height: 400px;">
                <h5 class="fw-bold text-white mb-4 border-bottom border-secondary pb-2">Top Selling Products</h5>
                <div class="product-list">
                    <?php if(!empty($topProducts)): ?>
                        <?php foreach($topProducts as $p): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-white small fw-bold"><?= $p['nama_produk'] ?></h6>
                                <small class="text-muted">Stok: <?= $p['stok'] ?></small>
                            </div>
                            <div class="text-end">
                                <span class="text-warning fw-bold small d-block">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted small">Belum ada data produk.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales (Rp)',
                data: [150000, 280000, 260000, 220000, 190000, 310000, 250000],
                backgroundColor: '#ffc107',
                borderRadius: 5
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#ffffff' } } // Warna legend putih
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#ffffff' } // Warna angka Y putih
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#ffffff' } // Warna label X putih
                }
            }
        }
    });
</script>

<style>
    /* Mengatur agar teks tabel/list tetap putih */
    .text-secondary { color: #a0a0a0 !important; }
    .product-list { max-height: 300px; overflow-y: auto; }
</style>
<?= $this->endSection() ?>