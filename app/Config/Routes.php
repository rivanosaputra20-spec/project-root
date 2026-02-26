<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Rute Publik (Bisa diakses tanpa login)
$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// Grup yang harus login (Filter 'auth' menjaga semua rute di dalam)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard Utama
    $routes->get('/', 'Home::index');

    // --- Rute MENU / PRODUK ---
    // User & Admin bisa lihat menu
    $routes->get('produk', 'Produk::index'); 
    
    // Fitur Tambah, Update, Hapus (Hanya Admin - Filter 'auth:admin')
    $routes->post('produk/save', 'Produk::save');
    $routes->post('produk/update/(:num)', 'Produk::update/$1');
    $routes->get('produk/hapus/(:num)', 'Produk::hapus/$1');

    // --- Rute TRANSAKSI ---
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/create', 'Transaksi::create');
    $routes->post('transaksi/store', 'Transaksi::store');

    // --- Rute PELANGGAN ---
    $routes->get('pelanggan', 'Pelanggan::index');
    $routes->post('produk/update/(:num)', 'Produk::update/$1');
});