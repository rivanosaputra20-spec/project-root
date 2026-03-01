<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /**
         * PERBAIKAN UNTUK API/POSTMAN:
         * Kita mengecek apakah URL yang diakses diawali dengan 'api/'.
         * Jika iya, kita lewati pengecekan Session agar Postman bisa masuk.
         */
        if (str_contains($request->getUri()->getPath(), 'api/')) {
            return; 
        }

        // 1. Cek apakah user sudah login (Hanya untuk rute non-API / Browser)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah ini rute khusus admin (auth:admin)
        if ($arguments && in_array('admin', $arguments)) {
            if (session()->get('role') !== 'admin') {
                return redirect()->to('/')->with('error', 'Akses ditolak! Halaman ini khusus Admin.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan
    }
}