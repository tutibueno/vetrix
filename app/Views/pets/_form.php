<?php $errors = session('errors');
$pet = $pet ?? []; ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tutor (Cliente)</label>
            <select name="cliente_id" class="form-control <?= isset($errors['cliente_id']) ? 'is-invalid' : '' ?>">
                <option value="">Selecione</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>" <?= old('cliente_id', $pet['cliente_id'] ?? '') == $cliente['id'] ? 'selected' : '' ?>>
                        <?= esc($cliente['nome']) ?>
                    </option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback"><?= $errors['cliente_id'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Nome do Pet</label>
            <input type="text" name="nome" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>" value="<?= old('nome', $pet['nome'] ?? '') ?>">
            <div class="invalid-feedback"><?= $errors['nome'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Espécie</label>
            <input type="text" name="especie" class="form-control <?= isset($errors['especie']) ? 'is-invalid' : '' ?>" value="<?= old('especie', $pet['especie'] ?? '') ?>">
            <div class="invalid-feedback"><?= $errors['especie'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Raça</label>
            <input type="text" name="raca" class="form-control" value="<?= old('raca', $pet['raca'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Sexo</label>
            <select name="sexo" class="form-control <?= isset($errors['sexo']) ? 'is-invalid' : '' ?>">
                <option value="">Selecione</option>
                <option value="M" <?= old('sexo', $pet['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Macho</option>
                <option value="F" <?= old('sexo', $pet['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Fêmea</option>
            </select>
            <div class="invalid-feedback"><?= $errors['sexo'] ?? '' ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Cor</label>
            <input type="text" name="cor" class="form-control" value="<?= old('cor', $pet['cor'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control <?= isset($errors['data_nascimento']) ? 'is-invalid' : '' ?>" value="<?= old('data_nascimento', $pet['data_nascimento'] ?? '') ?>">
            <div class="invalid-feedback"><?= $errors['data_nascimento'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"><?= old('observacoes', $pet['observacoes'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto do Pet</label><br>
            <input type="file" name="foto" accept="image/*" capture="environment" class="form-control-file">
        </div>

        <?php if (!empty($pet['foto'])): ?>
            <div class="form-group">
                <label>Foto atual:</label><br>
                <img src="<?= base_url('uploads/pets/' . $pet['foto']) ?>" alt="Foto do pet" class="img-thumbnail" width="200">
            </div>
        <?php endif ?>
        
    </div>
</div>