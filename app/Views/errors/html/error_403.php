<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid text-center mt-5">
        <h1 class="display-1 text-danger">403</h1>
        <h2>Proibido</h2>
        <p>Você não tem permissão para acessar esta página.</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Voltar para o início</a>
    </div>
</section>
<?= $this->endSection() ?>