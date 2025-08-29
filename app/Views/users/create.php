<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Novo Usuário</h1>
        <?php
        $title = "Cadastrar novo usuário";
        $action = base_url('users/store');
        $isEdit = false;
        echo view('users/_form', compact('title', 'action', 'perfis', 'isEdit'));
        ?>
    </div>
</section>
<?= $this->endSection() ?>