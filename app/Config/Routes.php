<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- RUTE PUBLIK ---
$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// --- GRUP YANG HARUS LOGIN ---
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('riwayat', 'Transaksi::riwayat');
    
    // Dashboard Utama
    $routes->get('/', 'Home::index');
    
    // PENAMBAHAN: Rute Dashboard agar tidak 404
    $routes->get('dashboard', 'Dashboard::index'); 

    // --- RUTE MENU / PRODUK ---
    $routes->get('produk', 'Produk::index'); 
    $routes->post('produk/save', 'Produk::save');
    $routes->get('produk/edit/(:num)', 'Produk::edit/$1'); 
    $routes->post('produk/update/(:num)', 'Produk::update/$1');
    $routes->get('produk/delete/(:num)', 'Produk::delete/$1');

    // --- RUTE TRANSAKSI & KERANJANG ---
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/addToCart/(:num)', 'Transaksi::addToCart/$1'); 
    $routes->get('transaksi/clearCart', 'Transaksi::clearCart');
    $routes->post('transaksi/save', 'Transaksi::save'); 
    $routes->get('transaksi/print/(:num)', 'Transaksi::print/$1');

    // --- RUTE PELANGGAN ---
    $routes->get('pelanggan', 'Pelanggan::index');

    // --- RUTE PROFILE ---
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/updateFoto', 'Profile::updateFoto');
    $routes->post('profile/updatePassword', 'Profile::updatePassword');
});