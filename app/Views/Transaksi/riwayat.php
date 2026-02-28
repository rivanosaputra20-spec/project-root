<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-white mb-1">Riwayat Transaksi</h3>
            <p class="text-muted small">Memantau semua jejak seduhan kopi pelanggan kamu.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-warning rounded-pill px-4">
            <i class="fas fa-download me-2"></i> Ekspor Laporan
        </button>
    </div>

    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: #25282c;">
        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
                <thead class="text-muted small">
                    <tr>
                        <th class="pb-3">NO</th>
                        <th class="pb-3">TANGGAL & WAKTU</th>
                        <th class="pb-3">PELANGGAN</th>
                        <th class="pb-3">METODE BAYAR</th>
                        <th class="pb-3 text-end">TOTAL HARGA</th>
                        <th class="pb-3 text-center">STATUS</th>
                        <th class="pb-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($transaksi)) : $no = 1; foreach($transaksi as $tr) : ?>
                    <tr class="border-top border-secondary">
                        <td class="py-3 text-muted"><?= $no++ ?></td>
                        <td>
                            <div class="text-white fw-bold"><?= date('d M Y', strtotime($tr['created_at'])) ?></div>
                            <div class="text-muted small"><?= date('H:i', strtotime($tr['created_at'])) ?> WIB</div>
                        </td>
                        <td class="fw-bold"><?= $tr['nama_pelanggan'] ?></td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-25 text-white fw-normal px-3 rounded-pill">
                                <i class="fas fa-credit-card me-1 small"></i> <?= $tr['metode_bayar'] ?>
                            </span>
                        </td>
                        <td class="text-warning fw-bold text-end">Rp <?= number_format($tr['total_harga'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                <i class="fas fa-check-circle me-1"></i> Selesai
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('transaksi/print/'.$tr['id']) ?>" class="btn btn-sm btn-warning rounded-circle" title="Cetak Struk">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else : ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="fas fa-coffee fa-3x"></i>
                            </div>
                            <p class="text-muted">Belum ada data transaksi yang tercatat.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Agar tabel terlihat lebih bersih di dark mode */
    .table-dark {
        --bs-table-bg: transparent;
    }
    tr:hover {
        background: rgba(255,255,255,0.02);
    }
</style>
<?= $this->endSection() ?>