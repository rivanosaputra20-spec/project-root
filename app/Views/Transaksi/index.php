<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Riwayat Transaksi</h3>
    <a href="/transaksi/create" class="btn btn-warning fw-bold px-4 rounded-pill">+ Order Baru</a>
</div>

<div class="stat-card p-0 overflow-hidden">
    <table class="table table-hover table-dark mb-0 align-middle">
        <thead class="bg-dark text-warning">
            <tr>
                <th class="px-4 py-3">ID Nota</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transaksi as $t) : ?>
            <tr>
                <td class="px-4 fw-bold text-muted">#<?= $t['id'] ?></td>
                <td><?= date('d M Y, H:i', strtotime($t['created_at'])) ?></td>
                <td><?= $t['nama_pelanggan'] ?? 'Guest' ?></td>
                <td class="fw-bold text-warning">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                <td><span class="badge bg-success bg-opacity-10 text-success px-3">Selesai</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-light"><i class="fas fa-print"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>