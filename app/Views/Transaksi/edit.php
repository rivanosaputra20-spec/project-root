<h2>Edit Transaksi</h2>

<form action="<?= base_url('transaksi/update/'.$transaksi['id']) ?>" method="post">
    <?= csrf_field(); ?>

    <div style="margin-bottom:10px;">
        <label>Pilih Pelanggan</label><br>
        <select name="pelanggan_id" required>
            <?php foreach ($pelanggan as $p): ?>
                <option value="<?= $p['id']; ?>"
                    <?= $p['id'] == $transaksi['pelanggan_id'] ? 'selected' : '' ?>>
                    <?= $p['nama']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="margin-bottom:10px;">
        <label>Tanggal</label><br>
        <input type="date" name="tanggal"
            value="<?= $transaksi['tanggal']; ?>" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Total</label><br>
        <input type="number" name="total"
            value="<?= $transaksi['total']; ?>" required>
    </div>

    <button type="submit">Update</button>
    <a href="<?= base_url('transaksi') ?>">Kembali</a>
</form>