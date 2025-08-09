<form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="pet_id" value="<?= esc($pet_id) ?>">

    <div class="form-group">
        <label>Nome da Vacina</label>
        <input type="text" name="nome_vacina" class="form-control" value="<?= esc($vacina['nome_vacina'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Veterinário Responsável</label>
        <select name="veterinario_id" class="form-control" required>
            <option value="">Selecione...</option>
            <?php foreach ($veterinarios as $v): ?>
                <option value="<?= $v['id'] ?>" <?= isset($vacina['veterinario_id']) && $vacina['veterinario_id'] == $v['id'] ? 'selected' : '' ?>>
                    <?= esc($v['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Data de Aplicação</label>
        <input type="date" name="data_aplicacao" class="form-control" value="<?= esc($vacina['data_aplicacao'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Data de Reforço</label>
        <input type="date" name="data_reforco" class="form-control" value="<?= esc($vacina['data_reforco'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Observações</label>
        <textarea name="observacoes" class="form-control"><?= esc($vacina['observacoes'] ?? '') ?></textarea>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>