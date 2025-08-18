<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Novo Atendimento</h1>
<?= view('exames/_form') ?>
<?= $this->endSection() ?>