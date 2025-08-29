<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Lista de Veterinários</h3>
        <div class="card-tools">
            <a href="<?= base_url('veterinarios/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Veterinário
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($veterinarios)): ?>
                <?php foreach ($veterinarios as $vet): ?>
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm position-relative">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="fas fa-user-md text-primary"></i> <?= esc($vet['nome']) ?>
                                    </h5>
                                    <p class="card-text mb-1"><strong>CRMV:</strong> <?= esc($vet['crmv']) ?></p>
                                    <p class="card-text mb-1"><strong>Telefone:</strong> <?= esc($vet['telefone']) ?></p>
                                    <p class="card-text mb-1"><strong>Email:</strong> <?= esc($vet['email']) ?></p>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="<?= base_url('veterinarios/edit/' . $vet['id']) ?>" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= base_url('veterinarios/delete/' . $vet['id']) ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir?')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Nenhum veterinário cadastrado.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>