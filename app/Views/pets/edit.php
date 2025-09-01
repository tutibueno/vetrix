<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h1 class="mt-4">Editar Pet / Paciente</h1>

<form action="<?= site_url('pet/update/' . $pet['id']) ?>" method="post" enctype="multipart/form-data" id="formPet">
    <?= csrf_field() ?>
    <?= view('pets/_form', ['pet' => $pet, 'cliente' => $cliente]) ?>
    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="<?= site_url('pet') ?>" class="btn btn-secondary">Cancelar</a>
</form>


<?= $this->endSection() ?>