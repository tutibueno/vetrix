<table class="info-table">
    <tr>
        <td style="text-align: center; width: 33%; border: 0px;">
            <?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?><br>
            <strong><?= esc($veterinario['nome']) ?></strong><br>
            CRMV: <?= esc($veterinario['crmv']) ?>
            <?php if (esc($veterinario['registro_mapa'])): ?>
                Registro no MAPA: <?= esc($veterinario['registro_mapa']) ?>
            <?php endif; ?>
            <br><br>
            <p>____________________</p>
            Assinatura
        </td>
        <td style="text-align: left; width: 43%;">
            <div class="info-title">Identificação do Comprador</div>
            <p>Nome:</p>
            <p>RG: </p>
            <p>Cidade e UF: </p>
            Telefone:

        </td>
        <td style="text-align: center; width: 23%;">
            <div class="info-title">Identificação do Fornecedor</div>

            <p style="text-align: left;">Data:</p><br>
            <p>_________________</p>
            Assinatura do Farmacêutico
        </td>
    </tr>

</table>