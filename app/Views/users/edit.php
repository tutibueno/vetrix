<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Editar Usuário</h1>
        <?php
        $title = "Editar usuário";
        $action = base_url('users/update/' . $user['id']);
        $isEdit = true;
        echo view('users/_form', compact('title', 'action', 'user', 'perfis', 'isEdit'));
        ?>
    </div>
</section>
<?= $this->endSection() ?>