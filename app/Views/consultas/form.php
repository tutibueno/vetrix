<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4"><?= $consulta ? 'Editar Consulta' : 'Agendar Consulta' ?></h1>

    <form method="post" action="<?= $consulta ? site_url('consultas/update/' . $consulta['id']) : site_url('consultas/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group mb-3">
            <label for="pet_id">Pet</label>
            <select name="pet_id" class="form-control" required>
                <option value="">Selecione...</option>
                <?php foreach ($pets as $pet): ?>
                    <option value="<?= $pet['id'] ?>" <?= $consulta && $consulta['pet_id'] == $pet['id'] ? 'selected' : '' ?>>
                        <?= esc($pet['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
            <input type="datetime-local" name="data_consulta" class="form-control"
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
        <a href="<?= site_url('consultas') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>