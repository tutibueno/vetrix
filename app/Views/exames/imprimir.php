<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Solicitação_Exame_<?= esc($pet['nome']) ?>_<?= date('d_m_Y', strtotime($solicitacao['data_solicitacao'])) ?></title>
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

        .exame {
            margin-bottom: 10px;
        }

        .exame-nome {
            font-size: 13px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 25px;
            margin-left: 20px;
        }

        .section h4 {
            font-size: 13px;
            margin: 0 0 5px 0;
            border-bottom: 0px solid #ccc;
            padding-bottom: 5px;
            padding-top: 15px;
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

        .footer {
            margin-top: 10px;
            font-size: 10pt;
        }

        .exame-observacao {
            font-size: 13px;
            color: #333;
            margin-left: 15px;
            margin-top: 3px;
        }

        .observacoes {
            border: 1px solid #aaa;
            padding: 10px;
            min-height: 40px;
            font-size: 14px;
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
            <?= esc($info_clinica['rua'] ?? '') ?>, <?= esc($info_clinica['numero'] ?? '') ?> <?= $info_clinica['complemento'] ?? '' ?>
            <?= esc($info_clinica['cep'] ?? '') ?> - <?= esc($info_clinica['bairro'] ?? '') ?> - <?= esc($info_clinica['cidade'] ?? '') ?> - <?= esc($info_clinica['uf'] ?? '') ?>
            <br>
            Tel: <?= esc($info_clinica['telefone'] ?? '') ?> - Cel.: <?= esc($info_clinica['celular'] ?? '') ?> - Whatsapp: <?= esc($info_clinica['whatsapp'] ?? '') ?>
            <?= esc($info_clinica['email'] ?? '') ?>
        </div>

        <hr>
    </div>


    <div class="center"><strong>Solicitação de Exames</strong></div>


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


    <div class="section">
        <h4>SOLICITO OS SEGUINTES EXAMES PARA O ANIMAL ACIMA DESCRITO</h4>
    </div>

    <div class="section">
        <?php if (!empty($exames)): ?>
            <?php foreach ($exames as $ex): ?>
                <div class="exame">
                    <div class="exame-nome">• <?= esc($ex['nome_exame']) ?></div>
                    <?php if (!empty($ex['observacoes'])): ?>
                        <div class="exame-observacao">Obs.:<?= nl2br(esc($ex['observacoes'])) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum exame informado</p>
        <?php endif; ?>
    </div>



    <?php if (!empty($motivos)): ?>
        <div class="section">
            <strong>Motivos / Suspeitas</strong>
            <ul>
                <?php foreach ($motivos as $m): ?>
                    <li><?= esc($m['motivo_suspeita']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <br>
    <!-- Instruções gerais -->

    <?php if (!empty($solicitacao['observacoes'])): ?>
        <div class="section">
            <div><strong>INSTRUÇÕES/OBSERVAÇÕES GERAIS DA SOLICITAÇÃO:</strong></div><br>
            <div><?= nl2br(esc($solicitacao['observacoes'])) ?></div>
        </div>
    <?php endif; ?>


    <br><br>
    <!-- Rodapé -->
    <div class="section">
        <div class="footer">
            <?= date('d/m/Y', strtotime($solicitacao['data_solicitacao'])) ?><br>
            Assinado Digitalmente por:<br>
            <strong><?= esc($veterinario['nome']) ?></strong><br>
            CRMV: <?= esc($veterinario['crmv']) ?><br><br>
        </div>
        <button id="btn-imprimir" onclick="window.print()">🖨️ Imprimir / Salvar em PDF</button>
    </div>


</body>

</html>