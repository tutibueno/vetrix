<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard', ['title' => 'Painel de Controle']);
    }
}
