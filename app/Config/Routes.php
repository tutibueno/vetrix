<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/home', 'Home::index');

$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->get('users/create', 'Users::create', ['filter' => 'auth']);
$routes->post('users/store', 'Users::store', ['filter' => 'auth']);
$routes->get('users/edit/(:num)', 'Users::edit/$1', ['filter' => 'auth']);
$routes->post('users/update/(:num)', 'Users::update/$1', ['filter' => 'auth']);
$routes->get('users/delete/(:num)', 'Users::delete/$1', ['filter' => 'auth']);

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

$routes->group('client', function ($routes) {
    $routes->get('/', 'Client::index');
    $routes->get('create', 'Client::create');
    $routes->post('store', 'Client::store');
    $routes->get('edit/(:num)', 'Client::edit/$1');
    $routes->post('update/(:num)', 'Client::update/$1');
    $routes->get('delete/(:num)', 'Client::delete/$1');
});

$routes->group('pet', function ($routes) {
    $routes->get('/', 'Pet::index');
    $routes->get('create', 'Pet::create');
    $routes->post('store', 'Pet::store');
    $routes->get('edit/(:num)', 'Pet::edit/$1');
    $routes->post('update/(:num)', 'Pet::update/$1');
    $routes->get('delete/(:num)', 'Pet::delete/$1');
});

//Ficha
$routes->get('pets/ficha/(:num)', 'Pet::ficha/$1');

// Histórico Médico
$routes->group('historico_medico', function ($routes) {
    $routes->get('index/(:num)', 'HistoricoMedico::index/$1');       // Listar históricos de um pet (pet_id)
    $routes->get('create/(:num)', 'HistoricoMedico::create/$1');     // Formulário novo histórico (pet_id)
    $routes->post('store', 'HistoricoMedico::store');                // Salvar novo histórico
    $routes->get('edit/(:num)', 'HistoricoMedico::edit/$1');         // Formulário edição histórico (id do histórico)
    $routes->post('update/(:num)', 'HistoricoMedico::update/$1');    // Atualizar histórico
    $routes->get('delete/(:num)', 'HistoricoMedico::delete/$1');     // Excluir histórico
});

// Vacinação
$routes->get('vacinas/nova/(:num)', 'Vacinas::nova/$1');
$routes->post('vacinas/store', 'Vacinas::store');
$routes->get('vacinas/editar/(:num)', 'Vacinas::editar/$1');
$routes->post('vacinas/update/(:num)', 'Vacinas::update/$1');
$routes->get('vacinas/delete/(:num)', 'Vacinas::delete/$1');

//Veterinario
$routes->group('veterinarios', function ($routes) {
    $routes->get('/', 'Veterinarios::index');
    $routes->get('create', 'Veterinarios::create');
    $routes->post('store', 'Veterinarios::store');
    $routes->get('edit/(:num)', 'Veterinarios::edit/$1');
    $routes->post('update/(:num)', 'Veterinarios::update/$1');
    $routes->get('delete/(:num)', 'Veterinarios::delete/$1');
});