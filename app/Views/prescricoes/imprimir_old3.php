<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Prescrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 148mm;
            /* A5 horizontal */
            height: 210mm;
            /* A5 vertical */
            margin: 0;
            padding: 10mm;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .grid {
            text-align: center;
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 10px;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .section-title {
            margin-top: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .rodape {
            margin-top: 20px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div><strong>CLÍNICA VETERINÁRIA</strong></div>
        <div><?= esc($veterinario['nome']) ?></div>
        <div>CRMV: <?= esc($veterinario['crmv']) ?></div>
    </div>

    <div class="line"></div>

    <div>
        <strong>Receita <?= esc($prescricao['tipo_prescricao']) ?></strong>
    </div>

    <div class="grid">
        <div class="center">
            <div><strong>Animal</strong></div>
            Nome: <?= esc($pet['nome']) ?><br>
            Espécie: <?= esc($pet['especie']) ?><br>
            Sexo: <?= esc($pet['sexo']) ?><br>
            Idade: <?= esc($idade_pet) ?>
        </div>
        <div class="center">
            <div><strong>Tutor</strong></div>
            <?= esc($cliente['nome']) ?><br>
            CPF: <?= esc($cliente['cpf_cnpj']) ?><br>
            <?= esc($cliente['rua'] . ', ' . $cliente['numero'] . ' ' . $cliente['complemento']) ?><br>
            <?= esc($cliente['cidade'] . ' - CEP: ' . $cliente['cep']) ?>
        </div>
    </div>

    <?php foreach ($medicamentos_por_via as $via => $meds): ?>
        <div class="section-title">USO <?= strtoupper($via) ?>:</div>
        <?php foreach ($meds as $med): ?>
            <div>Farmácia <?= esc($med['tipo_farmacia']) ?> ___________________________ <?= esc($med['quantidade']) ?> <?= ($med['quantidade'] > 1 ? 'UNIDADES' : 'UNIDADE') ?></div>
            <div class="bold"><?= esc($med['nome_medicamento']) ?></div>
            <div><?= esc($med['posologia']) ?></div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <?php if (!empty($prescricao['instrucoes_gerais'])): ?>
        <div class="section-title">INSTRUÇÕES GERAIS DO TRATAMENTO</div>
        <div><?= nl2br(esc($prescricao['instrucoes_gerais'])) ?></div>
    <?php endif; ?>

    <div class="rodape">
        <?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?><br>
        Assinado Digitalmente por:<br>
        <?= esc($veterinario['nome']) ?><br>
        CRMV: <?= esc($veterinario['crmv']) ?>
    </div>

</body>

</html>