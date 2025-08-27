<table class="info-table">
    <tr>
        <td style="text-align: center; width: 33%;">
            <div class="info-title">Identificação do Emitente</div>
            Nome: <?= esc($veterinario['nome']) ?><br>
            <?php if (!empty($veterinario['crmv'])): ?>
                CRMV: <?= esc($veterinario['crmv']) ?><br>
            <?php endif; ?>
            <?php if (!empty($veterinario['registro_mapa'])): ?>
                Registro no MAPA: <?= esc($veterinario['registro_mapa']) ?><br>
            <?php endif; ?>
            Endereço: <?= esc($info_clinica['rua'] ?? '') ?>, <?= esc($info_clinica['numero'] ?? '') ?> -
            <?= esc($info_clinica['bairro'] ?? '') ?> - <?= esc($info_clinica['cidade'] ?? '') ?>/<?= esc($info_clinica['uf'] ?? '') ?> CEP: <?= esc($info_clinica['cep'] ?? '') ?>
        </td>
        <td style="text-align: center; width: 33%;">
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
        <td style="text-align: center; width: 33%;">
            <div class="info-title">Tutor</div>
            <?= esc($cliente['nome']) ?><br>
            <?= esc($cliente['cpf_cnpj']) ?><br>
            <?= esc($cliente['rua']) ?>, <?= esc($cliente['numero']) ?> <?= esc($cliente['complemento']) ?><br>
            <?= esc($cliente['cidade']) ?> <?= esc($cliente['cep']) ?><br>
        </td>
    </tr>

</table>