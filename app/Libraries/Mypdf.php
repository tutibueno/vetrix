<?php

namespace App\Libraries;

use Mpdf\Mpdf;

class Mypdf
{
    public function generate($html, $filename = 'document.pdf', $download = false)
    {
        $mpdf = new Mpdf([
            'format' => 'A5',   // sua receita está em A5
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 30,
            'mode' => 'utf-8',
        ]);

        $mpdf->WriteHTML($html);

        if ($download) {
            return $mpdf->Output($filename, 'D'); // força download
        } else {
            return $mpdf->Output($filename, 'I'); // abre no navegador
        }
    }
}
