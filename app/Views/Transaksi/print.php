<!DOCTYPE html>
<html>
<head>
    <title>Cetak Struk - Queejuy Coffee</title>
    <style>
        body { font-family: monospace; width: 300px; margin: 0 auto; padding: 20px; }
        .text-center { text-align: center; }
        hr { border-top: 1px dashed #000; }
        table { width: 100%; }
        .total { font-weight: bold; font-size: 1.2em; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2>Queejuy Coffee</h2>
        <p>Jl. Kopi Kita No. 123</p>
        <hr>
    </div>

    <p>ID Transaksi: #<?= $transaksi['id'] ?></p>
    <p>Tanggal: <?= date('d/m/Y H:i', strtotime($transaksi['created_at'])) ?></p>
    <hr>

    <table>
        <tr>
    <td>Total Bayar</td>
    <td align="right">
       <p>Total Bayar: <b>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></b></p>
    </td>
</tr>
    </table>

    <hr>
    <div class="text-center">
        <p>Terima Kasih Atas Kunjungannya!</p>
    </div>
    
    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.location.href='<?= base_url('transaksi') ?>'">Kembali</button>
    </div>
</body>
</html>