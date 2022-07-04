<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/*
 * --------------------------------------------------------------------
 * Auth Controller
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Auth::index', ['filter' => 'noAuthGuard']);
$routes->get('/login', 'Auth::index', ['filter' => 'noAuthGuard']);
$routes->get('/reset-password', 'Auth::resetPassword');
$routes->get('/restore-password/(:any)', 'Auth::restorePassword/$1');
$routes->get('/logout', 'Auth::logout');
$routes->post('/login', 'Auth::signIn');
$routes->post('/reset-password', 'Auth::sendResetLink');
$routes->post('/restore-password/(:any)', 'Auth::saveRestoredPassword/$1');
/*
 * --------------------------------------------------------------------
 * Setting Controller
 * --------------------------------------------------------------------
 */
$routes->get('/mi-perfil', 'Setting::profile', ['filter' => 'authGuard']);
$routes->get('/municipios/(:any)', 'Setting::getMunicipios/$1', ['filter' => 'authGuard']);
$routes->post('/change-password', 'Setting::changePassword', ['filter' => 'authGuard']);
$routes->post('/update-profile', 'Setting::updateProfile', ['filter' => 'authGuard']);
$routes->post('/update-delivery-address', 'Setting::updateDeliveryAddress', ['filter' => 'authGuard']);
/*
 * --------------------------------------------------------------------
 * Home Controller
 * --------------------------------------------------------------------
 */
$routes->get('/inicio', 'Home::index', ['filter' => 'authGuard']);
/*
 * --------------------------------------------------------------------
 * Rol Controller
 * --------------------------------------------------------------------
 */
$routes->get('/roles', 'Rol::index', ['filter' => 'authGuard']);
$routes->get('/get-roles', 'Rol::getRoles', ['filter' => 'authGuard']);
$routes->get('/get-rol/(:any)', 'Rol::getRol/$1', ['filter' => 'authGuard']);
$routes->post('/delete-rol', 'Rol::deleteRol', ['filter' => 'authGuard']);
$routes->post('/roles', 'Rol::saveRoles', ['filter' => 'authGuard']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
