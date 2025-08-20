<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


    <h1 class="mt-4">Cadastrar Pet</h1>

    <form action="<?= site_url('pet/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?= view('pets/_form', ['clientes' => $clientes]) ?>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= site_url('pet') ?>" class="btn btn-secondary">Cancelar</a>
    </form>


<?= $this->endSection() ?>