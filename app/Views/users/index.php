<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

        <h1>Usuários</h1>
        <a href="<?= base_url('users/create') ?>" class="btn btn-primary mb-3">Novo Usuário</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['perfil']) ?></td>
                        <td>
                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

<?= $this->endSection() ?>