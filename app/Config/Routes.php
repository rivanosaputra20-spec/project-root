<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- RUTE PUBLIK ---
$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// --- GRUP API (UNTUK POSTMAN) ---
// Grup ini dibuat tanpa filter 'auth' (session) agar mudah dites di Postman.
// Gunakan awalan 'api/' untuk semua rute di sini.
$routes->group('api', function($routes) {
    // API Produk
    $routes->get('produk', 'Produk::getProdukApi');             // GET: localhost:8080/api/produk
    $routes->get('produk/(:num)', 'Produk::getDetailApi/$1');   // GET: localhost:8080/api/produk/1
    
    // API Transaksi
    $routes->post('transaksi/save', 'Transaksi::saveApi');      // POST: localhost:8080/api/transaksi/save
    $routes->get('riwayat', 'Transaksi::riwayatApi');           // GET: localhost:8080/api/riwayat
});

// --- GRUP YANG HARUS LOGIN (Tampilan Web) ---
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard Utama
    $routes->get('/', 'Home::index');
    $routes->get('dashboard', 'Dashboard::index'); 

    // --- RUTE MENU / PRODUK ---
    $routes->get('produk', 'Produk::index'); 
    $routes->post('produk/save', 'Produk::save');
    $routes->get('produk/edit/(:num)', 'Produk::edit/$1'); 
    $routes->post('produk/update/(:num)', 'Produk::update/$1');
    $routes->get('produk/delete/(:num)', 'Produk::delete/$1');

    // --- RUTE TRANSAKSI & KERANJANG ---
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/getCart', 'Transaksi::getCart'); 
    $routes->get('transaksi/addToCart/(:num)', 'Transaksi::addToCart/$1'); 
    $routes->get('transaksi/clearCart', 'Transaksi::clearCart');
    $routes->post('transaksi/save', 'Transaksi::save'); 
    $routes->get('transaksi/print/(:num)', 'Transaksi::print/$1');
    $routes->get('riwayat', 'Transaksi::riwayat');

    // --- RUTE PELANGGAN ---
    $routes->get('pelanggan', 'Pelanggan::index');

    // --- RUTE PROFILE ---
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/updateFoto', 'Profile::updateFoto');
    $routes->post('profile/updatePassword', 'Profile::updatePassword');
});