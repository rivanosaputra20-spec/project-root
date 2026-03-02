<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-white">Pilih Menu</h3>
            <div class="input-group w-50">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control bg-dark border-secondary text-white" placeholder="Cari kopi kesukaanmu...">
            </div>
        </div>

        <div class="row g-3">
            <?php foreach($produk as $p) : ?>
            <div class="col-md-4">
                <div class="card coffee-card border-0 rounded-4 overflow-hidden shadow-sm" style="background: #25282c;">
                    <img src="<?= $p['image'] ?? 'https://images.unsplash.com/photo-1511920170033-f8396924c348?q=80&w=300' ?>" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-3 text-center">
                        <h6 class="fw-bold mb-1 text-white"><?= $p['nama_produk'] ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-warning fw-bold small">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                            <button class="btn btn-sm btn-warning rounded-pill px-3 fw-bold" onclick="tambahItem('<?= $p['nama_produk'] ?>', <?= $p['harga'] ?>)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 p-4 shadow-lg h-100" style="background: #25282c; border: 1px solid #333 !important;">
            <h5 class="fw-bold mb-4 text-white"><i class="fas fa-shopping-cart text-warning me-2"></i> Pesanan Baru</h5>
            
            <div class="mb-4">
                <label class="small text-muted mb-2">Nama Pelanggan</label>
                <select id="customer_id" class="form-select bg-dark text-white border-secondary rounded-pill shadow-sm">
                    <option value="">Pelanggan Umum (Walk-in)</option>
                    <?php if(!empty($customers)): ?>
                        <?php foreach($customers as $c) : ?>
                            <option value="<?= $c['id'] ?>"><?= $c['nama'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div id="order-list" class="mb-4" style="min-height: 200px; max-height: 400px; overflow-y: auto;">
                <p class="text-muted text-center py-5">Belum ada item dipilih.</p>
            </div>

            <hr class="border-secondary">
            
            <div class="d-flex justify-content-between mb-2 text-white">
                <span class="text-muted">Subtotal</span>
                <span class="fw-bold" id="subtotal">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-4 text-white">
                <span class="text-muted">Pajak (10%)</span>
                <span class="fw-bold" id="pajak">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-4 text-white">
                <h4 class="fw-bold">Total</h4>
                <h4 class="fw-bold text-warning" id="total-akhir">Rp 0</h4>
            </div>

            <label class="small text-muted mb-3">Metode Pembayaran</label>
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <button id="btn-qris" class="btn btn-outline-warning w-100 py-3 active btn-pay" onclick="setMetode('QRIS', this)"><i class="fas fa-qrcode d-block mb-2"></i> QRIS</button>
                </div>
                <div class="col-6">
                    <button id="btn-tunai" class="btn btn-outline-warning w-100 py-3 btn-pay" onclick="setMetode('Tunai', this)"><i class="fas fa-money-bill-wave d-block mb-2"></i> Tunai</button>
                </div>
            </div>

            <button class="btn btn-warning w-100 fw-bold py-3 rounded-pill shadow" onclick="tampilkanKonfirmasi()">
                PLACE ORDER <i class="fas fa-paper-plane ms-2"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-warning">Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h6 class="mb-3">Total Tagihan: <span id="modal-total" class="text-warning fw-bold"></span></h6>
                
                <div id="qris-container" style="display: none;">
                    <p class="small text-muted">Silahkan scan kode QRIS di bawah ini:</p>
                    <div class="bg-white p-3 d-inline-block rounded-3 mb-3">
                        <img src="<?= base_url('assets/images/qris.png') ?>" alt="QRIS Code" style="width: 200px; height: 200px;">
                    </div>
                    <h6 class="fw-bold">QUEEJUY COFFEE HUB</h6>
                </div>

                <div id="tunai-info" style="display: none;">
                    <i class="fas fa-money-bill-wave fa-4x text-success mb-3"></i>
                    <p>Silahkan terima pembayaran tunai dari pelanggan.</p>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning fw-bold rounded-pill px-4" onclick="prosesBayar()">CETAK STRUK & SELESAI <i class="fas fa-print ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<div id="nota-print" class="d-none">
    <div style="width: 80mm; font-family: 'Courier New', Courier, monospace; padding: 10px; color: black !important; background: white !important;">
        <div style="text-align: center;">
            <h3 style="margin: 0;">QUEEJUY COFFEE</h3>
            <p style="font-size: 12px;">Bekasi, Indonesia<br>--------------------------------</p>
        </div>
        <div id="nota-info" style="font-size: 12px;"></div>
        <p>--------------------------------</p>
        <div id="nota-items" style="font-size: 12px;"></div>
        <p>--------------------------------</p>
        <div id="nota-total" style="font-size: 14px; font-weight: bold;"></div>
        <div id="nota-metode" style="font-size: 12px; margin-top: 5px;"></div>
        <p style="text-align: center; font-size: 10px; margin-top: 20px;">Terima kasih atas kunjungannya!</p>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #nota-print, #nota-print * { visibility: visible !important; }
    #nota-print { 
        position: fixed; left: 0; top: 0; width: 80mm; 
        background-color: white !important; color: black !important; display: block !important;
    }
    @page { size: auto; margin: 0mm; }
}
.btn-pay.active { background-color: #ffc107 !important; color: #000 !important; }
</style>

<script>
let keranjang = [];
let metodeBayar = 'QRIS'; // Default

function tambahItem(nama, harga) {
    keranjang.push({nama, harga});
    updateTampilan();
}

function updateTampilan() {
    const list = document.getElementById('order-list');
    let html = '';
    let subtotal = 0;

    keranjang.forEach((item, index) => {
        subtotal += item.harga;
        html += `
            <div class="d-flex justify-content-between align-items-center mb-3 text-white">
                <div>
                    <h6 class="mb-0 small fw-bold">${item.nama}</h6>
                    <small class="text-muted">1 x Rp ${item.harga.toLocaleString('id-ID')}</small>
                </div>
                <button class="btn btn-sm text-danger" onclick="hapusItem(${index})"><i class="fas fa-times"></i></button>
            </div>
        `;
    });

    list.innerHTML = keranjang.length ? html : '<p class="text-muted text-center py-5">Belum ada item dipilih.</p>';
    
    let pajak = subtotal * 0.1;
    let total = subtotal + pajak;

    document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('pajak').innerText = 'Rp ' + pajak.toLocaleString('id-ID');
    document.getElementById('total-akhir').innerText = 'Rp ' + total.toLocaleString('id-ID');
}

function hapusItem(index) {
    keranjang.splice(index, 1);
    updateTampilan();
}

function setMetode(metode, element) {
    metodeBayar = metode;
    document.querySelectorAll('.btn-pay').forEach(btn => btn.classList.remove('active'));
    element.classList.add('active');
}

function tampilkanKonfirmasi() {
    if(keranjang.length === 0) return alert('Pilih menu dulu!');
    
    const total = document.getElementById('total-akhir').innerText;
    document.getElementById('modal-total').innerText = total;

    // Logika menampilkan QRIS atau Info Tunai
    if (metodeBayar === 'QRIS') {
        document.getElementById('qris-container').style.display = 'block';
        document.getElementById('tunai-info').style.display = 'none';
    } else {
        document.getElementById('qris-container').style.display = 'none';
        document.getElementById('tunai-info').style.display = 'block';
    }

    // Munculkan Modal
    const myModal = new bootstrap.Modal(document.getElementById('modalBayar'));
    myModal.show();
}

function prosesBayar() {
    const notaInfo = document.getElementById('nota-info');
    const notaItems = document.getElementById('nota-items');
    const notaTotal = document.getElementById('nota-total');

    const pelanggan = document.getElementById('customer_id').options[document.getElementById('customer_id').selectedIndex].text;
    const total = document.getElementById('total-akhir').innerText;

    // Isi Data Nota
    notaInfo.innerHTML = `Tgl: ${new Date().toLocaleString('id-ID')}<br>Plg: ${pelanggan}`;
    
    let html = '';
    keranjang.forEach(item => {
        html += `<div style="display:flex; justify-content:space-between"><span>${item.nama}</span><span>${Number(item.harga).toLocaleString('id-ID')}</span></div>`;
    });
    notaItems.innerHTML = html;
    notaTotal.innerHTML = `<div style="display:flex; justify-content:space-between; border-top:1px dashed #00; margin-top:5px"><b>TOTAL</b><b>${total}</b></div>`;
    document.getElementById('nota-metode').innerHTML = `Metode Bayar: ${metodeBayar}`;

    // Jalankan Print
    window.print();

    // Reset keranjang setelah bayar (Opsional)
    // keranjang = [];
    // updateTampilan();
    // location.reload(); 
}
</script>
<?= $this->endSection() ?>