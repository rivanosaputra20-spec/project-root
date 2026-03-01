<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-secondary shadow">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="fas fa-edit me-2"></i> EDIT MENU
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('produk/update/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <img src="<?= base_url('uploads/menu/' . $produk['image']) ?>" class="rounded mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ffc107;">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">NAMA PRODUK</label>
                            <input type="text" name="nama_produk" class="form-control bg-black text-white border-secondary" value="<?= $produk['nama_produk'] ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">KATEGORI</label>
                                <select name="kategori" class="form-select bg-black text-white border-secondary">
                                    <?php foreach($kategori as $kat): ?>
                                        <option value="<?= $kat ?>" <?= ($produk['kategori'] == $kat) ? 'selected' : '' ?>><?= $kat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">HARGA</label>
                                <input type="number" name="harga" class="form-control bg-black text-white border-secondary" value="<?= $produk['harga'] ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">STOK</label>
                            <input type="number" name="stok" class="form-control bg-black text-white border-secondary" value="<?= $produk['stok'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">DESKRIPSI</label>
                            <textarea name="deskripsi" class="form-control bg-black text-white border-secondary" rows="3"><?= $produk['deskripsi'] ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold">GANTI FOTO (Opsional)</label>
                            <input type="file" name="image" class="form-control bg-black text-white border-secondary">
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('produk') ?>" class="btn btn-outline-light w-50 rounded-pill">BATAL</a>
                            <button type="submit" class="btn btn-warning w-50 rounded-pill fw-bold text-dark">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>