<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Prescrição_<?= esc($pet['nome']) ?>_<?= esc($prescricao['tipo_prescricao']) ?>_<?= date('d_m_Y', strtotime($prescricao['data_prescricao'])) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 148mm;
            /* A5 horizontal */
            height: 210mm;
            /* A5 vertical */
            margin: 0;
            padding: 2mm;
        }

        h1,
        h2 {
            margin: 0;
            padding: 0;
        }

        .center {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
            margin-bottom: 0px;
        }

        .info-table td {
            border: 1px solid #000;
            border-radius: 10px;
            padding: 5px;
            vertical-align: top;
            background-color: #0000;
            text-align: center;
            width: 50%;
        }

        .info-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            width: 100%;
        }

        .med-table {
            width: 97%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .med-table2 {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .med-table td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .pontilhado {
            border-bottom: 1px dotted #000;
            flex: 1;
            margin: 0 5px;
        }

        .tipo-farmacia {
            white-space: nowrap;
        }

        .quantidade {
            white-space: nowrap;
            width: 10%;
            text-align: right;
        }

        td[colspan="3"] {
            display: flex;
            align-items: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 10pt;
            bottom: 0;
            left: 0;
            position: relative;
            width: 100%;
        }

        .linha-pontilhada {
            display: flex;
            align-items: center;
        }

        .pontilhado2 {
            border-bottom: 1px solid gray;
            flex: 1;
            margin: 0 4px;
        }

        .uso {
            white-space: nowrap;
        }

        #btn-imprimir {
            font-size: 1.2rem;
            padding: 15px;
            border-radius: 10px;
        }

        /* Estilo específico para impressão */
        @media print {
            #btn-imprimir {
                display: none;
            }

            /* esconde o botão na hora da impressão */
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <h2><?= esc($info_clinica['nome_clinica'] ?? '') ?></h2>
        <div><?= esc($veterinario['nome']) ?></div>
        <div>CRMV: <?= esc($veterinario['crmv']) ?></div>
        <div style="font-size: 10px;">
            <br>
            <?= esc($info_clinica['rua'] ?? '') ?>, <?= esc($info_clinica['numero'] ?? '') ?> - <?= esc($info_clinica['complemento']  ?? '') ?>
            <?= esc($info_clinica['cep'] ?? '') ?> - <?= esc($info_clinica['bairro'] ?? '') ?> - <?= esc($info_clinica['cidade'] ?? '') ?> - <?= esc($info_clinica['uf'] ?? '') ?>
            <br>
            Tel: <?= esc($info_clinica['telefone'] ?? '') ?> - Cel.: <?= esc($info_clinica['celular'] ?? '') ?> - Whatsapp: <?= esc($info_clinica['whatsapp'] ?? '') ?>
            <?= esc($info_clinica['email'] ?? '') ?>
        </div>

        <hr>
    </div>

    <!-- Tipo de prescrição -->
    <?php if (esc($prescricao['tipo_prescricao']) != 'Simples'): ?>
        <div class="center">
            <strong>Receita de <?= esc($prescricao['tipo_prescricao']) ?>:</strong>
            <strong> 1&ordf; Via para Farmácia - 2&ordf; Via para Paciente</strong>
        </div>
        <!-- Informações Animal / Tutor -->
        <?= view('prescricoes/animal_tutor_controlada') ?>

    <?php else: ?>
        <div class="center"><strong>Receita <?= esc($prescricao['tipo_prescricao']) ?></strong></div>
        <!-- Informações Animal / Tutor -->
        <?= view('prescricoes/animal_tutor_simples') ?>
    <?php endif; ?>




    <!-- Medicamentos -->
    <?php foreach ($medicamentosPorVia as $via => $meds): ?>
        <table class="med-table2">
            <tr>
                <td colspan="3" class="linha-pontilhada">
                    <span class="uso"><strong>USO <?= mb_strtoupper($via, "UTF-8") ?>: </strong></span>
                    <span class="pontilhado2"></span>
                </td>
            </tr>
        </table>
        <table class="med-table">
            <?php foreach ($meds as $med): ?>
                <tr>
                    <td colspan="3">
                        <span class="tipo-farmacia">Farmácia <?= esc($med['tipo_farmacia']) ?></span>
                        <span class="pontilhado"></span>
                        <span class="quantidade"><?= esc($med['quantidade']) ?> <?= ($med['quantidade'] > 1 ? 'UNIDADES' : 'UNIDADE') ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;"><?= esc($med['nome_medicamento']) ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?= esc($med['posologia']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <!-- Instruções gerais -->
    <?php if (!empty($prescricao['instrucoes_gerais'])): ?>
        <div><strong>INSTRUÇÕES GERAIS DO TRATAMENTO</strong></div>
        <div><?= nl2br(esc($prescricao['instrucoes_gerais'])) ?></div>
    <?php endif; ?>

    <!-- Rodapé -->
    <div class="footer">
        <?php if (esc($prescricao['tipo_prescricao']) != 'Simples'): ?>
            <?= view('prescricoes/rodape_controlada') ?>
        <?php else: ?>
            <?= view('prescricoes/rodape_simples') ?>
        <?php endif; ?>
        <button id="btn-imprimir" onclick="window.print()">🖨️ Imprimir / Salvar em PDF</button>
    </div>










</body>

</html>