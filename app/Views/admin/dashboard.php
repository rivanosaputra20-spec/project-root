<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Dashboard Overview</h2>
    
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: var(--card-bg);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Revenue</p>
                        <h3 class="fw-bold mb-0">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-wallet text-success fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: var(--card-bg);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Orders</p>
                        <h3 class="fw-bold mb-0"><?= $totalOrders ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-shopping-bag text-warning fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: var(--card-bg);">
        <h5 class="fw-bold mb-4">Recent Orders</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover border-0">
                <thead>
                    <tr>
                        <th class="border-0 text-muted small">ORDER ID</th>
                        <th class="border-0 text-muted small">DATE</th>
                        <th class="border-0 text-muted small">AMOUNT</th>
                        <th class="border-0 text-muted small">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recentSales as $sale): ?>
                    <tr>
                        <td class="align-middle">#TRX-<?= $sale['id'] ?></td>
                        <td class="align-middle text-muted"><?= date('d M Y', strtotime($sale['created_at'])) ?></td>
                        <td class="align-middle fw-bold">Rp <?= number_format($sale['total_harga']) ?></td>
                        <td class="align-middle"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Success</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>