<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Novo Usuário</h1>
        <form action="<?= base_url('users/store') ?>" method="post">
            <div class="form-group">
                <label>Usuário (username)</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>