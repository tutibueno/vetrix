<div class="modal-header bg-primary text-white">
    <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> <?= $consulta ? 'Editar Consulta' : 'Agendar Consulta' ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
</div>
<div class="container-fluid">
    <form method="post" action="<?= $consulta ? site_url('consultas/update/' . $consulta['id']) : site_url('consultas/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="pet_id">Pet</label>
            <select id="pet_id" name="pet_id" class="form-control" style="width: 100%"></select>
        </div>

        <div class="form-group mb-3">
            <label for="veterinario_id">Veterinário</label>
            <select name="veterinario_id" class="form-control" required>
                <option value="">Selecione...</option>
                <?php foreach ($veterinarios as $vet): ?>
                    <option value="<?= $vet['id'] ?>" <?= $consulta && $consulta['veterinario_id'] == $vet['id'] ? 'selected' : '' ?>>
                        <?= esc($vet['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="data_consulta">Data e Hora</label>
            <input type="datetime-local" name="data_consulta" class="form-control" id="data_consulta"
                value="<?= $consulta ? date('Y-m-d\TH:i', strtotime($consulta['data_consulta'])) : '' ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="motivo">Motivo</label>
            <textarea name="motivo" class="form-control"><?= $consulta['motivo'] ?? '' ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="observacoes">Observações</label>
            <textarea name="observacoes" class="form-control"><?= $consulta['observacoes'] ?? '' ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="agendada" <?= $consulta && $consulta['status'] == 'agendada' ? 'selected' : '' ?>>Agendada</option>
                <option value="realizada" <?= $consulta && $consulta['status'] == 'realizada' ? 'selected' : '' ?>>Realizada</option>
                <option value="cancelada" <?= $consulta && $consulta['status'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Fechar">Cancelar</button>
    </form>
</div>

<script>
    $(function() {
        // Inicializa o Select2 no campo Pet
        $('#pet_id').select2({
            theme: 'bootstrap4',
            placeholder: "Selecione o Pet",
            allowClear: true,
            ajax: {
                url: '<?= base_url("pet/search") ?>', // rota que busca no banco
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // termo digitado
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nome + " (" + item.tutor_nome + ")"
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>

<style>
    .select2-container {
        z-index: 99999 !important;
    }
</style>