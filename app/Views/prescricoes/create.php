<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4>Nova Prescrição</h4>

<?= view('prescricoes/_form', [
    'action' => $action,
    'prescricao' => null,
    'medicamentos' => [],
    'pet_id' => $pet_id,
    'veterinarios' => $veterinarios
]) ?>

<?= $this->endSection() ?>