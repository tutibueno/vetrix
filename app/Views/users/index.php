<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Usuários</h1>
    <a href="<?= site_url('users/create') ?>" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus"></i> Novo Usuário
    </a>

    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Buscar usuário por nome, email ou username" value="<?= esc($search ?? '') ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php foreach ($users as $user): ?>
            <?php
            // Formatar data de cadastro
            $dataCadastro = isset($user['created_at'])
                ? date('d/m/Y H:i', strtotime($user['created_at']))
                : '—';
            ?>
            <div class="col-12 mb-3">
                <div class="card shadow-sm position-relative">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="fas fa-user text-primary"></i> <?= esc($user['name']) ?>
                            </h5>
                            <p class="card-text mb-1"><strong>Username:</strong> <?= esc($user['username']) ?></p>
                            <p class="card-text mb-1"><strong>Email:</strong> <?= esc($user['email']) ?></p>
                            <p class="card-text mb-1"><strong>Perfil:</strong> <?= esc($user['perfil']) ?></p>
                            <p class="card-text mb-1 text-muted"><small><strong>Cadastrado em:</strong> <?= esc($dataCadastro) ?></small></p>

                            <a href="<?= site_url('users/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="<?= site_url('users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>