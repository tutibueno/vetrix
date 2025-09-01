<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4>Editar Prescrição #<?= esc($prescricao['id']) ?></h4>

<?= view('prescricoes/_form', [
    'action' => $action,
    'prescricao' => $prescricao,
    'medicamentos' => $medicamentos,
    'pets' => $pets,
    'veterinarios' => $veterinarios
]) ?>

<?= $this->endSection() ?>