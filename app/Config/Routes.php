<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/home', 'Home::index');

$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);

//Users
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->get('users/create', 'Users::create', ['filter' => 'auth']);
$routes->post('users/store', 'Users::store', ['filter' => 'auth']);
$routes->get('users/edit/(:num)', 'Users::edit/$1', ['filter' => 'auth']);
$routes->post('users/update/(:num)', 'Users::update/$1', ['filter' => 'auth']);
$routes->get('users/delete/(:num)', 'Users::delete/$1', ['filter' => 'auth']);

//Login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

//Clintes
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Client::index');
    $routes->get('create', 'Client::create');
    $routes->post('store', 'Client::store');
    $routes->get('edit/(:num)', 'Client::edit/$1');
    $routes->post('update/(:num)', 'Client::update/$1');
    $routes->get('delete/(:num)', 'Client::delete/$1');
});

//Pets
$routes->group('pet', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pet::index');
    $routes->get('create', 'Pet::create');
    $routes->post('store', 'Pet::store');
    $routes->get('edit/(:num)', 'Pet::edit/$1');
    $routes->post('update/(:num)', 'Pet::update/$1');
    $routes->get('delete/(:num)', 'Pet::delete/$1');
    $routes->get('ficha/(:num)', 'Pet::ficha/$1');
});

//$routes->get('pets/ficha/(:num)', 'Pet::ficha/$1');

// Histórico Médico
$routes->group('historico_medico',['filter' => 'auth'], function ($routes) {
    $routes->get('index/(:num)', 'HistoricoMedico::index/$1');       // Listar históricos de um pet (pet_id)
    $routes->get('create/(:num)', 'HistoricoMedico::create/$1');     // Formulário novo histórico (pet_id)
    $routes->post('store', 'HistoricoMedico::store');                // Salvar novo histórico
    $routes->get('edit/(:num)', 'HistoricoMedico::edit/$1');         // Formulário edição histórico (id do histórico)
    $routes->post('update/(:num)', 'HistoricoMedico::update/$1');    // Atualizar histórico
    $routes->get('delete/(:num)', 'HistoricoMedico::delete/$1');     // Excluir histórico
});

// Vacinação
$routes->group('vacinas', ['filter' => 'auth'], function ($routes) {
    $routes->get('nova/(:num)', 'Vacinas::nova/$1');
    $routes->post('store', 'Vacinas::store');
    $routes->get('editar/(:num)', 'Vacinas::editar/$1');
    $routes->post('update/(:num)', 'Vacinas::update/$1');
    $routes->get('delete/(:num)', 'Vacinas::delete/$1');
});

//Veterinario
$routes->group('veterinarios', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Veterinarios::index');
    $routes->get('create', 'Veterinarios::create');
    $routes->post('store', 'Veterinarios::store');
    $routes->get('edit/(:num)', 'Veterinarios::edit/$1');
    $routes->post('update/(:num)', 'Veterinarios::update/$1');
    $routes->get('delete/(:num)', 'Veterinarios::delete/$1');
});

//$routes->get('prescricoes/(:num)/medicamentos/create', 'PrescricaoMedicamentoController::create/$1');
//$routes->post('prescricoes/(:num)/medicamentos/store', 'PrescricaoMedicamentoController::store/$1');

// Rotas para Prescricoes CRUD
$routes->group('prescricoes', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Prescricoes::index');                // Listagem de prescrições
    $routes->get('index/(:num)', 'Prescricoes::index/$1'); // Lista prescrições do pet
    $routes->get('create/(:num)', 'Prescricoes::create/$1');         // Formulário para criar prescrição (modal)
    $routes->post('store', 'Prescricoes::store');          // Salvar nova prescrição
    $routes->get('edit/(:num)', 'Prescricoes::edit/$1');   // Formulário para editar prescrição (modal)
    $routes->post('update/(:num)', 'Prescricoes::update/$1'); // Atualizar prescrição
    $routes->get('delete/(:num)', 'Prescricoes::delete/$1'); // Excluir prescrição
    $routes->get('list/(:num)', 'Prescricoes::list/$1'); // Lista prescrições do pet

    // Medicamentos dentro de uma prescrição
    $routes->get('medicamento/excluir/(:num)', 'Prescricoes::excluirMedicamento/$1');
    
    //Impressão
    $routes->get('imprimir/(:num)', 'Prescricoes::imprimir/$1');

    //Impressão de PFP :TODO
    $routes->get('imprimir/pdf/(:num)', 'Prescricoes::imprimirPdf/$1');

});

// Exames
$routes->group('exames', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:num)', 'ExamesController::index/$1'); // lista exames do pet
    $routes->get('create/(:num)', 'ExamesController::create/$1'); // pet_id
    $routes->post('store/(:num)', 'ExamesController::store/$1'); // pet_id
    $routes->get('edit/(:num)', 'ExamesController::edit/$1'); // exame_id
    $routes->post('update/(:num)', 'ExamesController::update/$1'); // exame_id
    $routes->get('delete/(:num)', 'ExamesController::delete/$1'); // exame_id
    
    //Impressão
    $routes->get('imprimir/(:num)', 'ExamesController::imprimir/$1');
    
});

// Rotas da Clínica
$routes->group('clinica', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ClinicaController::show');                       // Mostrar dados da clínica
    $routes->get('edit/(:num)', 'ClinicaController::edit/$1');         // Formulário para edição
    $routes->post('update/(:num)', 'ClinicaController::update/$1');    // Atualizar dados
});
