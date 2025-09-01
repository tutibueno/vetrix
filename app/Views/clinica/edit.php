<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5>Editar Dados da Clínica</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('clinica/update/' . $clinica['id']) ?>" method="post">
            <?= csrf_field() ?>
            <?= $this->include('clinica/_form') ?>
            <button type="submit" class="btn btn-success mt-3">Salvar</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>