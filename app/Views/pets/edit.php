<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h1 class="mt-4">Editar Pet</h1>

<form action="<?= site_url('pet/update/' . $pet['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?= view('pets/_form', ['pet' => $pet, 'clientes' => $clientes]) ?>
    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="<?= site_url('pet') ?>" class="btn btn-secondary">Cancelar</a>
</form>


<?= $this->endSection() ?>