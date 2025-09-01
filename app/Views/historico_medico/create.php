<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Novo Atendimento</h1>
<?= view('historico_medico/_form') ?>
<?= $this->endSection() ?>