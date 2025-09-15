<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ClinicaModel;

class PublicBaseController extends Controller
{
    protected $clinica;
    protected $data = []; // dados globais para as views públicas

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // Carrega os dados da clínica (pega o primeiro registro cadastrado)
        $clinicaModel = new ClinicaModel();
        $this->clinica = $clinicaModel->first();

        // Armazena para uso nas views
        $this->data['clinica'] = $this->clinica;

    }

    /**
     * Renderiza a view pública (com header e footer incluidos automaticamente)
     *
     * @param string $view  nome da view principal (ex: 'confirma/index')
     * @param array  $data  dados adicionais específicos da view
     * @return string
     */
    protected function render(string $view, array $data = [])
    {
        // merge dados globais (clinica) com dados específicos da view
        $data = array_merge($this->data, $data);

        // Opcional: incluir header e footer automaticamente
        // Se preferir NÃO incluir header/footer aqui, basta retornar apenas view($view, $data);
        return view('layouts/public_header', $data)
            . view($view, $data)
            . view('layouts/public_footer', $data);
    }
}

