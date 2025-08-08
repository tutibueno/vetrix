<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Clientes</h1>
    <a href="<?= site_url('client/create') ?>" class="btn btn-primary mb-3">Novo Cliente</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Buscar cliente por nome ou CPF/CNPJ" value="<?= esc($search) ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF/CNPJ</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= esc($client['nome']) ?></td>
                    <td><?= esc($client['cpf_cnpj']) ?></td>
                    <td><?= esc($client['telefone']) ?></td>
                    <td><?= esc($client['email']) ?></td>
                    <td>
                        <a href="<?= site_url('client/edit/' . $client['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= site_url('client/delete/' . $client['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <div class="mt-3">
            <?= $pager->links() ?>
        </div>

    </table>
</div>

<?= $this->endSection() ?>