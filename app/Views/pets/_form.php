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
            <label for="especie">Espécie</label>
            <input type="text" name="especie" id="especie" class="form-control"
                value="<?= old('especie', $pet['especie'] ?? '') ?>"
                list="especiesPadrao" required>
            <datalist id="especiesPadrao">
                <option value="Canino">
                <option value="Felino">
                <option value="Ave">
                <option value="Equino">
            </datalist>
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

        <div class="form-group">
            <label>Peso (Kg)</label>
            <input type="text" name="peso" value="<?= isset($pet['peso']) ? esc($pet['peso']) : '' ?>" class="form-control" placeholder="Ex: 5.20">
        </div>

        <div class="form-group">
            <label>Castrado?</label>
            <select name="castrado" class="form-control">
                <option value="nao" <?= isset($pet['castrado']) && $pet['castrado'] == 'sim' ? '' : 'selected' ?>>Não</option>
                <option value="sim" <?= isset($pet['castrado']) && $pet['castrado'] == 'sim' ? 'selected' : '' ?>>Sim</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alergias</label>
            <textarea name="alergias" class="form-control"><?= isset($pet['alergias']) ? esc($pet['alergias']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label>Número de Identificação (Microchip)</label>
            <input type="text" name="numero_identificacao" value="<?= isset($pet['numero_identificacao']) ? esc($pet['numero_identificacao']) : '' ?>" class="form-control">
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label>Pelagem</label>
            <input type="text" name="pelagem" class="form-control" value="<?= old('pelagem', $pet['pelagem'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control <?= isset($errors['data_nascimento']) ? 'is-invalid' : '' ?>" value="<?= old('data_nascimento', $pet['data_nascimento'] ?? '') ?>">
            <div class="invalid-feedback"><?= $errors['data_nascimento'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Está Vivo?</label>
            <select name="esta_vivo" class="form-control">
                <option value="sim" <?= isset($pet['esta_vivo']) && $pet['esta_vivo'] == 'sim' ? 'selected' : '' ?>>Sim</option>
                <option value="nao" <?= isset($pet['esta_vivo']) && $pet['esta_vivo'] == 'nao' ? 'selected' : '' ?>>Não</option>
            </select>
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

<script>
    $(document).ready(function() {
        // Máscara de peso
        $('input[name="peso"]').mask('000.00', {
            reverse: true
        });

        // Validação simples antes de enviar
        $('form').on('submit', function(e) {
            let peso = $('input[name="peso"]').val();
            let vivo = $('select[name="esta_vivo"]').val();
            let castrado = $('select[name="castrado"]').val();

            // Peso não pode ser negativo ou zero (se informado)
            if (peso && parseFloat(peso) <= 0) {
                alert('O peso deve ser maior que zero.');
                e.preventDefault();
            }

            // Se o pet não está vivo, não faz sentido marcar como castrado = sim
            if (vivo === 'nao' && castrado === 'sim') {
                alert('Um pet falecido não pode estar castrado.');
                e.preventDefault();
            }
        });
    });
</script>

<style>
    .suggestions {
        position: absolute;
        border: 1px solid #ccc;
        background: white;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
    }

    .suggestions div {
        padding: 5px;
        cursor: pointer;
    }

    .suggestions div:hover {
        background: #f0f0f0;
    }
</style>

