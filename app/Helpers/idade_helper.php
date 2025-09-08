<?php

use CodeIgniter\I18n\Time;

if (!function_exists('calcular_idade')) {
    function calcular_idade($dataNascimento, $dataReferencia = null): string
    {

        if($dataNascimento == null)
            return '0 anos';

        $dataNascimento = new \DateTime($dataNascimento);
        $hoje = new \DateTime();
        if($dataReferencia)
            $hoje = new \DateTime($dataReferencia);

        if($hoje < $dataNascimento)
            $dataNascimento = $hoje;

        $idade = $hoje->diff($dataNascimento);

        $textoIdade = $idade->y . ' ano';
        $idade->y == 0 || $idade->y > 1 ? $textoIdade .= 's' : '';
        $textoIdade .= ' e ' . $idade->m;
        $idade->m > 1 || $idade->m == 0 ? $textoIdade .= ' meses' : $textoIdade .= ' mês';

        $dataNascimento == '0000-00-00' ? $textoIdade = '' : $textoIdade;

        return $textoIdade;
    }
}
