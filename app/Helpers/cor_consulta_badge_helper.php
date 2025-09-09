<?php


if (!function_exists('get_consulta_status_color_badge')) {
    // Helper dentro do controller ou método privado
    function get_consulta_status_color_badge(string $status): string
    {
        return match (strtolower($status)) {
            'agendada' => 'bg-warning',
            'confirmada' => 'bg-success',
            'realizada' => 'bg-success',
            'cancelada' => 'bg-danger',
            default => 'bg-warning',
        };
    }
}
