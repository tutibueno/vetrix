<?php

// app/Controllers/Medicamentos.php
namespace App\Controllers;

use App\Models\MedicamentosModel;
use CodeIgniter\Controller;

class Medicamentos extends Controller
{
    protected $medicamentosModel;

    public function __construct()
    {
        $this->medicamentosModel = new MedicamentosModel();
    }

    public function index()
    {

        $med = $this->medicamentosModel->findAll();

        return view('medicamentos/index', ['medicamentos' => $med]);
    }

    public function search()
    {
        $term = $this->request->getGet('term'); // parâmetro da query string

        $resultados = $this->medicamentosModel
            ->like('nome_comercial', $term)
            ->orLike('principio_ativo', $term)
            ->findAll(10);

        return $this->response->setJSON($resultados);
    }

    public function uploadCsv_old()
    {
        $file = $this->request->getFile('csv_file');

        if (!$file->isValid() || $file->getExtension() !== 'csv') {
            return redirect()->back()->with('error', 'Arquivo inválido. Envie um CSV.');
        }

        $medModel = $this->medicamentosModel;

        // Apagar todos os medicamentos antes de importar
        $medModel->truncate();

        $handle = fopen($file->getTempName(), 'r');
        if ($handle !== false) {
            $header = fgetcsv($handle, 1000, ';'); // primeira linha (cabeçalho)

            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                $data = array_combine($header, $row);
                $medModel->insert([
                    'nome_comercial' => $data['nome_comercial'] ?? '',
                    'principio_ativo' => $data['principio_ativo'] ?? '',
                    'forma'           => $data['forma'] ?? '',
                    'categoria'       => $data['categoria'] ?? null,
                ]);
            }

            fclose($handle);
        }

        return redirect()->back()->with('success', 'Medicamentos importados com sucesso!');
    }

    public function uploadCsv()
    {
        helper('filesystem');

        // tenta pegar o arquivo por nomes comuns (compatível com sua view)
        $file = $this->request->getFile('csv_file') ?? $this->request->getFile('file') ?? null;

        if (!$file) {
            return redirect()->back()->with('error', 'Nenhum arquivo foi enviado. Verifique o campo do formulário.');
        }

        if (!$file->isValid()) {
            // Mensagem genérica, pode inspecionar $file->getError() para detalhes
            return redirect()->back()->with('error', 'Arquivo inválido. Código de erro: ' . $file->getError());
        }

        // extensão do cliente (mais confiável)
        $ext = strtolower($file->getClientExtension() ?: $file->getExtension());
        if ($ext !== 'csv') {
            return redirect()->back()->with('error', 'Formato inválido. Envie um arquivo CSV.');
        }

        $tmpPath = $file->getTempName();
        if (!is_readable($tmpPath)) {
            return redirect()->back()->with('error', 'Não foi possível ler o arquivo temporário.');
        }

        // abre arquivo e detecta delimitador (primeira linha)
        $handle = fopen($tmpPath, 'r');
        if ($handle === false) {
            return redirect()->back()->with('error', 'Falha ao abrir o arquivo.');
        }

        // lê a primeira linha como string para detectar delimitador
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        // lê cabeçalho
        $header = fgetcsv($handle, 0, $delimiter);
        if ($header === false) {
            fclose($handle);
            return redirect()->back()->with('error', 'Arquivo CSV vazio ou cabeçalho inválido.');
        }

        // normaliza nomes de colunas (sem acento, minúsculas, underscores)
        $normalizedHeader = array_map(function ($h) {
            $h = trim($h);
            $h = mb_strtolower($h);
            $h = str_replace([' ', '-', '/'], '_', $h);
            return $h;
        }, $header);

        // Campos esperados (aceita variações)
        $expected = ['nome_comercial', 'principio_ativo', 'forma', 'categoria'];

        // mapa de índices
        $map = [];
        foreach ($normalizedHeader as $i => $col) {
            $map[$col] = $i;
        }

        // prepara batch
        $rows = [];
        $now = date('Y-m-d H:i:s');

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            // pula linhas vazias
            $allEmpty = true;
            foreach ($data as $c) {
                if (trim($c) !== '') {
                    $allEmpty = false;
                    break;
                }
            }
            if ($allEmpty) continue;

            // construir registro com fallback quando coluna não existir
            $registro = [
                'nome_comercial'  => isset($map['nome_comercial']) ? ($data[$map['nome_comercial']] ?? '') : ($data[0] ?? ''),
                'principio_ativo' => $map['principio_ativo'] ? ($data[$map['principio_ativo']] ?? '') : ($data[1] ?? ''),
                'forma'           => isset($map['forma']) ? ($data[$map['forma']] ?? '') : ($data[2] ?? ''),
                'categoria'       => isset($map['categoria']) ? ($data[$map['categoria']] ?? null) : ($data[3] ?? null),
                'created_at'      => $now,
                'updated_at'      => $now,
            ];

            // trim de strings
            array_walk($registro, function (&$v) {
                if (is_string($v)) $v = trim($v);
            });

            // opcional: ignorar registros sem nome
            if ($registro['nome_comercial'] === '') continue;

            $rows[] = $registro;
        }

        fclose($handle);

        if (empty($rows)) {
            return redirect()->back()->with('error', 'Nenhum registro válido encontrado no CSV.');
        }

        // insere em transação (substitui todos os medicamentos)
        $db = \Config\Database::connect();
        $medModel = $this->medicamentosModel;

        try {
            $db->transStart();
            // truncate (remove tudo)
            $db->table($medModel->table)->truncate();

            // insert em lote (divida em chunks se for muito grande)
            $chunks = array_chunk($rows, 1000);
            foreach ($chunks as $batch) {
                $medModel->insertBatch($batch);
            }
            $db->transComplete();

            if (!$db->transStatus()) {
                return redirect()->back()->with('error', 'Erro ao gravar no banco de dados.');
            }

            return redirect()->back()->with('success', 'CSV importado com sucesso. Foram adicionados ' . count($rows) . ' medicamentos.');
        } catch (\Exception $e) {
            // rollback automático em caso de exception
            return redirect()->back()->with('error', 'Exceção ao importar CSV: ' . $e->getMessage());
        }
    }


    public function downloadCsv()
    {
        $medModel = $this->medicamentosModel;
        $medicamentos = $medModel->findAll();

        $filename = 'medicamentos_' . date('Ymd_His') . '.csv';

        $output = fopen('php://temp', 'w');

        // Cabeçalho
        fputcsv($output, ['nome_comercial', 'principio_ativo', 'forma', 'categoria'], ';');

        // Dados
        foreach ($medicamentos as $med) {
            fputcsv($output, [
                $med['nome_comercial'],
                $med['principio_ativo'],
                $med['forma'],
                $med['categoria'],
            ], ';');
        }

        rewind($output);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody(stream_get_contents($output));
    }
}
