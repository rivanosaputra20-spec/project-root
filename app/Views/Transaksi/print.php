<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            color: #000;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        hr { border-top: 1px dashed #000; border-bottom: none; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        .item-name { font-size: 14px; }
        .item-detail { font-size: 12px; color: #333; }
        @media print {
            .no-print { display: none; }
            body { width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h3 style="margin-bottom: 5px;">Queejuy Coffee</h3>
        <p style="font-size: 12px; margin: 0;">Jl. Kopi Kita No. 123, Jakarta</p>
        <p style="font-size: 12px; margin: 0;">Telp: 0812-3456-7890</p>
    </div>

    <hr>

    <div style="font-size: 13px;">
        <div style="display: flex; justify-content: space-between;">
            <span>ID: #<?= $transaksi['id'] ?></span>
            <span><?= date('d/m/Y H:i', strtotime($transaksi['created_at'])) ?></span>
        </div>
        <p style="margin: 5px 0;">Kasir: <?= session()->get('username') ?? 'Admin' ?></p>
        <p style="margin: 5px 0;">Pelanggan: <?= $transaksi['nama_pelanggan'] ?></p>
    </div>

    <hr>

    <table>
        <?php if (!empty($items)) : ?>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td style="padding: 5px 0;">
                        <span class="item-name"><?= $item['nama_produk'] ?></span><br>
                        <span class="item-detail"><?= $item['jumlah'] ?> x Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></span>
                    </td>
                    <td style="text-align: right; vertical-align: bottom; font-size: 14px;">
                        Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="2" class="text-center">Tidak ada detail item</td>
            </tr>
        <?php endif; ?>
    </table>

    <hr>

    <table>
        <tr>
            <td class="fw-bold">TOTAL AKHIR</td>
            <td style="text-align: right;" class="fw-bold">Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;">Metode Bayar</td>
            <td style="text-align: right; font-size: 13px;"><?= ucfirst($transaksi['metode_bayar']) ?></td>
        </tr>
    </table>

    <hr>

    <div class="text-center" style="font-size: 12px;">
        <p class="fw-bold">Terima Kasih Atas Kunjungan Anda!</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar kembali.</p>
    </div>

    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #ffc107; border: none; cursor: pointer; border-radius: 5px;">Cetak Ulang</button>
        <a href="<?= base_url('transaksi') ?>" style="display: inline-block; padding: 10px 20px; background: #eee; text-decoration: none; color: #000; border-radius: 5px; margin-left: 10px;">Kembali</a>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.location.href = '<?= base_url('transaksi') ?>';
        };
    </script>
</body>
</html>