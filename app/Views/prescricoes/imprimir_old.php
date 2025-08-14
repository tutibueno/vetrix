<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Impressão de Prescrição</title>
    <style>
        @page {
            size: A5;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .prescricao-container {
            position: relative;
            width: 210mm;
            height: 148.5mm;
            /* Meia página A4 */
            padding: 15mm;
            box-sizing: border-box;
        }

        /* Cabeçalho */
        .header {
            position: absolute;
            top: 5mm;
            left: 15mm;
            font-size: 14px;
            font-weight: bold;
            width: 180mm;
            border-bottom: 1px solid #000;
            padding-bottom: 2mm;
        }

        /* Tipo de prescrição */
        .tipo-prescricao {
            position: absolute;
            top: 20mm;
            left: 15mm;
            font-weight: bold;
        }

        /* Dados Animal / Tutor */
        .pet-tutor {
            position: absolute;
            top: 30mm;
            left: 15mm;
            right: 15mm;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10mm;
        }

        .pet-tutor div {
            line-height: 1.4em;
        }

        /* Lista de medicamentos */
        .medicamentos {
            position: absolute;
            top: 60mm;
            left: 15mm;
            right: 15mm;
        }

        .via {
            margin-top: 3mm;
            font-weight: bold;
            text-transform: uppercase;
        }

        .medicamento {
            margin-bottom: 3mm;
        }

        .medicamento strong {
            display: block;
        }

        /* Instruções gerais */
        .instrucoes {
            position: absolute;
            top: 110mm;
            left: 15mm;
            right: 15mm;
        }

        .instrucoes-title {
            font-weight: bold;
            margin-bottom: 2mm;
        }

        /* Rodapé */
        .footer {
            position: absolute;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            font-size: 12px;
        }

        .assinatura {
            margin-top: 3mm;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="prescricao-container">

        <!-- Cabeçalho -->
        <div class="header">
            <?= esc($prescricao['veterinario_nome']) ?>
        </div>

        <!-- Tipo de Prescrição -->
        <div class="tipo-prescricao">
            <?= esc($prescricao['tipo_prescricao']) ?>
        </div>

        <!-- Dados Pet / Tutor -->
        <div class="pet-tutor">
            <div>
                <strong>Animal:</strong> <?= esc($prescricao['pet_nome']) ?><br>
                <strong>Espécie:</strong> <?= esc($prescricao['pet_especie']) ?><br>
                <strong>Sexo:</strong> <?= esc($prescricao['pet_sexo']) ?><br>
                <strong>Idade:</strong> <?= esc($prescricao['age']) ?> anos, <?= esc($prescricao['months_remaining']) ?> meses
            </div>
            <div>
                <strong>Tutor:</strong> <?= esc($prescricao['tutor_nome']) ?><br>
                <strong>CPF:</strong> <?= esc($prescricao['tutor_cpf']) ?><br>
                <strong>Endereço:</strong> <?= esc($prescricao['tutor_endereco']) ?><br>
                <strong>Cidade/CEP:</strong> <?= esc($prescricao['tutor_cep']) ?>
            </div>
        </div>

        <!-- Lista de medicamentos -->
        <div class="medicamentos">
            <?php foreach ($medicamentos as $med): ?>
                <div class="medicamento">
                    <?= esc($med['tipo_farmacia']) ?> — <?= esc($med['quantidade']) ?> <?= ($med['quantidade'] > 1 ? 'UNIDADES' : 'UNIDADE') ?><br>
                    <strong><?= esc($med['nome_medicamento']) ?></strong>
                    <?= esc($med['posologia']) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Instruções gerais -->
        <div class="instrucoes">
            <div class="instrucoes-title">INSTRUÇÕES GERAIS DO TRATAMENTO</div>
            <?= nl2br(esc($prescricao['instrucoes_gerais'])) ?>
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?><br>
            <div class="assinatura">
                Assinado Digitalmente por:<br>
                <?= esc($prescricao['veterinario_nome']) ?><br>
                CRMV: <?= esc($prescricao['veterinario_crmv']) ?>
            </div>
        </div>

    </div>
</body>

</html>