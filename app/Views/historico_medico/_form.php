<form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>

    <div class="card card-primary">
        <div class="card-body">

            <input type="hidden" name="pet_id" value="<?= esc($pet_id ?? ($historico['pet_id'] ?? '')) ?>">

            <div class="form-group">
                <label for="data_consulta">Data da Consulta</label>
                <input type="date" name="data_consulta" id="data" class="form-control"
                    value="<?= old('data_consulta', isset($historico) ? $historico['data_consulta'] : '') ?>" required>
            </div>

            <div class="form-group">
                <label for="veterinario_id">Veterinário Responsável</label>
                <select name="veterinario_id" id="veterinario_id" class="form-control">
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
                <textarea name="sinais_clinicos" class="form-control"><?= esc($historico['sinais_clinicos'] ?? '') ?></textarea>
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
    </div>
</form>