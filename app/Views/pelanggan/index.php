<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-white">Data Pelanggan</h2>
        <p class="text-muted">Manajemen database pelanggan dari tabel <strong>customers</strong></p>
    </div>
    <button class="btn btn-warning fw-bold px-4 rounded-pill">
        <i class="fas fa-user-plus me-2"></i> Tambah Pelanggan
    </button>
</div>

<div class="card border-0 rounded-4 shadow-sm" style="background: #25282c;">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle border-0">
                <thead>
                    <tr class="text-muted border-secondary">
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">No. HP</th>
                        <th class="py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pelanggan)): ?>
                        <?php foreach($pelanggan as $p): ?>
                        <tr class="border-secondary">
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        <?= substr($p['nama'], 0, 1) ?>
                                    </div>
                                    <span class="fw-bold"><?= $p['nama'] ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= $p['email'] ?></td>
                            <td class="text-muted"><?= $p['no_hp'] ?></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-light border-0"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash d-block mb-3 fa-3x"></i>
                                Belum ada data pelanggan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>