<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserPermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $currentUser = $session->get('user');

        if (!$currentUser) {
            return redirect()->to('/login')->with('error', 'Você precisa estar logado.');
        }

        // Pegamos o ID da URL (/users/edit/ID)
        $segments = $request->getUri()->getSegments();
        $id = end($segments);   

        // Editar usuário
        if ($arguments && in_array('edit', $arguments)) {
            if ($currentUser['perfil'] !== 'admin' && $currentUser['id'] != $id) {
                return view('errors/html/error_403');
            }
        }

        // Se não for admin -> não pode criar/deletar usuários
        if ($arguments && in_array('manage', $arguments)) {
            if ($currentUser['perfil'] !== 'admin') {
                return redirect()->to('/users')->with('error', 'Apenas administradores podem gerenciar usuários.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nada necessário aqui
    }
}
