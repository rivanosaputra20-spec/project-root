<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        
        $produkAll = $model->findAll();
        $kategori = array_unique(array_column($produkAll, 'kategori'));

        return view('transaksi/index', [
            'title'    => 'Order Menu',
            'produk'   => $produkAll,
            'kategori' => $kategori,
            'role'     => session()->get('role'),
            'cart'     => session()->get('cart') ?? []
        ]);
    }

    public function addToCart($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Admin hanya memantau menu.'], 403);
        }

        $model = new ProdukModel();
        $produk = $model->find($id);

        if ($produk) {
            if ($produk['stok'] <= 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Stok habis!'], 400);
            }

            $cart = session()->get('cart') ?? [];
            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
            } else {
                $cart[$id] = [
                    'id'    => $id,
                    'nama'  => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'qty'   => 1,
                    'foto'  => $produk['image']
                ];
            }
            session()->set('cart', $cart);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error'], 404);
    }

    public function getCart()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['harga'] * $item['qty']);
        }

        return $this->response->setJSON([
            'cart'            => array_values($cart),
            'total'           => $total,
            'total_formatted' => number_format($total, 0, ',', '.')
        ]);
    }

    public function save()
    {
        $produkModel = new ProdukModel();
        $transaksiModel = new TransaksiModel();
        $db = \Config\Database::connect();

        $cart = session()->get('cart');
        $total = $this->request->getPost('total_akhir');
        $nama_pelanggan = $this->request->getPost('nama_pelanggan') ?: 'Pelanggan Umum';
        $metode = $this->request->getPost('metode_pembayaran') ?: 'Cash';

        if (!$cart || !$total || $total == 0) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $db->transStart();

        // 1. Simpan ke tabel TRANSAKSI (Header)
        $data = [
            'nama_pelanggan' => $nama_pelanggan,
            'total_harga'    => $total,
            'metode_bayar'   => ucfirst($metode),
            'status'         => 'Selesai',
            'created_at'     => date('Y-m-d H:i:s')
        ];
        
        $transaksiModel->insert($data);
        $insertID = $transaksiModel->getInsertID();

        // 2. Simpan ke tabel DETAIL_TRANSAKSI (Per Item)
        foreach ($cart as $item) {
            $db->table('detail_transaksi')->insert([
                'transaksi_id' => $insertID,
                'produk_id'    => $item['id'],
                'nama_produk'  => $item['nama'],
                'harga_satuan' => $item['harga'],
                'jumlah'       => $item['qty'],
                'subtotal'     => $item['harga'] * $item['qty']
            ]);

            // 3. Update Stok Produk
            $p = $produkModel->find($item['id']);
            if ($p) {
                $produkModel->update($item['id'], ['stok' => $p['stok'] - $item['qty']]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses transaksi!');
        }

        // Hapus session keranjang
        session()->remove('cart');

        return redirect()->to(base_url('transaksi/print/' . $insertID));
    }

    public function riwayat()
    {
        $model = new TransaksiModel();
        return view('transaksi/riwayat', [
            'title'     => 'Riwayat Transaksi',
            'transaksi' => $model->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function print($id)
    {
        $model = new TransaksiModel();
        $db = \Config\Database::connect();

        $transaksi = $model->find($id);
        if (!$transaksi) return redirect()->to(base_url('transaksi'));

        // Ambil item langsung dari database, bukan dari session flashdata
        $items = $db->table('detail_transaksi')
                    ->where('transaksi_id', $id)
                    ->get()
                    ->getResultArray();

        return view('transaksi/print', [
            'title'     => 'Cetak Struk #' . $id,
            'transaksi' => $transaksi,
            'items'     => $items
        ]);
    }
}