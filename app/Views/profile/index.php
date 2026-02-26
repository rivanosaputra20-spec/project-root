<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show border-0 mb-4 rounded-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 mb-4 rounded-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-lg rounded-4 text-white" style="background: #25282c;">
                <div class="card-header border-0 bg-transparent text-center py-5">
                    
                    <div class="mb-3 position-relative d-inline-block">
                        <?php 
                            $foto = ($user['user_image'] && $user['user_image'] != 'default.png') 
                                    ? base_url('uploads/profile/' . $user['user_image']) 
                                    : base_url('assets/img/default-avatar.png'); 
                        ?>
                        <img src="<?= $foto ?>" class="rounded-circle border border-4 border-warning shadow-lg" 
                             style="width: 130px; height: 130px; object-fit: cover;">
                        
                        <button class="btn btn-warning position-absolute bottom-0 end-0 rounded-circle shadow-sm border border-2 border-dark" 
                                style="width: 40px; height: 40px;"
                                data-bs-toggle="modal" data-bs-target="#modalGantiFoto">
                            <i class="fas fa-camera text-dark"></i>
                        </button>
                    </div>

                    <h3 class="fw-bold mt-2 mb-0"><?= esc($user['username']) ?></h3>
                    <span class="badge bg-warning text-dark px-3 rounded-pill mt-2 fw-bold text-uppercase">
                        <?= $user['role'] ?>
                    </span>
                </div>

                <div class="card-body p-4 border-top border-secondary text-start">
                    <div class="mb-3">
                        <label class="text-muted small fw-bold">ID PENGGUNA</label>
                        <p class="fs-6 border-bottom border-secondary pb-2 text-info">#USR-<?= $user['id'] ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small fw-bold">USERNAME</label>
                        <p class="fs-5 border-bottom border-secondary pb-2"><?= esc($user['username']) ?></p>
                    </div>
                    
                    <div class="mt-4 d-grid gap-2">
                        <button class="btn btn-outline-warning rounded-pill fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalGantiPassword">
                            <i class="fas fa-key me-2"></i> Ganti Kata Sandi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGantiFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form action="<?= base_url('profile/updateFoto') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Ganti Foto Profil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <input type="file" name="user_image" class="form-control bg-black border-secondary text-white" accept="image/*" required>
                    </div>
                    <p class="small text-muted">Gunakan file JPG, PNG, atau WebP (Maks. 2MB)</p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill text-dark">UNGGAH SEKARANG</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGantiPassword" tabindex="-1" aria-labelledby="modalGantiPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form action="<?= base_url('profile/updatePassword') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Ubah Kata Sandi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="mb-3 text-start">
                        <label class="small fw-bold mb-2 text-warning">PASSWORD BARU</label>
                        <input type="password" name="new_password" class="form-control bg-black border-secondary text-white py-2" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="small fw-bold mb-2 text-warning">KONFIRMASI PASSWORD BARU</label>
                        <input type="password" name="confirm_password" class="form-control bg-black border-secondary text-white py-2" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-start { text-align: left !important; }
    .form-control:focus { background-color: #000; color: #fff; border-color: #ffc107; box-shadow: none; }
    .alert { animation: fadeIn 0.5s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .btn-warning:hover { background-color: #e5ac00; }
</style>
<?= $this->endSection() ?>