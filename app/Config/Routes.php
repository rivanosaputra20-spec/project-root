<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::form');        // pertama kali buka → form
$routes->post('/process', 'Home::process'); // submit form
$routes->get('/home', 'Home::index');   // halaman home setelah login

$routes->get('/routing', 'Home::routing');
$routes->get('/controller', 'Home::controller');
$routes->get('/view', 'Home::view');
