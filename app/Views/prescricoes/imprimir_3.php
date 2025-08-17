<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prescrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;

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
        }

        .med-table {
            width: 100%;
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
    </style>
    <style type="text/css">
        thead:before,
        thead:after {
            display: none;
        }

        tbody:before,
        tbody:after {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <h2>CLÍNICA VETERINÁRIA</h2>
        <div><?= esc($veterinario['nome']) ?></div>
        <div>CRMV: <?= esc($veterinario['crmv']) ?></div>
        <div style="font-size: 10px;">
            <br>
            <?= esc($info_clinica['rua']) ?>, <?= esc($info_clinica['numero']) ?><?= $info_clinica['complemento'] ? ' ' . esc($info_clinica['complemento']) : '' ?>
            <?= esc($info_clinica['cep']) ?> - <?= esc($info_clinica['bairro']) ?> - <?= esc($info_clinica['cidade']) ?> - <?= esc($info_clinica['uf']) ?>
            <br>
            Tel: <?= esc($info_clinica['telefone']) ?> - Cel.: <?= esc($info_clinica['celular']) ?> - Whatsapp: <?= esc($info_clinica['whatsapp']) ?>
            <?= esc($info_clinica['email']) ?>
        </div>

        <hr>
    </div>

    <!-- Tipo de prescrição -->
    <div class="center"><strong>Receita <?= esc($prescricao['tipo_prescricao']) ?></strong></div>


    <!-- Informações Animal / Tutor -->
    <table class="info-table">
        <tr>
            <td style="text-align: center;">
                <div class="info-title">Animal</div>
                Nome: <?= esc($pet['nome']) ?><br>
                Espécie: <?= esc($pet['especie']) ?><br>
                <?php if (!empty($pet['sexo'])): ?>
                    Sexo: <?= esc($pet['sexo']) ?><br>
                <?php endif; ?>
                <?php if (!empty($idade_pet)): ?>
                    Idade: <?= $idade_pet ?><br>
                <?php endif; ?>
            </td>
            <td style="text-align: center;">
                <div class="info-title">Tutor</div>
                <?= esc($cliente['nome']) ?><br>
                <?= esc($cliente['cpf_cnpj']) ?><br>
                <?= esc($cliente['rua']) ?>, <?= esc($cliente['numero']) ?> <?= esc($cliente['complemento']) ?><br>
                <?= esc($cliente['cidade']) ?> <?= esc($cliente['cep']) ?><br>
            </td>
        </tr>

    </table>


    <!-- Medicamentos -->
    <?php foreach ($medicamentosPorVia as $via => $meds): ?>
        <table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
            <tr>
                <td style="width:25%; text-align:left;"><strong>USO <?= mb_strtoupper($via, "UTF-8") ?>: </strong></td>
                <td style="border-bottom:1px solid #000;">&nbsp;</td>
            </tr>
        </table>
        <?php foreach ($meds as $med): ?>
            <table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
                <tr>
                    <td style="width:20%; text-align:left;">Farmácia <?= esc($med['tipo_farmacia']) ?></td>
                    <td style="border-bottom:1px dotted #000;">&nbsp;</td>
                    <td style="width:30%; text-align:left;"><?= esc($med['quantidade']) ?> <?= ($med['quantidade'] > 1 ? 'UNIDADES' : 'UNIDADE') ?></td>
                </tr>
                <tr>
                    <td style="width:100%; font-weight: bold;"><?= esc($med['nome_medicamento']) ?></td>
                </tr>
                <tr>
                    <td style="width:100%;"><?= esc($med['posologia']) ?></td>
                </tr>
            </table>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <!-- Instruções gerais -->
    <?php if (!empty($prescricao['instrucoes_gerais'])): ?>
        <div><strong>INSTRUÇÕES GERAIS DO TRATAMENTO</strong></div>
        <div><?= nl2br(esc($prescricao['instrucoes_gerais'])) ?></div>
    <?php endif; ?>

    <!-- Rodapé -->
    <div class="footer">
        <?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?><br>
        Assinado Digitalmente por:<br>
        <strong><?= esc($veterinario['nome']) ?></strong><br>
        CRMV: <?= esc($veterinario['crmv']) ?><br><br>
    </div>

</body>

<style>
    @page {
        margin: 20px;
        /* ou margin: 10px 20px 10px 20px */
    }

    body {
        margin: 0;
        padding: 0;
    }
</style>

</html>