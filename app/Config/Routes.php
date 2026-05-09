<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/', 'Home::index');

$routes->get('/categories',                   'Categories::index');
$routes->get('/categories/create',            'Categories::create');
$routes->post('/categories/store',            'Categories::store');
$routes->get('/categories/editar/(:num)',     'Categories::editar/$1');
$routes->post('/categories/update/(:num)',    'Categories::update/$1');
$routes->get('/categories/delete/(:num)',     'Categories::delete/$1');

$routes->get('/suppliers',                    'Suppliers::index');
$routes->get('/suppliers/create',             'Suppliers::create');
$routes->post('/suppliers/store',             'Suppliers::store');
$routes->get('/suppliers/editar/(:num)',      'Suppliers::editar/$1');
$routes->post('/suppliers/update/(:num)',     'Suppliers::update/$1');
$routes->get('/suppliers/delete/(:num)',      'Suppliers::delete/$1');

$routes->get('/customers',                    'Customers::index');
$routes->get('/customers/create',             'Customers::create');
$routes->post('/customers/store',             'Customers::store');
$routes->get('/customers/editar/(:num)',      'Customers::editar/$1');
$routes->post('/customers/update/(:num)',     'Customers::update/$1');
$routes->get('/customers/delete/(:num)',      'Customers::delete/$1');

$routes->get('/employees',                    'Employees::index');
$routes->get('/employees/create',             'Employees::create');
$routes->post('/employees/store',             'Employees::store');
$routes->get('/employees/editar/(:num)',      'Employees::editar/$1');
$routes->post('/employees/update/(:num)',     'Employees::update/$1');
$routes->get('/employees/delete/(:num)',      'Employees::delete/$1');

$routes->get('/shippers',                     'Shippers::index');
$routes->get('/shippers/create',              'Shippers::create');
$routes->post('/shippers/store',              'Shippers::store');
$routes->get('/shippers/editar/(:num)',       'Shippers::editar/$1');
$routes->post('/shippers/update/(:num)',      'Shippers::update/$1');
$routes->get('/shippers/delete/(:num)',       'Shippers::delete/$1');

$routes->get('/products',                     'Products::index');
$routes->get('/products/create',              'Products::create');
$routes->post('/products/store',              'Products::store');
$routes->get('/products/editar/(:num)',       'Products::editar/$1');
$routes->post('/products/update/(:num)',      'Products::update/$1');
$routes->get('/products/delete/(:num)',       'Products::delete/$1');

$routes->get('/orders',                                        'Orders::index');
$routes->get('/orders/create',                                 'Orders::create');
$routes->post('/orders/store',                                 'Orders::store');
$routes->get('/orders/editar/(:num)',                          'Orders::editar/$1');
$routes->post('/orders/update/(:num)',                         'Orders::update/$1');
$routes->get('/orders/delete/(:num)',                          'Orders::delete/$1');

$routes->get('/orders/detalles/(:num)',                        'Orders::detalles/$1');
$routes->post('/orders/detalle_store/(:num)',                  'Orders::detalleStore/$1');
$routes->get('/orders/detalle_editar/(:num)/(:num)',           'Orders::detalleEditar/$1/$2');
$routes->post('/orders/detalle_update/(:num)/(:num)',          'Orders::detalleUpdate/$1/$2');
$routes->get('/orders/detalle_delete/(:num)/(:num)',           'Orders::detalleDelete/$1/$2');



if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
