<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Nova Solicitaçao de Exames</h1>
<?= view('exames/_form') ?>
<?= $this->endSection() ?>