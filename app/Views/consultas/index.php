<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Consultas</h1>
    <a href="<?= site_url('consultas/create') ?>" class="btn btn-primary mb-3">
        <i class="fas fa-calendar-plus"></i> Nova Consulta
    </a>

    <div class="row">
        <?php foreach ($consultas as $c): ?>
            <div class="col-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><i class="fas fa-paw text-primary"></i> <?= esc($c['pet_nome']) ?></h5>
                            <p class="mb-1"><strong>Veterinário:</strong> <?= esc($c['vet_nome']) ?></p>
                            <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($c['data_consulta'])) ?></p>
                            <p class="mb-1"><strong>Status:</strong> <?= ucfirst($c['status']) ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= site_url('consultas/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="<?= site_url('consultas/delete/' . $c['id']) ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Deseja cancelar esta consulta?')">
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