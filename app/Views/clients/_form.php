<?php
$errors = session('errors');
$client = $client ?? [];
?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= old('nome', $client['nome'] ?? '') ?>" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= $errors['nome'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>CPF / CNPJ</label>
            <input type="text" name="cpf_cnpj" value="<?= old('cpf_cnpj', $client['cpf_cnpj'] ?? '') ?>" class="form-control <?= isset($errors['cpf_cnpj']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= $errors['cpf_cnpj'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" value="<?= old('telefone', $client['telefone'] ?? '') ?>" class="form-control <?= isset($errors['telefone']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= $errors['telefone'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= old('email', $client['email'] ?? '') ?>" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" value="<?= old('data_nascimento', $client['data_nascimento'] ?? '') ?>" class="form-control <?= isset($errors['data_nascimento']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= $errors['data_nascimento'] ?? '' ?></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>CEP</label>
            <input type="text" name="cep" value="<?= old('cep', $client['cep'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Rua</label>
            <input type="text" name="rua" value="<?= old('rua', $client['rua'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Número</label>
            <input type="text" name="numero" value="<?= old('numero', $client['numero'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Bairro</label>
            <input type="text" name="bairro" value="<?= old('bairro', $client['bairro'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Cidade</label>
            <input type="text" name="cidade" value="<?= old('cidade', $client['cidade'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Estado</label>
            <input type="text" name="estado" maxlength="2" value="<?= old('estado', $client['estado'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control" rows="3"><?= old('observacoes', $client['observacoes'] ?? '') ?></textarea>
        </div>
    </div>
</div>