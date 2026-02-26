<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct() {
        // Inisialisasi model agar bisa digunakan di semua fungsi
        $this->produkModel = new ProdukModel();
    }

    public function index() {
        $session = session();
        
        // Memastikan hanya user login yang bisa akses
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title'    => 'Menu Gallery',
            'produk'   => $this->produkModel->findAll(), // Ambil semua data produk
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack'], // Variabel filter kategori
            'role'     => $session->get('role'), 
            'username' => $session->get('username')
        ];
        
        return view('produk/index', $data);
    }

    // Menangani penyimpanan menu baru
    public function save() {
        $file = $this->request->getFile('image');
        
        // Cek apakah ada file yang diupload
        $namaGambar = ($file && $file->isValid()) ? $file->getRandomName() : 'default.jpg';
        if($file && $file->isValid()) {
            $file->move('uploads/menu', $namaGambar);
        }

        $this->produkModel->save([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'image'       => $namaGambar
        ]);

        return redirect()->to('/produk')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * FUNGSI BARU: Update Harga & Stok (Untuk Admin)
     * Dipanggil melalui form modal edit di produk/index.php
     */
    public function update($id) {
        // Proteksi role admin (Keamanan tambahan)
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

       $data = [
        'harga' => $this->request->getPost('harga'),
        'stok'  => $this->request->getPost('stok'),
    ];

    $this->produkModel->update($id, $data);
    return redirect()->to('/produk')->with('success', 'Data menu berhasil diperbarui!');
    }

    // Menghapus menu
    public function hapus($id) {
        // Cari data produk untuk menghapus gambarnya juga (Opsional tapi disarankan)
        $produk = $this->produkModel->find($id);
        if ($produk && $produk['image'] != 'default.jpg') {
            if (file_exists('uploads/menu/' . $produk['image'])) {
                unlink('uploads/menu/' . $produk['image']);
            }
        }

        $this->produkModel->delete($id);
        return redirect()->to('/produk')->with('success', 'Menu berhasil dihapus!');
    }
}