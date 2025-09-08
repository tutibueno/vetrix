<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Editar Veterinário</h3>
    </div>

    <form action="<?= base_url('veterinarios/update/' . $veterinario['id']) ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>
        <?= $this->include('veterinarios/_form') ?>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="<?= base_url('veterinarios') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>