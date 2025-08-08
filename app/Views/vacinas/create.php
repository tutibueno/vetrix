<div class="modal-header">
    <h5 class="modal-title">Nova Vacinação</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="<?= base_url('vacinas/salvar') ?>" method="post">
    <div class="modal-body">
        <input type="hidden" name="pet_id" value="<?= esc($pet_id) ?>">

        <div class="form-group">
            <label>Data da Vacinação</label>
            <input type="date" name="data_aplicacao" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Vacina</label>
            <input type="text" name="nome_vacina" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Reforço (data prevista)</label>
            <input type="date" name="data_reforco" class="form-control">
        </div>

        <div class="form-group">
            <label>Veterinário</label>
            <input type="text" name="veterinario" class="form-control">
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>