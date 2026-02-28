<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, tendang ke halaman sesuai role agar tidak login dua kali
        if (session()->get('isLoggedIn')) {
            return $this->_redirectByRole();
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = trim((string)$this->request->getPost('password'));

        $user = $model->where('username', $username)->first();

        if ($user) {
            // Mengecek password terhadap hash di DB
            if (password_verify($password, $user['password'])) {
                
                // Logika Foto Profil: Jika kosong gunakan default.png
                $foto = ($user['user_image']) ? $user['user_image'] : 'default.png';

                session()->set([
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'], // 'admin' atau 'user'
                    'user_image' => $foto, 
                    'isLoggedIn' => true,
                ]);

                return $this->_redirectByRole();
            }
            return redirect()->back()->with('error', 'Password Salah!');
        }
        return redirect()->back()->with('error', 'Username Tidak Ditemukan!');
    }

    // Mengatur arah halaman setelah login berhasil
    private function _redirectByRole()
    {
        if (session()->get('role') == 'admin') {
            // Admin diarahkan ke manajemen produk
            return redirect()->to('/produk')->with('success', 'Halo Admin, selamat bekerja!');
        }
        
        // User/Kasir diarahkan langsung ke halaman pemesanan
        return redirect()->to('/transaksi')->with('success', 'Halo Kasir, selamat melayani!');
    }

    // TAMBAHKAN INI: Fungsi untuk proteksi halaman (Filter manual)
    // Panggil ini di awal fungsi Controller lain untuk cek akses
    public function checkAuth($roleRequired = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->send();
        }

        if ($roleRequired && session()->get('role') !== $roleRequired) {
            // Jika User mencoba buka halaman Admin, lempar balik ke transaksi
            return redirect()->to('/transaksi')->with('error', 'Anda tidak punya akses ke sana!')->send();
        }
    }

    public function logout()
    {
        // Bersihkan semua session termasuk keranjang belanja
        session()->destroy();
        return redirect()->to('/login');
    }
}