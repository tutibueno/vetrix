<table class="info-table">
    <tr>
        <td style="text-align: center; width: 50%;">
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
        <td style="text-align: center; width: 50%;">
            <div class="info-title">Tutor</div>
            <?= esc($cliente['nome']) ?><br>
            <?= esc($cliente['cpf_cnpj']) ?><br>
            <?= esc($cliente['rua']) ?>, <?= esc($cliente['numero']) ?> <?= esc($cliente['complemento']) ?><br>
            <?= esc($cliente['cidade']) ?> <?= esc($cliente['cep']) ?><br>
        </td>
    </tr>

</table>