<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MedicamentosSeeder extends Seeder
{
    public function run()
    {
        $principiosAtivos = [
            'Amoxicilina',
            'Doxiciclina',
            'Cefalexina',
            'Enrofloxacina',
            'Ciprofloxacina',
            'Metronidazol',
            'Ivermectina',
            'Fenbendazol',
            'Albendazol',
            'Praziquantel',
            'Meloxicam',
            'Carprofeno',
            'Prednisolona',
            'Dexametasona',
            'Cetoprofeno',
            'Firocoxib',
            'Tramadol',
            'Dipirona',
            'Omeprazol',
            'Ranitidina',
            'Levamisol',
            'Cloranfenicol',
            'Tilósina',
            'Florfenicol',
            'Oxitetraciclina',
            'Sulfametoxazol + Trimetoprim',
            'Clindamicina',
            'Ketamina',
            'Propofol',
            'Vacina Antirrábica',
            'Vacina Polivalente',
            'Vacina Gripe Canina',
            'Suplemento Vitaminado',
            'Condroitina + Glucosamina',
            'Ômega 3',
            'Probióticos',
            'Lisina',
            'Taurina'
        ];

        $formas = [
            'Comprimido',
            'Cápsula',
            'Suspensão oral',
            'Injetável',
            'Pasta oral',
            'Top spot',
            'Colírio',
            'Pomada',
            'Shampoo',
            'Spray'
        ];

        $especies = [
            'Cães',
            'Gatos',
            'Cães e Gatos',
            'Bovinos',
            'Equinos',
            'Suínos',
            'Ovinos',
            'Aves'
        ];

        $laboratorios = [
            'Ceva',
            'Ourofino',
            'Agener União',
            'Zoetis',
            'MSD Saúde Animal',
            'Boehringer Ingelheim',
            'Elanco',
            'Virbac',
            'Syntec',
            'Vetnil'
        ];

        $categorias = [
            'Antibiótico', 
            'Antiparasitário', 
            'Anti-inflamatório', 
            'Vacina', 
            'Analgésico'
        ];

        $medicamentos = [];

        for ($i = 1; $i <= 500; $i++) {
            $principio = $principiosAtivos[array_rand($principiosAtivos)];
            $nomeComercial = $principio . ' Vet ' . $i;

            $medicamentos[] = [
                'nome_comercial'  => $nomeComercial,
                'principio_ativo' => $principio,
                'especie_destino' => $especies[array_rand($especies)],
                'forma'           => $formas[array_rand($formas)],
                'categoria'       => $formas[array_rand($categorias)],
                'laboratorio'     => $laboratorios[array_rand($laboratorios)]
            ];
        }

        $this->db->table('medicamentos')->insertBatch($medicamentos);
    }
}
