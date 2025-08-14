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

        .cabecalho {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .linha {
            display: flex;
            justify-content: space-between;
        }

        .titulo-secao {
            font-weight: bold;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .medicamento-nome {
            font-weight: bold;
        }

        .rodape {
            margin-top: 20px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="cabecalho">
        <div>CLÍNICA VETERINÁRIA</div>
        <div><?= esc($veterinario['nome']) ?></div>
        <div>CRMV: <?= esc($veterinario['crmv']) ?></div>
    </div>

    <div class="titulo-secao" style="text-align: center;">
        Receita <?= esc($prescricao['tipo_prescricao']) ?>
    </div>

    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td width="50%" valign="top">
                <strong>Animal</strong><br>
                Nome: <?= esc($pet['nome']) ?><br>
                Espécie: <?= esc($pet['especie']) ?><br>
                Sexo: <?= esc($pet['sexo']) ?><br>
                Idade: <?= esc($idade_pet) ?><br>
            </td>
            <td width="50%" valign="top">
                <strong>Tutor</strong><br>
                <?= esc($cliente['nome']) ?><br>
                CPF: <?= esc($cliente['cpf_cnpj']) ?><br>
                <?= esc($cliente['rua']) ?>, <?= esc($cliente['numero']) ?> <?= esc($cliente['complemento']) ?><br>
                <?= esc($cliente['cidade']) ?> - CEP: <?= esc($cliente['cep']) ?><br>
            </td>
        </tr>
    </table>

    <?php foreach ($medicamentos_por_via as $via => $lista): ?>
        <div class="titulo-secao">USO <?= esc(strtoupper($via)) ?>:</div>
        <?php foreach ($lista as $med): ?>
            Farmácia: <?= esc($med['tipo_farmacia']) ?>
            __________________________________________ <?= esc($med['quantidade']) ?>
            <?= ($med['quantidade'] > 1 ? 'UNIDADES' : 'UNIDADE') ?><br>

            <div class="medicamento-nome"><?= esc($med['nome_medicamento']) ?></div>
            <div><?= nl2br(esc($med['posologia'])) ?></div>
            <br>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <?php if (!empty($prescricao['instrucoes_gerais'])): ?>
        <div class="titulo-secao">INSTRUÇÕES GERAIS DO TRATAMENTO</div>
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