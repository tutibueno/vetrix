<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Editar Usuário</h1>
        <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post">
            <div class="form-group">
                <label>Usuário (username)</label>
                <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
            </div>
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
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>