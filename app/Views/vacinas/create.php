<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Nova Vacina</h1>
<?= view('vacinas/_form') ?>
<?= $this->endSection() ?>