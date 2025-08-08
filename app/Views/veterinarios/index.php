<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Veterinários</h3>
        <div class="card-tools">
            <a href="<?= base_url('veterinarios/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Veterinário
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CRMV</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th width="120">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veterinarios as $vet): ?>
                    <tr>
                        <td><?= esc($vet['nome']) ?></td>
                        <td><?= esc($vet['crmv']) ?></td>
                        <td><?= esc($vet['telefone']) ?></td>
                        <td><?= esc($vet['email']) ?></td>
                        <td>
                            <a href="<?= base_url('veterinarios/edit/' . $vet['id']) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('veterinarios/delete/' . $vet['id']) ?>"
                                onclick="return confirm('Tem certeza que deseja excluir?')"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>