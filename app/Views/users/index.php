<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Usuários</h1>
        <a href="<?= base_url('users/create') ?>" class="btn btn-primary mb-3">Novo Usuário</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td>
                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>