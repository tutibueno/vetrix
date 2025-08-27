<form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>

    <!-- Cabeçalho com título -->
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-notes-medical"></i>&nbsp;Atendimento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">



        <input type="hidden" name="pet_id" value="<?= esc($pet_id ?? ($historico['pet_id'] ?? '')) ?>">

        <div class="form-group">
            <label for="data_consulta">Data da Consulta</label>
            <input type="date" name="data_consulta" id="data" class="form-control"
                value="<?= old('data_consulta', $prescricao['data_consulta'] ?? date('Y-m-d')) ?>" required>
        </div>

        <div class="form-group">
            <label for="veterinario_id">Veterinário Responsável</label>
            <select name="veterinario_id" id="veterinario_id" class="form-control" required>
                <option value="">Selecione...</option>
                <?php if (!empty($veterinarios)): ?>
                    <?php foreach ($veterinarios as $vet): ?>
                        <option value="<?= esc($vet['id']) ?>"
                            <?= (isset($historico) && $historico['veterinario_id'] == $vet['id']) ? 'selected' : '' ?>>
                            <?= esc($vet['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- anamnese (antes sintomas) -->
        <div class="form-group">
            <label>Anamnese</label>
            <textarea name="anamnese" class="form-control"><?= esc($historico['anamnese'] ?? '') ?></textarea>
        </div>

        <!-- sinais clínicos -->
        <div class="form-group">
            <label for="sinais_clinicos">Sinais Clínicos</label>
            <textarea id="sinais_clinicos" name="sinais_clinicos" class="form-control"><?= esc($historico['sinais_clinicos'] ?? '') ?></textarea>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="inserirPadrao()">Inserir padrão</button>
        </div>


        <div class="form-group">
            <label for="diagnostico">Diagnóstico</label>
            <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3"><?= old('diagnostico', isset($historico) ? $historico['diagnostico'] : '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="observacoes">Observações</label>
            <textarea name="observacoes" id="observacoes" class="form-control" rows="3"><?= old('observacoes', isset($historico) ? $historico['observacoes'] : '') ?></textarea>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function inserirPadrao() {
        document.getElementById('sinais_clinicos').value =
            "=== Dados do Pet ===\n" +
            "Peso: 0.00 kg\n" +
            "\n" +
            "=== Exame Físico ===\n" +
            "\n" +
            "Geral:\n" +
            "Estado Geral (ativo, apático, etc.):\n" +
            "Estado Nutricional:\n" +
            "Hidratação:\n" +
            "Temperatura Retal:\n" +
            "Frequência Cardíaca:\n" +
            "Frequência Respiratória:\n" +
            "\n" +
            "Mucosas:\n" +
            "Cor (rosa, pálida, etc.): \n" +
            "Tempo de Preenchimento Capilar:\n" +
            "\n" +
            "Pele e Pelagem:\n" +
            "Presença de lesões, parasitas, etc.: \n" +
            "\n" +
            "Olhos:\n" +
            "Claros, opacos, secreção, etc.: \n" +
            "\n" +
            "Orelhas:\n" +
            "Limpas, com secreção, etc.:\n" +
            "\n" +
            "Boca e Dentes:\n" +
            "Estado dos dentes, gengivas, etc.:\n" +
            "\n" +
            "Sistema Respiratório:\n" +
            "Respiração normal, ruidosa, etc.: \n" +
            "\n" +
            "Sistema Cardiovascular:\n" +
            "Batimentos cardíacos regulares, sopros, etc.: \n" +
            "\n" +
            "Sistema Digestório:\n" +
            "Abdômen macio, dolorido, etc.: \n" +
            "\n" +
            "Sistema Geniturinário:\n" +
            "Normal, presença de secreções, etc.: \n" +
            "\n" +
            "Sistema Locomotor:\n" +
            "Andar normal, claudicação, etc.: \n" +
            "\n" +
            "Sistema Nervoso:\n" +
            "Consciente, desorientado, etc.: \n";
    }
</script>
<style>
    textarea {
        min-height: 200px;
        /* Adjust as needed */
    }
</style>