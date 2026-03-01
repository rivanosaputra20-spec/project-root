<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct() {
        $this->produkModel = new ProdukModel();
    }

    // --- METHOD UNTUK TAMPILAN WEB (BROWSER) ---

    public function index() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title'    => 'Menu Gallery',
            'produk'   => $this->produkModel->findAll(),
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack'],
            'role'     => session()->get('role'), 
            'username' => session()->get('username')
        ];
        
        return view('produk/index', $data);
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $produk = $this->produkModel->find($id);

        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Menu tidak ditemukan!');
        }

        $data = [
            'title'    => 'Edit Menu',
            'produk'   => $produk,
            'kategori' => ['Coffee', 'Non-Coffee', 'Pastry', 'Snack'],
            'role'     => session()->get('role'),
            'username' => session()->get('username')
        ];

        return view('produk/edit', $data);
    }

    public function save() {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $file = $this->request->getFile('image');
        $namaGambar = 'default.png';
        
        if($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads/menu', $namaGambar);
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

    public function update($id) {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $produkLama = $this->produkModel->find($id);

        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];

        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambarBaru = $file->getRandomName();
            $file->move(FCPATH . 'uploads/menu', $namaGambarBaru);
            $data['image'] = $namaGambarBaru;

            if (!empty($produkLama['image']) && $produkLama['image'] != 'default.png') {
                $pathLama = FCPATH . 'uploads/menu/' . $produkLama['image'];
                if (is_file($pathLama)) {
                    unlink($pathLama);
                }
            }
        }

        $this->produkModel->update($id, $data);
        return redirect()->to('/produk')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function delete($id) 
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/produk')->with('error', 'Akses ditolak!');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $image = $produk['image'];
            if (!empty($image) && $image != 'default.png') {
                $path = FCPATH . 'uploads/menu/' . $image;
                if (is_file($path)) {
                    unlink($path);
                }
            }

            $this->produkModel->delete($id);
            return redirect()->to('/produk')->with('success', 'Menu berhasil dihapus!');
        }

        return redirect()->to('/produk')->with('error', 'Menu tidak ditemukan!');
    }

    // --- METHOD KHUSUS API (POSTMAN) ---

    /**
     * URL: GET localhost:8080/api/produk
     */
    public function getProdukApi()
    {
        $produk = $this->produkModel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'code'   => 200,
            'data'   => $produk
        ]);
    }

    /**
     * URL: GET localhost:8080/api/produk/{id}
     */
    public function getDetailApi($id)
    {
        $produk = $this->produkModel->find($id);

        if ($produk) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $produk
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Produk tidak ditemukan'
        ])->setStatusCode(404);
    }
}