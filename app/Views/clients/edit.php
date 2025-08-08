<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Editar Cliente</h1>
    <form action="<?= site_url('client/update/' . $client['id']) ?>" method="post">
        <?= csrf_field() ?>

        <?= view('clients/_form', ['client' => $client]) ?>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="<?= site_url('client') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>