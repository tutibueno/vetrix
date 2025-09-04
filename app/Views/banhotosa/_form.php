<?php $errors = session('errors'); ?>
<?php $banho = $banho ?? []; ?>

<form id="formBanhoTosa" action="<?= base_url('banhotosa/store') ?>" method="post">
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><?= isset($banho['id']) ? 'Editar Agendamento' : 'Novo Agendamento' ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
    </div>

    <div class="modal-body">

        <input type="hidden" name="id" value="<?= $banho['id'] ?? '' ?>">

        <!-- Pet -->
        <div class="form-group">
            <label>Pet</label>
            <select name="pet_id" class="form-control <?= isset($errors['pet_id']) ? 'is-invalid' : '' ?>" required>
                <option value="">Selecione...</option>
                <?php foreach ($pets as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= (isset($banho['pet_id']) && $banho['pet_id'] == $p['id']) ? 'selected' : '' ?>>
                        <?= $p['nome'] ?> (<?= $p['cliente_nome'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?= $errors['pet_id'] ?? '' ?></div>
        </div>

        <!-- Serviço -->
        <div class="form-group">
            <label>Serviço</label>
            <select name="servico_id" class="form-control <?= isset($errors['servico_id']) ? 'is-invalid' : '' ?>" required>
                <option value="">Selecione o serviço...</option>
                <?php foreach ($servicos as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= (isset($banho['servico_id']) && $banho['servico_id'] == $s['id']) ? 'selected' : '' ?>>
                        <?= $s['nome_servico'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?= $errors['servico_id'] ?? '' ?></div>
        </div>

        <!-- Data e Hora -->
        <div class="form-group">
            <label>Data e Hora</label>
            <input type="datetime-local" name="data_agendamento" class="form-control <?= isset($errors['data_agendamento']) ? 'is-invalid' : '' ?>"
                value="<?= isset($banho['data_agendamento']) ? date('Y-m-d\TH:i', strtotime($banho['data_agendamento'])) : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['data_agendamento'] ?? '' ?></div>
        </div>

        <!-- Duração -->
        <div class="form-group">
            <label>Duração (minutos)</label>
            <input type="number" name="duracao_minutos" class="form-control <?= isset($errors['duracao_minutos']) ? 'is-invalid' : '' ?>"
                value="<?= $banho['duracao_minutos'] ?? 60 ?>" min="30" max="480" step="15" required>
            <small class="form-text text-muted">Escolha a duração do serviço (30 a 480 minutos)</small>
            <div class="invalid-feedback"><?= $errors['duracao_minutos'] ?? '' ?></div>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control <?= isset($errors['status']) ? 'is-invalid' : '' ?>" required>
                <option value="agendado" <?= (isset($banho['status']) && $banho['status'] == 'agendado') ? 'selected' : '' ?>>Agendado</option>
                <option value="em andamento" <?= (isset($banho['status']) && $banho['status'] == 'em andamento') ? 'selected' : '' ?>>Em Andamento</option>
                <option value="concluido" <?= (isset($banho['status']) && $banho['status'] == 'concluido') ? 'selected' : '' ?>>Concluído</option>
                <option value="cancelado" <?= (isset($banho['status']) && $banho['status'] == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
            </select>
            <div class="invalid-feedback"><?= $errors['status'] ?? '' ?></div>
        </div>

        <!-- Observações -->
        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"><?= $banho['observacoes'] ?? '' ?></textarea>
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?= isset($banho) ? 'Atualizar' : 'Salvar' ?></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>