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
        $password = (string)$this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            // Menggunakan password_verify (Pastikan di DB password sudah di-hash/enkripsi)
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'], // Mengambil role dari DB
                    'isLoggedIn' => true,
                ]);

                return $this->_redirectByRole();
            }
            return redirect()->back()->with('error', 'Password Salah!');
        }
        return redirect()->back()->with('error', 'Username Tidak Ditemukan!');
    }

    // Fungsi tambahan agar redirect lebih rapi berdasarkan role
    private function _redirectByRole()
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to('/produk')->with('success', 'Halo Admin, selamat bekerja!');
        }
        return redirect()->to('/transaksi')->with('success', 'Halo Kasir, selamat melayani!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}