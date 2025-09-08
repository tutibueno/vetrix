<?= csrf_field() ?>
<?php
$escala = [
    '' => 'Selecione',
    '1' => '01 - Muito magro',
    '2' => '02 - Magro',
    '3' => '03 - Abaixo do  ideal',
    '4' => '04 - Magro leve',
    '5' => '05 - Ideal',
    '6' => '06 - Levemente acima do peso',
    '7' => '07 - Sobrepeso',
    '8' => '08 - Obeso',
    '9' => '09 - Muito Obeso'
];
?>
<div class="modal-body">
    <input type="hidden" name="pet_id" value="<?= esc($pet['id'] ?? $peso['pet_id'] ?? '') ?>">

    <div class="mb-3">
        <label for="data_registro" class="form-label">Data do registro</label>
        <input type="date" name="data_registro" id="data_registro" class="form-control"
            value="<?= esc($peso['data_registro'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="peso_kg" class="form-label">Peso (kg)</label>
        <input type="number" step="0.001" name="peso_kg" id="peso_kg" class="form-control"
            value="<?= esc($peso['peso_kg'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="escala_condicao_corporal" class="form-label">Escore de Condição Corporal (opcional)</label>
        <select name="escala_condicao_corporal" id="escala_condicao_corporal" class="form-select">
            <?php foreach ($escala as $key => $label): ?>
                <option value="<?= $key ?>" <?= isset($peso['escala_condicao_corporal']) && $peso['escala_condicao_corporal'] == $key ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
        <div id="descricaoECC" class="form-text mt-1"></div>
    </div>

    <div class="mb-3">
        <label for="observacoes" class="form-label">Observações (opcional)</label>
        <textarea name="observacoes" id="observacoes" class="form-control" rows="3"><?= esc($peso['observacoes'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</div>

<script>
    function initECC() {
        const escalaDescr = {
            "1": "Muito magro – Caquético, ossos visíveis, sem gordura palpável",
            "2": "Magro – Ossos evidentes, pouca massa muscular",
            "3": "Abaixo do ideal – Costelas fáceis de ver, pouca cobertura de gordura",
            "4": "Magro leve – Costelas palpáveis com pouca gordura, cintura evidente",
            "5": "Ideal – Costelas palpáveis sem excesso de gordura, boa proporção",
            "6": "Levemente acima do peso – Costelas palpáveis com leve excesso de gordura",
            "7": "Sobrepeso – Costelas difíceis de sentir, acúmulo de gordura abdominal",
            "8": "Obeso – Depósitos significativos de gordura, cintura pouco visível",
            "9": "Muito obeso – Obesidade severa, sem cintura, abdômen proeminente"
        };

        const select = document.getElementById('escala_condicao_corporal');
        const descricaoDiv = document.getElementById('descricaoECC');

        if (!select) return;

        function atualizarDescricaoECC() {
            const valor = select.value;
            descricaoDiv.textContent = valor && escalaDescr[valor] ? `${valor}/9 - ${escalaDescr[valor]}` : '';
        }

        select.addEventListener('change', atualizarDescricaoECC);
        atualizarDescricaoECC(); // inicializa se já tiver valor
    }

    // Chame initECC() **após** carregar o modal via AJAX

    // Máscara de peso
    $('input[name="peso_kg"]').mask('000.000', {
        reverse: true
    });
    
</script>