<?php


if (!function_exists('get_consulta_status_color')) {
    // Helper dentro do controller ou método privado
    function get_consulta_status_color(string $status): string
    {
        return match (strtolower($status)) {
            'agendada' => '#ffc30b', //amarelo
            'confirmada' => '#007bff', // azul
            'realizada' => '#28a745', // verde
            'cancelada' => '#dc3545', // vermelho
            default => '#6c757d', // cinza fallback
        };
    }
}
