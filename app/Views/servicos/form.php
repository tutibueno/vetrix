<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3><?= $servico ? 'Editar Serviço' : 'Novo Serviço' ?></h3>

<form action="<?= base_url('servicos/store') ?>" method="post">
    <input type="hidden" name="id" value="<?= $servico['id'] ?? '' ?>">

    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome_servico" class="form-control" value="<?= $servico['nome_servico'] ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duração Padrão (minutos)</label>
        <input type="number" name="duracao_padrao" class="form-control" value="<?= $servico['duracao_padrao'] ?? '' ?>" min="30" step="30">
    </div>

    <div class="mb-3">
        <label class="form-label">Preço (R$)</label>
        <input type="number" step="0.01" name="preco" class="form-control" value="<?= $servico['preco'] ?? '' ?>">
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="<?= base_url('servicos') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>