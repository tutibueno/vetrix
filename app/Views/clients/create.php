<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Novo Cliente</h1>
    <form action="<?= site_url('client/store') ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>

        <?= view('clients/_form') ?>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= site_url('client') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>