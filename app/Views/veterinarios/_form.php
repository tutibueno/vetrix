<div class="card-body">
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control"
            value="<?= old('nome', $veterinario['nome'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="crmv">CRMV</label>
        <input type="text" name="crmv" id="crmv" class="form-control"
            value="<?= old('crmv', $veterinario['crmv'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" class="form-control"
            value="<?= old('telefone', $veterinario['telefone'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" class="form-control"
            value="<?= old('email', $veterinario['email'] ?? '') ?>">
    </div>
</div>