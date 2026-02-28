<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    // Tampilan Gallery Menu
    public function index() {
        $model = new ProdukModel();
        $data = [
            'title'   => 'Order Menu',
            'produk'  => $model->findAll(),
            'cart'    => session()->get('cart') ?? []
        ];
        return view('transaksi/index', $data); 
    }

    // PENAMBAHAN: Fungsi Riwayat Transaksi agar rute 'riwayat' bekerja
    public function riwayat()
    {
        $model = new TransaksiModel();
        $data = [
            'title'     => 'Riwayat Transaksi - Queejuy Coffee',
            // Mengambil semua transaksi, urutkan dari yang terbaru
            'transaksi' => $model->orderBy('id', 'DESC')->findAll()
        ];
        
        return view('transaksi/riwayat', $data);
    }

    // Menambah item ke keranjang via Session
    public function addToCart($id)
    {
        $model = new ProdukModel();
        $produk = $model->find($id);

        if ($produk) {
            $cart = session()->get('cart') ?? [];

            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
            } else {
                $cart[$id] = [
                    'nama'  => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'qty'   => 1,
                    'foto'  => $produk['image'] 
                ];
            }

            session()->set('cart', $cart);
            return redirect()->to('/transaksi')->with('success', 'Menu berhasil ditambahkan!');
        }
        
        return redirect()->to('/transaksi')->with('error', 'Produk tidak ditemukan!');
    }

    // Hapus satu item atau bersihkan keranjang
    public function clearCart() {
        session()->remove('cart');
        return redirect()->to('/transaksi');
    }

    // Simpan Transaksi ke Database
    public function save()
    {
        $model = new TransaksiModel();
        
        // Ambil data dari form post
        $total = $this->request->getPost('total_harga');
        $nama_pelanggan = $this->request->getPost('nama_pelanggan') ?: 'Pelanggan Umum';
        $metode = $this->request->getPost('metode_bayar') ?? 'Cash';

        if (!$total || $total == 0) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $data = [
            'nama_pelanggan' => $nama_pelanggan,
            'total_harga'    => $total, 
            'metode_bayar'   => $metode,
            'status'         => 'Selesai',
            'created_at'     => date('Y-m-d H:i:s')
        ];

        $model->insert($data);
        $insertID = $model->getInsertID(); // Gunakan getInsertID() untuk CI4

        session()->remove('cart');
        return redirect()->to('/transaksi/print/' . $insertID);
    }

    public function print($id) {
        $model = new TransaksiModel();
        $transaksi = $model->find($id);

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Data transaksi tidak ditemukan.');
        }

        $data = [
            'title'     => 'Cetak Struk #' . $id,
            'transaksi' => $transaksi
        ];
        return view('transaksi/print', $data);
    }
}