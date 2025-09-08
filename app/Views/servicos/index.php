<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Serviços de Banho & Tosa</h3>
    <a href="<?= base_url('servicos/create') ?>" class="btn btn-primary">Novo Serviço</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Duração Padrão</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($servicos as $s): ?>
            <tr>
                <td><?= esc($s['nome_servico']) ?></td>
                <td><?= $s['duracao_padrao'] ?> min</td>
                <td>R$ <?= number_format($s['preco'], 2, ',', '.') ?></td>
                <td>
                    <a href="<?= base_url("servicos/edit/{$s['id']}") ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="<?= base_url("servicos/delete/{$s['id']}") ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>

<?= $this->endSection() ?>