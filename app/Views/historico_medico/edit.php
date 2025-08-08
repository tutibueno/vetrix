<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<form action="<?= site_url('historico_medico/update/' . $historico['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?= view('historico_medico/_form', [
        'veterinarios' => $veterinarios,
        'pet_id' => $pet_id
    ]) ?>
</form>

<?= $this->endSection() ?>