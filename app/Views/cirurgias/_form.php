<div class="modal-body">
    <input type="hidden" id="pet_id" name="pet_id" value="<?= esc($pet['id'] ?? $cirurgia['pet_id'] ?? '') ?>">

    <div class="form-group">
        <label for="data_cirurgia" class="form-label">Data da Cirurgia</label>
        <input type="date" class="form-control"
            name="data_cirurgia"
            id="data_cirurgia"
            value="<?= esc($cirurgia['data_cirurgia'] ?? date('Y-m-d')) ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="veterinario_id" class="form-label">Veterinário</label>
        <select name="veterinario_id" id="veterinario_id" class="form-control select2" style="width: 100%;" required>
            <?php foreach ($veterinarios as $vet): ?>
                <option value="<?= $vet['id'] ?>"
                    <?= isset($cirurgia) && $cirurgia['veterinario_id'] == $vet['id'] ? 'selected' : '' ?>>
                    <?= esc($vet['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="observacoes" class="form-label">Observações</label>
        <textarea class="form-control" name="observacoes" id="observacoes" rows="3"><?= esc($cirurgia['observacoes'] ?? '') ?></textarea>
    </div>

    <hr>
    <h5>Cirurgias Realizadas</h5>
    <div id="cirurgiasContainer">
        <?php if (!empty($detalhes)): ?>
            <?php foreach ($detalhes as $d): ?>
                <div class="cirurgia-item border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Nome da Cirurgia</label>
                        <input type="text" name="detalhes[nome_cirurgia][]" class="form-control" value="<?= esc($d['nome_cirurgia']) ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Materiais e Implantes</label>
                        <textarea name="detalhes[materiais][]" class="form-control" value="<?= esc($d['materiais']) ?>"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Complicações</label>
                        <input type="text" name="detalhes[complicacoes][]" class="form-control" value="<?= esc($d['complicacoes']) ?>">
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-danger btn-sm btnRemove">
                            <i class="fas fa-trash"></i> Remover
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button type="button" class="btn btn-success btn-sm" id="btnAddCirurgia">
        <i class="fas fa-plus"></i> Adicionar Cirurgia
    </button>

    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Salvar
        </button>
    </div>
</div>

<script>
    $(document).ready(function() {
        // adicionar bloco de cirurgia
        $('#btnAddCirurgia').on('click', function() {
            let bloco = `
                <div class="cirurgia-item border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Nome da Cirurgia</label>
                        <input type="text" name="detalhes[nome_cirurgia][]" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Materiais e Implantes</label>
                        <textarea type="text" name="detalhes[materiais][]" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Complicações</label>
                        <input type="text" name="detalhes[complicacoes][]" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-danger btn-sm btnRemove">
                            <i class="fas fa-trash"></i> Remover
                        </button>
                    </div>
                </div>`;
            $('#cirurgiasContainer').append(bloco);
        });

        // remover bloco
        $(document).on('click', '.btnRemove', function() {
            $(this).closest('.cirurgia-item').remove();
        });
    });
</script>