<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?? '' ?></h3>
    </div>

    <form action="<?= $action ?>" method="post" id="userForm">
        <?= csrf_field() ?>
        <div class="card-body">

            <div class="form-group">
                <label>Usuário (username)</label>
                <input type="text" name="username" class="form-control"
                    value="<?= old('username', $user['username'] ?? '') ?>"
                    <?= isset($isEdit) && $isEdit ? 'readonly' : 'required' ?>>
            </div>

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control"
                    value="<?= old('name', $user['name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control"
                    value="<?= old('email', $user['email'] ?? '') ?>" required>
            </div>

            <?php if ($currentUser['perfil'] === 'admin'): ?>
                <!-- Admin pode alterar perfil -->
                <div class="form-group">
                    <label>Perfil</label>
                    <select name="perfil" class="form-control">
                        <?php foreach ($perfis as $key => $label): ?>
                            <option value="<?= $key ?>" <?= set_select('perfil', $key, ($user['perfil'] ?? '') === $key) ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if (isset($isEdit) && $isEdit): ?>
                <hr>
                <h5>Alterar senha (opcional)</h5>
                <div class="form-group">
                    <label>Nova senha</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Digite a nova senha">
                </div>
                <div class="form-group">
                    <label>Confirmar nova senha</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control"
                        placeholder="Confirme a nova senha">
                    <small id="passwordHelp" class="form-text text-danger" style="display:none;">
                        As senhas não conferem.
                    </small>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirmar senha</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                    <small id="passwordHelp" class="form-text text-danger" style="display:none;">
                        As senhas não conferem.
                    </small>
                </div>
            <?php endif; ?>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>

<!-- JS validação de senha -->
<script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        let pass = document.getElementById('password');
        let confirm = document.getElementById('password_confirm');
        let help = document.getElementById('passwordHelp');

        if (pass && confirm && pass.value !== confirm.value) {
            e.preventDefault();
            help.style.display = 'block';
            confirm.focus();
        } else if (help) {
            help.style.display = 'none';
        }
    });
</script>